<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Company::insert([
            [
                'user_id' => "1",
                'industry_name' => 'Manufacturing',
                'industry_number' => 'IND123',
                'industry_gstin' => '29ABCDE9876F2Z9',
                'industry_address' => '456 Industry Zone, City B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => "1",
                'industry_name' => 'Textile',
                'industry_number' => 'IND789',
                'industry_gstin' => '24XYZDE9876H7Z3',
                'industry_address' => '101 Export Area, City D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => "1",
                'industry_name' => 'AMITY BRASS',
                'industry_number' => '4848646848',
                'industry_gstin' => '24ADFPJ8312E1ZY',
                'industry_address' => 'Vinayak Cold Storage Compound,1st Floor,Plot No.500,49-Digvijay Plot,GIDC,Jamnagar-361004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
