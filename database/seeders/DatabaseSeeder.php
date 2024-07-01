<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin 1',
            'email' => 'admin@storease.com',
            'password' => bcrypt('password'),
        ]);
        
        Customer::create([
            'name' => 'Customer 1',
            'email' => 'customer1@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);

        Customer::create([
            'name' => 'Customer 2',
            'email' => 'customer2@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);
        
        Vendor::create([
            'name' => 'Vendor 1',
            'email' => 'vendor1@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);

        Vendor::create([
            'name' => 'Vendor 2',
            'email' => 'vendor2@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);
    }
}
