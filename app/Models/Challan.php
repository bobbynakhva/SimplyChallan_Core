<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Challan extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'challan_number', 'date', 'purpose_id','notes', 'user_id','company_id','financial_year_id',
        'industry_name','industry_number','industry_gstin','industry_address','vehicle_no', 'no_of_packages',
        'cgst', 'sgst', 'total_tax','grand_total','description'
    ];

    /*'item_name','hsn_code','price_per_kg','total_qty', 'total_value',*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }
    
    public function items()
    {
        return $this->hasMany(ChallanItem::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /*public function jobworker()
    {
        return $this->belongsTo(User::class, 'jobworker_id')->where('role', 'job_seeker');
    }
*/
    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function returns()
    {
        return $this->hasManyThrough(ReturnItem::class, ChallanItem::class);
    }


    /**
     * Generate unique challan number (e.g., 001/2024-25)
     */
    public static function setCode()
    {
        $currentYear = date('Y');
        $nextYear = date('Y', strtotime('+1 year'));
        $financialYear = "{$currentYear}-{$nextYear}";

        // Get last challan of the year
        $lastChallan = self::where('challan_no', 'LIKE', "%/$financialYear")->latest()->first();

        if ($lastChallan) {
            $lastNumber = (int)explode('/', $lastChallan->challan_no)[0]; // Extract last number
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "{$newNumber}/{$financialYear}";
    }

    public static function generateChallanNumber()
    {
        $financialYearId = Session::get('financial_year_id');
        $fy = FinancialYear::find($financialYearId);
        if (!$fy) {
            $currentYear = date('Y');
            $nextYear = date('Y', strtotime('+1 year'));
            $financialYear = "{$currentYear}-{$nextYear}";
        } else {
            $financialYear = $fy->year;
        }

        $lastChallan = self::where('financial_year_id', $financialYearId)
            ->orWhere('challan_number', 'LIKE', "%/{$financialYear}")
            ->orderByDesc('id')
            ->first();

        if ($lastChallan && preg_match('/^(\d+)\//', $lastChallan->challan_number, $matches)) {
            $lastNumber = (int) $matches[1];
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
        return "{$newNumber}/{$financialYear}";
    }
}
