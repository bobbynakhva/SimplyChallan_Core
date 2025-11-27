<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InwardChallanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inward_challan_id',
        'item_name',
        'qty',
        'piece_no',
        'status',
    ];

    protected $casts = [
        'qty' => 'float',
        'piece_no' => 'float',
    ];

    public function inwarditems()
    {
        return $this->belongsTo(InwardChallan::class, 'inward_challan_id');
    }

    public function goodsStocks()
    {
        return $this->hasMany(GoodsStock::class, 'inward_challan_items_id');
    }

    public function latestGoodsStock()
    {
        return $this->hasOne(GoodsStock::class, 'inward_challan_items_id')->latestOfMany();
    }

}
