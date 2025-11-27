<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialYear;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        FinancialYear::insert([
            ['year' => '2024-2025'],
            ['year' => '2025-2026'],
            ['year' => '2026-2027'],
            ['year' => '2027-2028'],
        ]);
    }
}
