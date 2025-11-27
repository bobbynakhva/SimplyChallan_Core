<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Purpose extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function challans()
    {
        return $this->hasMany(Challan::class);
    }

    public function inwardChallans()
    {
        return $this->hasMany(InwardChallan::class);
    }
}
