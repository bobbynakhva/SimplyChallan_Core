<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $fillable = [
        'subsidiary_challan_number',
        'challan_item_id',
        'despatch_date',
        'quantity_returned',
        'waste_scrap_returned',
        'waste_not_recoverable',
        'return_notes',
        'piece_returned',
        'status',
    ];

    public function challanItem()
    {
        return $this->belongsTo(ChallanItem::class);
    }
}
