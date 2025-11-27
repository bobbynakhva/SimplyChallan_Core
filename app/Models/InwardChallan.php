<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InwardChallan extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        // 'challan_number',
        'main_challan_number',
        'date',
        'user_id',
        'purpose_id',
        'industry_name',
        'industry_number',
        'industry_gstin',
        'total_qty',
    ];

    protected $casts = [
        'date' => 'date',
        'total_qty' => 'float',
    ];

    // Relationship with Purpose model
    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function inwarditems()
    {
        return $this->hasMany(InwardChallanItem::class);
    }

    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function preparedItems()
    {
        return $this->hasManyThrough(
            GoodsStock::class,           // Final model
            InwardChallanItem::class,    // Intermediate model
            'inward_challan_id',         // Foreign key on InwardChallanItems table
            'inward_challan_items_id',   // Foreign key on GoodsStock table (custom column name)
            'id',                        // Local key on InwardChallan table
            'id'                         // Local key on InwardChallanItems table
        );
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
