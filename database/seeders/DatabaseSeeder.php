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
        // Admin
        Admin::create([
            'name'     => 'Administrator',
            'email'    => 'admin@techfixpro.com',
            'password' => Hash::make('admin123'),
        ]);

        // Store Profile
        StoreProfile::create([
            'store_name'  => 'Alsha Media Center',
            'tagline'     => 'Solusi Terpercaya untuk Semua Masalah Elektronik Anda',
            'description' => 'Alsha Media Center adalah bengkel service elektronik profesional yang berpengalaman lebih dari 10 tahun dalam menangani perbaikan PC, laptop, dan printer. Kami menggunakan spare part original dan bergaransi untuk setiap pekerjaan yang kami lakukan.',
            'address'     => 'Jl. Jepara No. 123, Bangsri, Jepara, Jawa Tengah',
            'city'        => 'Bangsri, Jawa Tengah',
            'phone'       => '+62 22 1234 5678',
            'whatsapp'    => '+6281234567890',
            'email'       => 'info@alshamediacenter.com',
            'instagram'   => '@alshamediacenter',
            'facebook'    => 'Alsha Media Center',
            'latitude'    => -6.9147440,
            'longitude'   => 107.6098100,
            'open_hours'  => '08:00 - 20:00',
            'open_days'   => 'Senin - Sabtu',
        ]);

        // Call Stat Seeder
        $this->call(StatSeeder::class);
    }
}
