<?php

namespace App\Http\Controllers;

use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\Company;
use App\Models\FinancialYear;
use App\Models\Purpose;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChallanImport;

class ChallanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protects all methods
    }

    public function index() {
        $challans = Challan::with('purpose')
                        ->where('user_id', Session::get('company_id')) // Filter by logged-in user
                        ->get();
        return view('front.challans.index', compact('challans'));
    }

    public function create()
    {
        $companyId = Session::get('company_id');
        $companies = Company::where('user_id', $companyId)->get();
        $challan_no = Challan::generateChallanNumber();
        $financialYears = FinancialYear::all();
        $purposes = Purpose::all();
        $selectedclient = Company::where('user_id', $companyId)->first();
        $jobworkers = User::where('role', 'job_seeker')->get(); // Get only job seekers
        return view('front.challans.create', compact('companies', 'selectedclient','financialYears','challan_no','purposes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'challan_number' => 'required|unique:challans,challan_number',
            'date' => 'required|date',
            'purpose_id' => 'required|exists:purposes,id',
            'notes' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'industry_name' => 'nullable|string|max:255',
            'industry_number' => 'nullable|string|max:255',
            'industry_gstin' => 'nullable|string|max:255',
            'industry_address' => 'nullable|string',
            'vehicle_no' => 'nullable|string',
            'no_of_packages' => 'nullable|string', // Validate input type in HTML
            'cgst' => 'nullable|numeric',
            'sgst' => 'nullable|numeric',
            'total_tax' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
            'description' => 'nullable|string',

            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.hsn_code' => 'nullable|string',
            'items.*.price_per_kg' => 'required|numeric',
            'items.*.total_qty' => 'required|numeric',
            'items.*.total_value' => 'required|numeric',
        ]);

        // try {
            
            DB::beginTransaction();
            $financialYearId = Session::get('financial_year_id');
            // Create Challan
            $challan = Challan::create([
                'challan_number' => $request->challan_number,// Added field
                'date' => $request->date,
                'purpose_id' => $request->purpose_id,
                'notes' => $request->notes ?? '',
                'user_id' => Session::get('company_id'),
                'company_id' => $request->company_id,
                'financial_year_id' => $financialYearId,
                'industry_name' => $request->industry_name,
                'industry_number' => $request->industry_number,
                'industry_gstin' => $request->industry_gstin,
                'industry_address' => $request->industry_address,
                'vehicle_no' => $request->vehicle_no,
                'no_of_packages' => $request->no_of_packages,
                'cgst' => $request->cgst,
                'sgst' => $request->sgst,
                'total_tax' => $request->total_tax,
                'grand_total' => $request->grand_total,
                'description' => $request->description,
            ]);
//             Log::info('Challan store method called', ['request_data' => $request->all()]);
//             DB::listen(function ($query) {
//     Log::info($query->sql, $query->bindings);
// });

            // Add Items to Challan
            foreach ($request->items as $item) {
                $challan->items()->create([
                    'item_name' => $item['item_name'],
                    'hsn_code' => $item['hsn_code'],
                    'price_per_kg' => $item['price_per_kg'],
                    'total_qty' => $item['total_qty'],
                    'total_value' => $item['total_value'],
                    'piece_no' => $item['piece_no'] ?? null,
                ]);
            }
            //Log::info('Challan store method called', ['request_data' => $request->all()]);
            // DB::commit();
            return redirect()->route('challan.print', ['id' => $challan->id])->with('success', 'Challan created successfully!');

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        // }
    }

    // Edit Challan
    public function edit($id)
    {
        $challan = Challan::findOrFail($id);
        $companies = Company::all();
        $financialYears = FinancialYear::all();
        $purposes = Purpose::all();
        $challan->load('items'); // Load related items
        return view('front.challans.edit', compact('challan', 'companies', 'financialYears','purposes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'challan_number' => 'required',
            'date' => 'required|date',
            'purpose_id' => 'required|exists:purposes,id',
            'notes' => 'nullable|string',
            /*'user_id' => 'required|integer',*/
            'company_id' => 'required|integer',
            /*'financial_year_id' => 'required|integer',*/
            'vehicle_no' => 'nullable|string',
            'cgst' => 'required|numeric',
            'sgst' => 'required|numeric',
            'total_tax' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.hsn_code' => 'nullable|string',
            'items.*.price_per_kg' => 'required|numeric',
            'items.*.total_qty' => 'required|numeric',
            'items.*.total_value' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
           // Log::info('Challan store method called', ['request_data' => $request->all()]);
            $financialYearId = Session::get('financial_year_id');
            // Update main Challan
            $challan = Challan::findOrFail($id);
            $challan->update([
                'challan_number' => $request->challan_number,
                'date' => $request->date,
                'purpose_id' => $request->purpose_id,
                'notes' => $request->notes ?? '',
                'company_id' => $request->company_id,
                'financial_year_id' => $financialYearId,
                'industry_name' => $request->industry_name,
                'industry_number' => $request->industry_number,
                'industry_gstin' => $request->industry_gstin,
                'industry_address' => $request->industry_address,
                'vehicle_no' => $request->vehicle_no,
                'no_of_packages' => $request->no_of_packages,
                'cgst' => $request->cgst,
                'sgst' => $request->sgst,
                'total_tax' => $request->total_tax,
                'grand_total' => $request->grand_total,
                'description' => $request->description,
            ]);

            // Existing item IDs (to track for delete)
            $existingItemIds = $challan->items->pluck('id')->toArray();
            $submittedItemIds = [];
            foreach ($request->items as $itemData) {
                if (!empty($itemData['id'])) {
                    $item = ChallanItem::find($itemData['id']);
                    if ($item) {
                        $item->update([
                            'item_name' => $itemData['item_name'],
                            'hsn_code' => $itemData['hsn_code'],
                            'price_per_kg' => $itemData['price_per_kg'],
                            'total_qty' => $itemData['total_qty'],
                            'total_value' => $itemData['total_value'],
                            'piece_no' => $itemData['piece_no'],
                        ]);
                        $submittedItemIds[] = $itemData['id'];
                    }
                } else {
                    $challan->items()->create([
                        'item_name' => $itemData['item_name'],
                        'hsn_code' => $itemData['hsn_code'],
                        'price_per_kg' => $itemData['price_per_kg'],
                        'total_qty' => $itemData['total_qty'],
                        'total_value' => $itemData['total_value'],
                        'piece_no' => $itemData['piece_no'],
                    ]);
                }
            }
            $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
            if (!empty($itemsToDelete)) {
                ChallanItem::destroy($itemsToDelete);
            }

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Challan updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }


   public function softDelete($id)
    {
        $challan = Challan::findOrFail($id);
        $challan->delete(); // Soft delete

        return redirect()->back()->with('success', 'Challan deleted successfully.');
    }

    // Show Soft-Deleted Records
    public function deleted()
    {
        $deletedChallans = Challan::onlyTrashed()->get();
        return view('challans.deleted', compact('deletedChallans'));
    }

    // Restore a Soft-Deleted Challan
    public function restore($id)
    {
        $challan = Challan::withTrashed()->findOrFail($id);
        $challan->restore();
        return redirect()->route('challan.index')->with('success', 'Challan restored successfully.');
    }

    public function show($id) {
        $challan = Challan::with(['company','items','financialYear','purpose'])->findOrFail($id);
        return view('front.challans.view', compact('challan'));
    }

    public function printChallan($id)
    {
        $challan = Challan::with('company', 'financialYear', 'items','purpose')->findOrFail($id);

        return view('front.challans.print', compact('challan'));
    }


    // Inward Challan
    public function inward()
    {
        //$challans = Challan::all();
        $challans = Challan::with(['items', 'items.returns'])->where('user_id', Session::get('company_id'))->get();
        return view('front.challans.inward', compact('challans'));
    }

    // Reports of Challans
    public function reports()
    {
       // $challans = Challan::with('items')->get();
        $companyId = Session::get('company_id');
        $challans = Challan::with(['items', 'items.returns'])->where('user_id', $companyId)->get();
        $companies = Company::where('user_id', $companyId)->get(); // For Filter
        return view('front.challans.reports', compact('challans', 'companies'));
    }

    public function reportsshow($id){
        $challan = Challan::with(['company','items.returns','financialYear','purpose'])->findOrFail($id);
        return view('front.challans.reportsview', compact('challan'));
    }

    public function showReport($id)
    {
        // Fetch the challan with related items and return records
        $challan = Challan::with(['items', 'returns'])->findOrFail($id);

        // Calculate the total returned quantity
        $totalReturnedQty = $challan->returns->sum('quantity_returned');
        
        // Calculate the total waste/scrap returned
        $totalWasteScrap = $challan->returns->sum('waste_scrap_returned');
        
        // Calculate the total waste not recoverable
        $totalWasteNotRecoverable = $challan->returns->sum('waste_not_recoverable');

        // Calculate the remaining stock automatically
        $totalSentQty = $challan->items->sum('total_qty');
        $remainingStock = $totalSentQty - ($totalReturnedQty + $totalWasteScrap + $totalWasteNotRecoverable);

        // Pass data to the view
        return view('front.challans.returnreport', compact(
            'challan', 
            'totalReturnedQty', 
            'totalWasteScrap', 
            'totalWasteNotRecoverable', 
            'remainingStock'
        ));
    }

    public function exportReturnReport($id)
    {
        $challan = Challan::with(['items', 'returns'])->findOrFail($id);
        
        // Calculate totals for consistency (logic same as showReport)
        $totalReturnedQty = $challan->returns->sum('quantity_returned');
        $totalWasteScrap = $challan->returns->sum('waste_scrap_returned');
        $totalWasteNotRecoverable = $challan->returns->sum('waste_not_recoverable');
        $totalSentQty = $challan->items->sum('total_qty');
        $remainingStock = $totalSentQty - ($totalReturnedQty + $totalWasteScrap + $totalWasteNotRecoverable);

        $filename = "Return_Report_" . $challan->challan_number . ".xls";

        return response(view('front.challans.export_return_report', compact(
            'challan', 
            'totalReturnedQty', 
            'totalWasteScrap', 
            'totalWasteNotRecoverable', 
            'remainingStock'
        )))
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function challanItems($id)
    {
        $challan = Challan::with(['items', 'items.returns'])->findOrFail($id); // Eager load items with challan
        /*echo "<pre>";
        echo $challan;
        echo "<pre>";
        exit();*/
        $total_sent = $challan->items->sum('total_qty');
        $total_returned = $challan->items->sum('quantity_returned');
        $remaining = $total_sent - $total_returned;
        return view('front.challans.items', compact('challan', 'total_sent', 'total_returned', 'remaining'));
    }

    public function downloadPdf($id)
{
    $challan = Challan::with('company', 'financialYear', 'items', 'user','purpose')->findOrFail($id);

    // Ensure all values exist to prevent null issues
    $vehicleNo = $challan->vehicle_no ?? 'N/A';
    $noOfPackages = $challan->no_of_packages ?? 'N/A';
    $grandTotal = number_format($challan->grand_total, 2);
    $cgst = number_format($challan->cgst, 2);
    $sgst = number_format($challan->sgst, 2);
    $totalTax = number_format($challan->total_tax, 2);
    $purpose_id = $challan->purpose->name ?? 'N/A';
    $industryName = $challan->industry_name ?? 'N/A';
    $industryAddress = $challan->industry_address ?? 'N/A';
    $industryGstin = $challan->industry_gstin ?? 'N/A';
    $companyName = $challan->company->name ?? 'N/A';
    $dateFormatted = \Carbon\Carbon::parse($challan->date)->format('d.m.Y');
    $currentdate = \Carbon\Carbon::now()->format('d.m.Y');

    // Start HTML
    $html = '<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Challan Print</title>
      <style>
         body {
         font-family: Arial, sans-serif; border: 1px solid #000;
         }
         .text-center {
         text-align: center;
         padding: 0px;
         }
         .bordered {
         border: 1px solid #000;
         padding: 9px;
         }
         table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 5px;
         }
         th, td {
         border: 1px solid #000;
         padding: 3px;
         text-align: left;
         }
         .heading {
         margin-block-start: 0.6em;
         margin-block-end: 0.6em;
         text-align: center;
         font-weight: bold;
         text-transform: uppercase;
         }
         .sub-heading {
         text-align: center;
         font-weight: bold;
         font-size: 14px;
         margin-bottom: 10px;
         }
         .right {
         text-align: right;
         }
         .bold {
         font-weight: bold;
         }
         .space {
         height: 20px;
         }
         .btn-container {
         text-align: center;
         margin-bottom: 18px;
         }
         p {
         display: block;
         margin-block-start: 0.1em;
         margin-block-end: 0.1em;
         }
         .btn {
         padding: 10px 20px;
         margin: 5px;
         border: none;
         cursor: pointer;
         font-size: 16px;
         }
         @media print {
         .btn-container {
         display: none;
         }
         }
      </style>
   </head>
   <body>
      <div class="container" id="challan">
         <div class="text-center" style="padding:5px;"><b>DELIVERY CHALLAN FOR JOBWORK</b></div>
         <div class="text-center">Under Rule 55 of the Central Goods and Service Tax Rules, 2017.</div>
         <div class="text-center">Original Copy</div>
         <table>
            <tr>
               <td colspan="2">
                  <div>Name of the Consignor:</div>
                  <br>
                  <div>Address:</div>
                  <br>
                  <div>GSTIN No.:</div>
               </td>
               <td colspan="4">
                  <h3><b>' . strtoupper($challan->user->name) . '</b></h3>
                  <div><b>' . $challan->challan_number . '<b></div>
                  <br>
                  <div><b>' . $challan->user->gstin  . '<b></div>
               </td>
               <td >
                  <div>CHALLAN SR. NO: ' . $challan->challan_number . '</div>
                  <br>
                  <br>
                  <div>CHALLAN DATE:  ' . $dateFormatted . '</div>
               </td>
            </tr>
         </table>
        <div class="heading">PART - I</div>
         <table border="1" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>Description of Inputs/Partially Processed Inputs</th>
                  <th>HSN Code</th>
                  <th>Price (Kgs)</th>
                  <th>Quantity (Kgs)</th>
               </tr>
            </thead>
            <tbody>';
    
    $amount = 0;
    foreach ($challan->items as $item) {
        $html .= '
                <tr>
                    <td>' . htmlspecialchars($item->item_name) . '</td>
                    <td>' . htmlspecialchars($item->hsn_code) . '</td>
                    <td>' . number_format($item->price_per_kg, 2) . '</td>
                    <td>' . number_format($item->total_qty, 2) . '</td>
                </tr>';
        $amount += $item->total_value;
    }
    
    $html .= '
            </tbody>
        </table>
        <table>
            <tr>
                <th>1.</th>
                <th>Vehicle No.</th>
                <td class="text-center">' . htmlspecialchars($vehicleNo) . '</td>
            </tr>
            <tr>
                <th>2.</th>
                <th>No of Packages</th>
                <td class="text-center">' . htmlspecialchars($noOfPackages) . '</td>
            </tr>
            <tr>
                <th>3.</th>
                <th>Value of Inputs/Partially Processed Goods</th>
                <td class="text-center">' . $grandTotal . '</td>
            </tr>
            <tr>
                <th>4.</th>
                <th>Tax Rate</th>
               <td class="text-center">
                  CGST @ ' . $cgst . '% &nbsp;&nbsp;&nbsp;
                  SGST @ ' . $sgst . '% &nbsp;&nbsp;&nbsp;
                  Total Tax:
               </td>
            </tr>
            <tr>
                <th>5.</th>
                <th>Tax Amount</th>
                <td class="text-center">
                  <strong>' . $amount * $cgst . '</strong> &nbsp;&nbsp;
                  <strong>' . $amount * $sgst . '</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <strong>' . $totalTax . '</strong>
               </td>
            </tr>
            <tr>
                <th>6.</th>
                <th>Purpose</th>
                <td class="text-center">' . htmlspecialchars($purpose) . '</td>
            </tr>
            <tr>
                <th>7.</th>
                <th>Jobworker Name</th>
                <td class="text-center"><b>' . htmlspecialchars($industryName) . '</b></td>
            </tr>
            <tr>
                <th>8.</th>
                <th>Jobworker Address</th>
                <td class="text-center"><b>' . htmlspecialchars($industryAddress) . '</b></td>
            </tr>
            <tr>
                <th>9.</th>
                <th>GSTIN of Jobworker</th>
                <td class="text-center"><b>' . htmlspecialchars($industryGstin) . '</b></td>
            </tr>
        </table>
        <table>
            <tr>
               <td >
                  <div>Place: JAMNAGAR &nbsp; STATE: GUJARAT &nbsp; STATE CODE: 24</div>
                  <div>Date: ' . htmlspecialchars($currentdate) . '</div>
               </td>
               <td>
                  <div><strong>FOR, <span style="text-transform: uppercase;">&nbsp;' . strtoupper($challan->user->name) . '</span></strong></div>
                  <div style="color: red; font-weight: bold;"></div>
                  <br><br>
                  <div><strong>AUTH. SIGN:</strong></div>
               </td>
            </tr>
         </table>
        <div class="heading">PART - II</div>
         <table>
            <tr  >
               <th width="1%">1.</th>
               <th width="31%">Date of despatch of finished goods to parents factory</th>
               <th width="30%"></th>
               <th width="38%">NAME AND ADDRESS STAMP OF <br> JOBWORKER </th>
            </tr>
            <tr >
               <th >2.</th>
               <th>Quantity Returned</th>
               <td ></td>
               <td rowspan="3" style="border: 1px solid black; vertical-align: top;"></td>
            </tr>
            <tr >
               <th >3.</th>
               <th>Waste Scrap Returned</th>
               <td ></td>
            </tr>
            <tr>
               <th >4.</th>
               <th>Waste & Scrap Not Recoverable</th>
               <td ></td>
            </tr>
         </table>
         <table>
            <tr >
               <div>
                  <span>&nbsp;&nbsp;PLACE: JAMNAGAR,</span> <br>
                  <span>&nbsp;&nbsp;STATE: GUJARAT,</span> <br>
                  <span>&nbsp;&nbsp;STATE CODE: 24</span> <br>
                  <span>&nbsp;&nbsp;DATE: ' . $dateFormatted . '</span> <br>
               </div>
               <div style="text-align: right;">
                  <strong>AUTHORISED SIGNATORY : _____________</strong>
               </div>
            </tr>
         </table>
      </div>
   </body>
</html>';

    // Generate PDF
    $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

    return $pdf->download("challan_{$challan->id}.pdf");
}

    public function exportReports(Request $request)
    {
        $companyId = Session::get('company_id');
        
        // Filters
        $filterCompany = $request->input('company_id');
        $selectedIds = $request->input('selected_ids'); // Comma separated IDs

        $query = Challan::with(['items', 'items.returns', 'company', 'purpose'])
                    ->where('user_id', $companyId);

        if ($filterCompany) {
            $query->where('company_id', $filterCompany);
        }

        if ($selectedIds) {
            $ids = explode(',', $selectedIds);
            $query->whereIn('id', $ids);
        }

        $challans = $query->get();

        // Headers for CSV
        $filename = "challan_reports_" . date('Y-m-d_H-i') . ".csv";
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Challan No', 'Client Name', 'Date', 'Purpose', 'Item Name', 'Sent Qty', 'Returned Qty', 'Balance Qty', 'Pieces', 'Despatch Date', 'Status');

        $callback = function() use($challans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($challans as $challan) {
                foreach ($challan->items as $item) {
                     $actualReturned = $item->returns->sum('quantity_returned');
                     $scrapReturned = $item->returns->sum('waste_scrap_returned');
                     $unrecoverable = $item->returns->sum('waste_not_recoverable');
                     
                     $totalAccountedFor = $actualReturned + $scrapReturned + $unrecoverable;
                     $remainingQty = max(0, $item->total_qty - $totalAccountedFor);
                     
                     $remainingpiece = max(0, $item->returns->sum('piece_returned'));
                     $status = ($remainingQty <= 0.001) ? 'Completed' : 'Pending';
                     $despatchDate = optional($item->returns->first())->despatch_date ?? '-';

                    fputcsv($file, array(
                        $challan->challan_number,
                        $challan->industry_name,
                        $challan->date,
                        $challan->purpose->name ?? '-',
                        $item->item_name,
                        number_format($item->total_qty, 3),
                        number_format($totalAccountedFor, 3),
                        number_format($remainingQty, 3),
                        $remainingpiece,
                        $despatchDate,
                        $status
                    ));
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new ChallanImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Challans imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error during import: ' . $e->getMessage());
        }
    }

    public function downloadSample()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=challan_import_sample.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'challan_ref', 'client_gstin', 'item_name', 'qty', 'piece_no', 'price_per_kg', 
            'hsn_code', 'vehicle_no', 'no_of_packages', 'date', 'purpose'
        ];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            // Sample Data (Simplified)
            // Note: date defaults to today, purpose defaults to first, tax defaults to 9+9%
            fputcsv($file, [
                'B101', '24AAAAA0000A1Z5', 'Brass Item A', '25', '100', '550', 
                '7403', 'GJ-10-XY-1234', '10', '', ''
            ]);
            fputcsv($file, [
                'B101', '24AAAAA0000A1Z5', 'Brass Item B', '15', '50', '600', 
                '7403', 'GJ-10-XY-1234', '10', '', ''
            ]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}

