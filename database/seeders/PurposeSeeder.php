<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purposes = ['Machining', 'Washing', 'Plating'];

        foreach ($purposes as $purpose) {
            Purpose::create(['name' => $purpose]);
        }
    }
}
