<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        DB::table('users')->insert([
            'name' => 'Simply Digital Things',
            'email' => 'admin@gmail.com',
            'phone' => '9876543210',
            'gstin' => '29ABCDE1234F2Z5',
            'address' => '123 Industrial Area, City A',
            'password' => Hash::make('Admin@123'),
            'is_used' => 1,
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Regular User
        DB::table('users')->insert([
            'name' => 'XYZ Enterprises',
            'gstin' => '24XYZDE1234H7Z6',
            'address' => '789 Business Park, City C',
            'email' => 'xyz@gmail.com',
            'phone' => '8888888888',
            'password' => Hash::make('User@123'),
            'is_used' => 1,
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'BHARANI BRASS INDUSTRIES',
            'phone' => '1234567890',
            'gstin' => '24ACDPB3320P1ZX',
            'address' => '789 Business Park, City C',
            'email' => 'bharani@gmail.com',
            'password' => Hash::make('User@123'),
            'is_used' => 1,
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

}
