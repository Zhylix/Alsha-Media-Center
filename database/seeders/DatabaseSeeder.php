<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Service;
use App\Models\ShipmentOption;
use App\Models\PaymentMethod;
use App\Models\Testimonial;
use App\Models\StoreProfile;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
// Superadmin
        Admin::create([
            'name'     => 'Super Administrator',
            'email'    => 'superadmin@techfixpro.com',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'role'     => 'superadmin',
            'is_active'=> true,
        ]);

        // Regular Admin
        Admin::create([
            'name'     => 'Administrator',
            'email'    => 'admin@techfixpro.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'is_active'=> true,
        ]);

        // Call Stat Seeder
        $this->call(StatSeeder::class);
    }
}
