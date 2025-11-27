<?php

namespace App\Http\Controllers\Inward;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InwardChallan;
use App\Models\InwardChallanItem;
use App\Models\GoodsStock;
use App\Models\ChallanItem;
use App\Models\Company;
use App\Models\FinancialYear;
use App\Models\Purpose;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Barryvdh\DomPDF\Facade\Pdf;

class InwardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protects all methods
    }

    public function index()
    {
        $challans = InwardChallan::latest()->get();
        return view('front.inward.index', compact('challans'));
    }

    public function create()
    {
        $companyId = Session::get('company_id');
        $companies = Company::where('user_id', $companyId)->get();
        $challan_no = InwardChallan::generateInwardChallanNumber();
        $financialYears = FinancialYear::all();
        $purposes = Purpose::all();
        $selectedclient = Company::where('user_id', $companyId)->first();
        $jobworkers = User::where('role', 'job_seeker')->get(); // Get only job seekers
        return view('front.inward.create', compact('companies', 'selectedclient','financialYears','challan_no','purposes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'       => 'required|exists:companies,id',
            // 'challan_number'   => 'required|string|unique:inward_challans,challan_number',
            'main_challan_number' => 'nullable|string',
            'date'             => 'required|date',
            'purpose_id'       => 'required|exists:purposes,id',
            'industry_name'    => 'required|string',
            'industry_number'  => 'nullable|string',
            'industry_gstin'   => 'nullable|string',
            'total_qty'        => 'nullable|numeric|min:0',

            'inwarditems'                  => 'required|array|min:1',
            'inwarditems.*.item_name'      => 'required|string',
            'inwarditems.*.qty'            => 'required|numeric|min:0',
            'inwarditems.*.piece_no'       => 'nullable|integer|min:0',
        ]);
        DB::beginTransaction();
        try {
            $challan = InwardChallan::create([
                'company_id'      => $validated['company_id'],
                // 'challan_number'  => $validated['challan_number'],
                'main_challan_number'   => $validated['main_challan_number'],
                'date'            => $validated['date'],
                'purpose_id'      => $validated['purpose_id'],
                'user_id'         => Session::get('company_id'),
                'industry_name'   => $validated['industry_name'],
                'industry_number' => $validated['industry_number'],
                'industry_gstin'  => $validated['industry_gstin'],
                'total_qty'       => $validated['total_qty'] ?? 0,
            ]);

            //Log::info('Challan created:', ['challan' => $challan]);

            foreach ($validated['inwarditems'] as $item) {
                //Log::info('Creating item:', $item);

                InwardChallanItem::create([
                    'inward_challan_id' => $challan->id,
                    'item_name'         => $item['item_name'],
                    'qty'               => $item['qty'],
                    'piece_no'          => $item['piece_no'] ?? 0,
                ]);
            }

            DB::commit();

            return redirect()->route('inward.dashboard')->with('success', 'Challan created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing challan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Something went wrong! ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {

        $challan = InwardChallan::findOrFail($id);
        $companyId = Session::get('company_id');
        $companies = Company::where('user_id', $companyId)->get();
        $financialYears = FinancialYear::all();
        $purposes = Purpose::all();
        $challan->load('inwarditems'); // Load related items

        return view('front.inward.edit', compact('challan', 'companies', 'financialYears','purposes'));
    }

   public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'company_id'              => 'required|exists:companies,id',
            // 'challan_number'          => 'required|string|unique:inward_challans,challan_number,' . $id,
            'date'                    => 'required|date',
            'purpose_id'              => 'required|exists:purposes,id',
            'industry_name'           => 'required|string',
            'industry_number'         => 'nullable|string',
            'industry_gstin'          => 'nullable|string',
            'industry_address'        => 'nullable|string',
            'total_qty'               => 'nullable|numeric|min:0',
            'inwarditems'             => 'required|array|min:1',
            'inwarditems.*.item_name' => 'required|string',
            'inwarditems.*.qty'       => 'required|numeric|min:0',
            'inwarditems.*.piece_no'  => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $challan = InwardChallan::findOrFail($id);

            $challan->update([
                'company_id'       => $request->company_id,
                // 'challan_number'   => $request->challan_number,
                'date'             => $request->date,
                'purpose_id'       => $request->purpose_id,
                'industry_name'    => $request->industry_name,
                'industry_number'  => $request->industry_number,
                'industry_gstin'   => $request->industry_gstin,
                'industry_address' => $request->industry_address,
                'total_qty'        => $request->total_qty,
            ]);

            // Log after update
            Log::info('Challan updated:', ['challan_id' => $challan->id]);

            // Remove old items
            $challan->inwarditems()->delete();

            // Insert new items
            foreach ($request->inwarditems as $item) {
                $challan->inwarditems()->create([
                    'item_name' => $item['item_name'],
                    'qty'       => $item['qty'],
                    'piece_no'  => $item['piece_no'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('inward.dashboard')->with('success', 'Challan updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating challan:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error updating challan: ' . $e->getMessage());
        }
    }

  /*  public function update(Request $request, $id)
    {
        $request->validate([
            'company_id'      => 'required|exists:companies,id',
            'challan_number'  => 'required|string|max:255',
            'date'            => 'required|date',
            'purpose_id'      => 'required|exists:purposes,id',
            'inwarditems.*.item_name' => 'required|string',
            'inwarditems.*.qty'       => 'required|numeric|min:0',
            'inwarditems.*.unit'      => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $challan = Challan::findOrFail($id);
            $challan->company_id = $request->company_id;
            $challan->challan_number = $request->challan_number;
            $challan->date = $request->date;
            $challan->purpose_id = $request->purpose_id;
            $challan->industry_name = $request->industry_name;
            $challan->industry_number = $request->industry_number;
            $challan->industry_gstin = $request->industry_gstin;
            $challan->industry_address = $request->industry_address;
            $challan->total_qty = $request->total_qty;
            $challan->piece_total = $request->piece_total;
            $challan->qty_balance = $request->qty_balance;
            $challan->save();

            // Delete existing items to reinsert
            $challan->inwarditems()->delete();

            // Re-insert all items
            foreach ($request->inwarditems as $item) {
                $challan->inwarditems()->create([
                    'item_name' => $item['item_name'],
                    'qty'       => $item['qty'],
                    'unit'      => $item['unit'],
                    'piece_no'  => $item['piece_no'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('challan.index')->with('success', 'Challan updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating challan: ' . $e->getMessage());
        }
    }
    public function getCompanyDetails(Request $request)
    {
        $company = Company::find($request->id);

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        return response()->json([
            'industry_name'   => $company->industry_name,
            'industry_number' => $company->industry_number,
            'industry_gstin'  => $company->industry_gstin,
            'industry_address'=> $company->industry_address,
        ]);
    }*/

    public function softDelete($id)
    {
        $challan = InwardChallan::findOrFail($id);
        $challan->delete(); // Soft delete
        return redirect()->back()->with('success', 'Challan deleted successfully.');
    }


    public function reports()
    { /*, 'items.returns'*/
        $challans = InwardChallan::with(['inwarditems','inwarditems.goodsStocks'])->where('user_id', Session::get('company_id'))->get();
        return view('front.inward.reports', compact('challans'));
    }

    public function challanItems($id)
    {
        
        $challan = InwardChallan::with(['inwarditems', 'inwarditems.goodsStocks'])->findOrFail($id); // Eager load items with 
        $total_sent = $challan->inwarditems->sum('qty');
        $total = $challan->sum('total_qty');
        $remaining = $total - $total_sent; 
        return view('front.inward.items', compact('challan', 'total_sent', 'total', 'remaining'));
    }

    // public function ReturnPraparedItem(Request $request)
    // {
    //     $validated = $request->validate([
    //         'inward_challan_items_id'        => 'required|exists:inward_challan_items,id',
    //         'item_name'      => 'required',
    //         'kgs'   => 'nullable|numeric|min:0',
    //         'pcs'         => 'nullable|integer|min:0', // Added Piece Column (Pcs)
    //     ]);
    //     $challanItem = InwardChallanItem::findOrFail($validated['inward_challan_items_id']);

    //     $totalReturnedQuantity = GoodsStock::where('inward_challan_items_id', $challanItem->id)->sum('kgs');
    //     $totalReturnedPieces = GoodsStock::where('inward_challan_items_id', $challanItem->id)->sum('pcs');
    //     $newTotalReturned = $totalReturnedQuantity + ($validated['kgs'] ?? 0);
    //     $newTotalPieces = $totalReturnedPieces + ($validated['pcs'] ?? 0);

    //     if ($newTotalReturned > $challanItem->qty) {
    //         return redirect()->back()->withErrors(['kgs' => 'Returned quantity exceeds sent quantity.']);
    //     }
    //     $remainingQty = $challanItem->qty - $newTotalReturned;
    //     $remainingPieces = $challanItem->piece_no - $newTotalPieces;
    //     if ($remainingQty <= 0) {
    //         $validated['status'] = 'Complete';
    //     } else {
    //         $validated['status'] = 'Pending';
    //     }
    //     $returnItem = GoodsStock::create([
    //         'inward_challan_items_id'       => $validated['inward_challan_items_id'],
    //         'item_name' => $validated['item_name'],
    //         'kgs'     => $validated['kgs'] ?? 0,
    //         'pcs'        => $validated['pcs'] ?? 0, // Store piece column
    //         'remaining_qty'         => $remainingQty,
    //         'status'                => $validated['status'],
    //     ]);
    //     if ($remainingQty <= 0) {
    //         $challanItem->status = 'Fully Returned';
    //     } else {
    //         $challanItem->status = 'Received';
    //     }
    //     $challanItem->save();
    //     return redirect()->back()->with('success', 'Return entry added successfully!');
    // }

    public function ReturnPraparedItem(Request $request)
    {
        $validated = $request->validate([
            'inward_challan_items_id' => 'required|exists:inward_challan_items,id',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.kgs' => 'nullable|numeric|min:0',
            'items.*.pcs' => 'nullable|integer|min:0',
        ]);

        $challanItem = InwardChallanItem::findOrFail($validated['inward_challan_items_id']);
        $totalReturnedKgs = GoodsStock::where('inward_challan_items_id', $challanItem->id)->sum('kgs');
        $totalReturnedPcs = GoodsStock::where('inward_challan_items_id', $challanItem->id)->sum('pcs');

        foreach ($validated['items'] as $item) {
            $itemKgs = $item['kgs'] ?? 0;
            $itemPcs = $item['pcs'] ?? 0;

            $totalReturnedKgs += $itemKgs;
            $totalReturnedPcs += $itemPcs;

            if ($totalReturnedKgs > $challanItem->qty) {
                return redirect()->back()->withErrors(['kgs' => 'Returned quantity exceeds sent quantity.']);
            }

            $remainingQty = $challanItem->qty - $totalReturnedKgs;
            $remainingPcs = $challanItem->piece_no - $totalReturnedPcs;

            $status = $remainingQty <= 0 ? 'Complete' : 'Pending';

            GoodsStock::create([
                'inward_challan_items_id' => $validated['inward_challan_items_id'],
                'item_name' => $item['item_name'],
                'kgs' => $itemKgs,
                'pcs' => $itemPcs,
                'remaining_qty' => $remainingQty,
                'status' => $status,
                'challan_number' => GoodsStock::generateInwardChallanNumber(),
            ]);
        }

        $challanItem->status = $totalReturnedKgs >= $challanItem->qty ? 'Fully Returned' : 'Received';

        $challanItem->save();

        return redirect()->back()->with('success', 'Return entries added successfully!');
    }

    public function reportsshow($id)
    {
        $challan = InwardChallan::with([
            'company',
            'inwarditems.goodsStocks', // Load goodsStocks per item
            'financialYear',
            'purpose',
            'preparedItems' // optional for overall sum
        ])->findOrFail($id);

        $totalReturnedQty = 0;

        foreach ($challan->inwarditems as $item) {
            $totalReturnedQty += $item->goodsStocks->sum('kgs'); // ✅ Correct: per item
        }

        $totalSentQty = $challan->inwarditems->sum('qty');

        $remainingStock = $totalSentQty - $totalReturnedQty;

       return view('front.inward.reportsview', compact('challan', 'totalReturnedQty', 'totalSentQty', 'remainingStock'));
    }


    public function downloadPdf($id)
    {
        $challan = InwardChallan::with(['company','user','inwarditems.goodsStocks','financialYear','purpose','preparedItems'])->findOrFail($id);
        $totalReturnedQty = 0;

        foreach ($challan->inwarditems as $item) {
            $totalReturnedQty += $item->goodsStocks->sum('kgs'); // ✅ Correct: per item
        }

        $totalSentQty = $challan->inwarditems->sum('qty');

        $remainingStock = $totalSentQty - $totalReturnedQty;
        
        $pdf = Pdf::loadView('front.inward.pdf', compact('challan','totalSentQty', 'remainingStock'));

        return $pdf->download('subsidiary-challan-' . $challan->challan_number . '.pdf');
    }

    public function printChallan($id)
    {
        $challan = InwardChallan::with(['company','user','inwarditems.goodsStocks','financialYear','purpose','preparedItems'])->findOrFail($id);
        $totalReturnedQty = 0;

        foreach ($challan->inwarditems as $item) {
            $totalReturnedQty += $item->goodsStocks->sum('kgs'); // ✅ Correct: per item
        }

        $totalSentQty = $challan->inwarditems->sum('qty');

        $remainingStock = $totalSentQty - $totalReturnedQty;
        
        return view('front.inward.print', compact('challan','totalSentQty', 'remainingStock'));
    }

    public function singleprintChallan($id)
    {
        $challan = InwardChallan::with([
            'company',
            'user',
            'inwarditems.latestGoodsStock',  // Important: latestGoodsStock instead of goodsStocks
            'financialYear',
            'purpose',
            'preparedItems'
        ])
        ->whereHas('inwarditems.latestGoodsStock', function ($query) use ($id) {
            $query->where('id', $id);
        })
        ->firstOrFail();

        $totalReturnedQty = 0;

        foreach ($challan->inwarditems as $item) {
            $totalReturnedQty += $item->goodsStocks->sum('kgs'); // ✅ Correct: per item
        }

        $totalSentQty = $challan->inwarditems->sum('qty');

        $remainingStock = $totalSentQty - $totalReturnedQty;
        
        $challan_no = $challan->inwarditems->first()->latestGoodsStock->challan_number;
        return view('front.inward.singleprint', compact('challan','totalSentQty', 'remainingStock','challan_no'));
    }


}

