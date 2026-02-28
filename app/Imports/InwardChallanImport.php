<?php

namespace App\Imports;

use App\Models\InwardChallan;
use App\Models\InwardChallanItem;
use App\Models\Company;
use App\Models\Purpose;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InwardChallanImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $company_id = Session::get('company_id');

        // Group rows by unique identifier: 'main_challan_number' + 'client_gstin'
        $grouped = $rows->groupBy(function ($item) {
            $gst = trim($item['client_gstin'] ?? 'no-gst');
            return ($item['main_challan_number'] ?? '') . '-' . $gst;
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
                // Try to find by name if GST not found but user typed one
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

            // 3. Prepare Header Data (Strict Date Validation)
            $date = $this->transformDate($first['date'] ?? null);
            $mainChallanNumber = trim($first['main_challan_number'] ?? '');

            if (empty($mainChallanNumber)) {
                throw new \Exception("Main Challan Number is missing in one of your rows.");
            }

            // 4. Duplicate Check
            $exists = InwardChallan::where('main_challan_number', $mainChallanNumber)
                ->where('user_id', $company_id)
                ->exists();

            if ($exists) {
                throw new \Exception("Challan Number '{$mainChallanNumber}' has already been uploaded. You cannot upload the same challan twice.");
            }

            DB::beginTransaction();
            try {
                $challan = InwardChallan::create([
                    'main_challan_number' => $mainChallanNumber,
                    'date' => $date,
                    'purpose_id' => $purpose->id,
                    'user_id' => $company_id,
                    'company_id' => $client->id,
                    'industry_name' => $client->industry_name,
                    'industry_number' => $client->industry_number,
                    'industry_gstin' => $client->industry_gstin,
                    'industry_address' => $client->industry_address,
                    'total_qty' => 0, // Will calculate below
                ]);

                $totalQty = 0;
                foreach ($group as $itemRow) {
                    $itemQty = floatval($itemRow['qty'] ?? 0);
                    $totalQty += $itemQty;

                    InwardChallanItem::create([
                        'inward_challan_id' => $challan->id,
                        'item_name' => $itemRow['item_name'] ?? 'Item',
                        'qty' => $itemQty,
                        'piece_no' => $itemRow['piece_no'] ?? 0,
                    ]);
                }

                $challan->update([
                    'total_qty' => $totalQty
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Inward Import error: ' . $e->getMessage());
            }
        }
    }

    private function transformDate($value)
    {
        if (empty($value)) {
            throw new \Exception("Date field is empty for one or more challans. Date is mandatory.");
        }

        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value);
        }

        if (is_numeric($value)) {
            try {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            } catch (\Throwable $e) {
                // Fall through
            }
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            try {
                $cleaned = str_replace(['/', '.'], '-', $value);
                return Carbon::parse($cleaned);
            } catch (\Throwable $e2) {
                throw new \Exception("The date '{$value}' is not in a readable format. Please use YYYY-MM-DD or DD-MM-YYYY.");
            }
        }
    }
}
