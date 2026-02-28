<?php

namespace App\Http\Controllers;
use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\ReturnItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 

use Illuminate\Http\Request;

class ReturnItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protects all methods
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'challan_item_id'        => 'required|exists:challan_items,id',
            'subsidiary_challan_number' => 'nullable|string',
            'despatch_date'          => 'nullable|date',
            'quantity_returned'      => 'nullable|numeric|min:0',
            'waste_scrap_returned'   => 'nullable|numeric|min:0',
            'waste_not_recoverable'  => 'nullable|numeric|min:0',
            'return_notes'           => 'nullable|string',
            'piece_returned'         => 'nullable|integer|min:0', // Added Piece Column (Pcs)
        ]);

        // Get Challan Item
        $challanItem = ChallanItem::findOrFail($validated['challan_item_id']);

        // Calculate total quantity returned so far (including this entry)
        $existingReturns = ReturnItem::where('challan_item_id', $challanItem->id)->get();
        $totalReturnedQuantity = $existingReturns->sum('quantity_returned');
        $totalScrap = $existingReturns->sum('waste_scrap_returned');
        $totalUnrecoverable = $existingReturns->sum('waste_not_recoverable');
        $totalReturnedPieces = $existingReturns->sum('piece_returned');

        // Validate total return quantity including waste
        $currentReturned = $validated['quantity_returned'] ?? 0;
        $currentScrap = $validated['waste_scrap_returned'] ?? 0;
        $currentUnrecoverable = $validated['waste_not_recoverable'] ?? 0;
        
        $totalAccountedFor = ($totalReturnedQuantity + $totalScrap + $totalUnrecoverable) + 
                             ($currentReturned + $currentScrap + $currentUnrecoverable);
                             
        $newTotalPieces = $totalReturnedPieces + ($validated['piece_returned'] ?? 0);

        if ($totalAccountedFor > $challanItem->total_qty) {
            return redirect()->back()->withErrors(['quantity_returned' => 'Total quantity (Returned + Waste + Unrecoverable) exceeds sent quantity.']);
        }

        // Calculate remaining quantity and status
        $remainingQty = $challanItem->total_qty - $totalAccountedFor;
        $remainingPieces = $challanItem->total_pieces - $newTotalPieces; // Handling piece column
        $remainingPrice = $remainingQty * $challanItem->price_per_kg;

        // Determine status
        if ($remainingQty <= 0.001) { // Floating point tolerance
            $validated['status'] = 'Complete';
        } else {
            $validated['status'] = 'Pending';
        }

        // Create new return item record
        $returnItem = ReturnItem::create([
            'challan_item_id'       => $validated['challan_item_id'],
            'despatch_date'         => $validated['despatch_date'],
            'subsidiary_challan_number' => $validated['subsidiary_challan_number'] ?? null,
            'quantity_returned'     => $validated['quantity_returned'] ?? 0,
            'waste_scrap_returned'  => $validated['waste_scrap_returned'] ?? 0,
            'waste_not_recoverable' => $validated['waste_not_recoverable'] ?? 0,
            'return_notes'          => $validated['return_notes'] ?? null,
            'piece_returned'        => $validated['piece_returned'] ?? 0, // Store piece column
            'remaining_qty'         => $remainingQty,
            'remaining_price'       => $remainingPrice,
            'status'                => $validated['status'],
        ]);

        // Update ChallanItem status
        if ($remainingQty <= 0) {
            $challanItem->status = 'Fully Returned';
        } else {
            $challanItem->status = 'Received';
        }
        $challanItem->save();

        return redirect()->back()->with('success', 'Return entry added successfully!');
    }

}
