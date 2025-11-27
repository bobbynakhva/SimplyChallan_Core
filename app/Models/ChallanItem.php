<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallanItem extends Model
{
    use HasFactory;

    protected $fillable = ['challan_id', 'item_name', 'hsn_code', 'price_per_kg', 'piece_no','total_qty','total_value',
    'status'];

    public function challan()
    {
        return $this->belongsTo(Challan::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnItem::class);
    }
}
