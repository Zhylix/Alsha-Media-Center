<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        Admin::updateOrCreate(
            ['email' => 'superadmin@techfixpro.com'],
            [
                'name'      => 'Super Administrator',
                'username'  => 'superadmin',
                'password'  => Hash::make('superadmin123'),
                'role'      => 'superadmin',
                'is_active' => true,
            ]
        );

        // Regular Admin
        Admin::updateOrCreate(
            ['email' => 'admin@techfixpro.com'],
            [
                'name'      => 'Administrator',
                'username'  => 'admin',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // Call Stat Seeder
        $this->call(StatSeeder::class);
    }
}
