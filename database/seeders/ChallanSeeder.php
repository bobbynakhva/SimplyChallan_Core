<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challan;
use App\Models\Company;
use App\Models\FinancialYear;
use App\Models\User;

class ChallanSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch required data
        $company = Company::first(); // Fetch first available company
        $financialYear = FinancialYear::first(); // Fetch first available financial year
        $users = User::where('role', 'jobworker')->take(5)->get(); // Fetch first 5 job workers

        // Ensure necessary data exists
        if (!$company) {
            $this->command->warn('❌ No company found. Please seed the companies first.');
            return;
        }

        if (!$financialYear) {
            $this->command->warn('❌ No financial year found. Please seed the financial years first.');
            return;
        }

        if ($users->count() < 1) {
            $this->command->warn('❌ Not enough job workers found. Found only ' . $users->count() . '. Please add more.');
            return;
        }

        // Create multiple Challans
        $challans = [
            [
                'challan_number' => 'CHLN-1001',
                'date' => now()->subDays(1),
                'purpose' => 'Jobwork - Turning',
                'jobworker_id' => $users[0]->id,
                'vehicle_no' => 'GJ01-AB-1234',
                'no_of_packages' => 5,
                'total_qty' => 150.75,
                'total_value' => 125000.99,
                'cgst' => 1125.50,
                'sgst' => 1125.50,
                'total_tax' => 2251.00,
                'description' => 'Seeder entry 1',
            ],
            [
                'challan_number' => 'CHLN-1002',
                'date' => now()->subDays(2),
                'purpose' => 'Jobwork - Milling',
                'jobworker_id' => $users[1]->id,
                'vehicle_no' => 'GJ01-CD-5678',
                'no_of_packages' => 3,
                'total_qty' => 275.30,
                'total_value' => 175000.50,
                'cgst' => 1575.75,
                'sgst' => 1575.75,
                'total_tax' => 3151.50,
                'description' => 'Seeder entry 2',
            ],
            [
                'challan_number' => 'CHLN-1003',
                'date' => now()->subDays(3),
                'purpose' => 'Jobwork - Drilling',
                'jobworker_id' => $users[1]->id,
                'vehicle_no' => 'GJ01-EF-9012',
                'no_of_packages' => 7,
                'total_qty' => 320.40,
                'total_value' => 198500.75,
                'cgst' => 1786.25,
                'sgst' => 1786.25,
                'total_tax' => 3572.50,
                'description' => 'Seeder entry 3',
            ],
            [
                'challan_number' => 'CHLN-1004',
                'date' => now()->subDays(4),
                'purpose' => 'Jobwork - Grinding',
                'jobworker_id' => $users[1]->id,
                'vehicle_no' => 'GJ01-GH-3456',
                'no_of_packages' => 4,
                'total_qty' => 400.25,
                'total_value' => 210000.99,
                'cgst' => 1890.50,
                'sgst' => 1890.50,
                'total_tax' => 3781.00,
                'description' => 'Seeder entry 4',
            ],
            [
                'challan_number' => 'CHLN-1005',
                'date' => now()->subDays(5),
                'purpose' => 'Jobwork - Cutting',
                'jobworker_id' => $users[1]->id,
                'vehicle_no' => 'GJ01-IJ-7890',
                'no_of_packages' => 6,
                'total_qty' => 500.80,
                'total_value' => 225000.50,
                'cgst' => 2025.75,
                'sgst' => 2025.75,
                'total_tax' => 4051.50,
                'description' => 'Seeder entry 5',
            ],
        ];

        // Insert Challans
        Challan::insert($challans);

        $this->command->info('✅ 5 Challan records added successfully!');
    }
}
