<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsStock extends Model
{
    use HasFactory;

    protected $table = 'goods_stock';

    protected $fillable = [
        'inward_challan_items_id',
        'item_name',
        'kgs',
        'pcs',
        'remaining_qty',
        'status',
        'challan_number',
    ];

    /**
     * Relationship: GoodsStock belongs to InwardChallanItem
     */
    public function inwardChallanItem()
    {
        return $this->belongsTo(InwardChallanItem::class, 'inward_challan_items_id');
    }

    
    public static function generateInwardChallanNumber()
    {
        // Get the last challan entry
        $lastChallan = self::orderByDesc('id')->first();
        if ($lastChallan && preg_match('/JWC-(\d+)/', $lastChallan->challan_number, $matches)) {
            $lastNumber = (int) $matches[1];
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "JWC-{$newNumber}";
    }
}
