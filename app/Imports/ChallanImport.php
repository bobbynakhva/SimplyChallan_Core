<?php

namespace App\Imports;

use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\Company;
use App\Models\Purpose;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChallanImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $company_id = Session::get('company_id'); // Logged in company
        $financial_year_id = Session::get('financial_year_id');

        // Group rows by unique identifier: 'challan_ref' + 'client_gstin' + 'vehicle_no'
        $grouped = $rows->groupBy(function ($item) {
            $gst = trim($item['client_gstin'] ?? 'no-gst');
            return ($item['challan_ref'] ?? '') . '-' . $gst . '-' . ($item['vehicle_no'] ?? '');
        });

        foreach ($grouped as $group) {
            $first = $group->first();
            
            // 1. Find or create Client (Company) via GST
            $gstNumber = trim($first['client_gstin'] ?? '');
            if (empty($gstNumber)) continue; 

            $client = Company::where('user_id', $company_id)
                ->where('industry_gstin', $gstNumber)
                ->first();

            if (!$client) {
                $clientName = trim($first['client_name'] ?? '');
                if (empty($clientName)) continue; 

                $client = Company::create([
                    'user_id' => $company_id,
                    'industry_name' => $clientName,
                    'industry_number' => $first['client_number'] ?? '',
                    'industry_gstin' => $gstNumber,
                    'industry_address' => $first['client_address'] ?? '',
                ]);
            }

            // 2. Find Purpose
            $purposeName = trim($first['purpose'] ?? '');
            $purpose = Purpose::where('name', 'LIKE', '%' . $purposeName . '%')->first();
            if (!$purpose) {
                $purpose = Purpose::first(); 
            }

            // 3. Prepare Header Data
            // Date defaults to today if not in excel
            $date = !empty($first['date']) ? $this->transformDate($first['date']) : now();
            $vehicleNo = $first['vehicle_no'] ?? '';
            $noOfPackages = $first['no_of_packages'] ?? '';
            
            // Tax defaults to 9% each if not provided
            $cgst = !empty($first['cgst_percent']) ? floatval($first['cgst_percent']) : 9.0;
            $sgst = !empty($first['sgst_percent']) ? floatval($first['sgst_percent']) : 9.0;

            // Generate unique challan number
            $challan_no = Challan::generateChallanNumber();

            DB::beginTransaction();
            try {
                $challan = Challan::create([
                    'challan_number' => $challan_no,
                    'date' => $date,
                    'purpose_id' => $purpose->id,
                    'user_id' => $company_id,
                    'company_id' => $client->id,
                    'financial_year_id' => $financial_year_id,
                    'industry_name' => $client->industry_name,
                    'industry_number' => $client->industry_number,
                    'industry_gstin' => $client->industry_gstin,
                    'industry_address' => $client->industry_address,
                    'vehicle_no' => $vehicleNo,
                    'no_of_packages' => $noOfPackages,
                    'cgst' => $cgst,
                    'sgst' => $sgst,
                    'total_tax' => 0, // Will calculate below
                    'grand_total' => 0, // Will calculate below
                ]);

                $totalValue = 0;
                foreach ($group as $itemRow) {
                    $itemQty = floatval($itemRow['qty'] ?? 0);
                    $itemPrice = floatval($itemRow['price_per_kg'] ?? 0);
                    $subTotal = $itemQty * $itemPrice;
                    $totalValue += $subTotal;

                    $challan->items()->create([
                        'item_name' => $itemRow['item_name'] ?? 'Item',
                        'hsn_code' => $itemRow['hsn_code'] ?? '',
                        'price_per_kg' => $itemPrice,
                        'total_qty' => $itemQty,
                        'total_value' => $subTotal,
                        'piece_no' => $itemRow['piece_no'] ?? null,
                    ]);
                }

                // Update Tax and Grand Total
                $taxAmount = ($totalValue * ($cgst + $sgst)) / 100;
                $challan->update([
                    'total_tax' => $taxAmount,
                    'grand_total' => $totalValue + $taxAmount
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                // \Log::error('Import error: ' . $e->getMessage());
            }
        }
    }

    private function transformDate($value)
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::parse($value);
        }
    }
}
