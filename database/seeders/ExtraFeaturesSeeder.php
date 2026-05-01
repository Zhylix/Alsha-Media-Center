<?php

namespace Database\Seeders;

use App\Models\Sparepart;
use Illuminate\Database\Seeder;

class ExtraFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Spareparts - Laptop
        Sparepart::create([
            'name' => 'Keyboard Laptop Universal',
            'slug' => 'keyboard-laptop-universal',
            'category' => 'laptop',
            'price' => 150000,
            'description' => 'Keyboard pengganti untuk berbagai tipe laptop Acer, Asus, dan Lenovo.',
            'is_available' => true,
        ]);

        Sparepart::create([
            'name' => 'SSD Lexar 256GB SATA III',
            'slug' => 'ssd-lexar-256gb-sata-iii',
            'category' => 'laptop',
            'price' => 350000,
            'description' => 'SSD kecepatan tinggi untuk upgrade laptop lemot agar lebih kencang.',
            'is_available' => true,
        ]);

        // Seed Spareparts - Printer
        Sparepart::create([
            'name' => 'Head Printer Epson L3110',
            'slug' => 'head-printer-epson-l3110',
            'category' => 'printer',
            'price' => 850000,
            'description' => 'Print head original untuk seri Epson L-series.',
            'is_available' => true,
        ]);

        Sparepart::create([
            'name' => 'Roller Pick Up Canon G2010',
            'slug' => 'roller-pick-up-canon-g2010',
            'category' => 'printer',
            'price' => 75000,
            'description' => 'Sparepart penarik kertas untuk printer Canon Pixma.',
            'is_available' => true,
        ]);

        // Seed Spareparts - PC
        Sparepart::create([
            'name' => 'Power Supply 500W 80+',
            'slug' => 'power-supply-500w-80-plus',
            'category' => 'pc',
            'price' => 450000,
            'description' => 'PSU handal untuk PC gaming atau kantor dengan sertifikasi 80 Plus.',
            'is_available' => true,
        ]);

        Sparepart::create([
            'name' => 'RAM DDR4 8GB 3200MHz',
            'slug' => 'ram-ddr4-8gb-3200mhz',
            'category' => 'pc',
            'price' => 320000,
            'description' => 'Memori PC untuk performa multitasking yang lebih lancar.',
            'is_available' => true,
        ]);
    }
}
