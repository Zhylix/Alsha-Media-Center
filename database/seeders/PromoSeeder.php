<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Promo::create([
            'title' => 'Paket Instal Windows 10/11',
            'slug' => 'paket-instal-windows-10-11-' . rand(100, 999),
            'description' => 'Paket lengkap instal ulang Windows 10/11 dengan optimasi performa. Termasuk backup data, instal driver, dan software essential.',
            'discount_info' => 'Diskon 15%',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'is_active' => true,
            'sort_order' => 1,
        ]);

        \App\Models\Promo::create([
            'title' => 'Paket Cuci Laptop + Service',
            'slug' => 'paket-cuci-laptop-service-' . rand(100, 999),
            'description' => 'Paket cuci laptop profesional dengan service maintenance. Membersihkan debu, ganti thermal paste, dan optimasi pendinginan.',
            'discount_info' => 'Gratis Diagnosa',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'is_active' => true,
            'sort_order' => 2,
        ]);

        \App\Models\Promo::create([
            'title' => 'Paket Upgrade RAM + SSD',
            'slug' => 'paket-upgrade-ram-ssd-' . rand(100, 999),
            'description' => 'Upgrade RAM dan SSD untuk performa maksimal. Termasuk instalasi dan optimasi sistem operasi.',
            'discount_info' => 'Bonus Antivirus',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
