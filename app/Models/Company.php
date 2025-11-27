<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'industry_name',
        'industry_gstin',
        'industry_number',
        'industry_address',
    ];


    protected $dates = ['deleted_at'];

    public function challans()
    {
        return $this->hasMany(Challan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

