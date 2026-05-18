<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class AddMissingServiceCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'pc' => [
                'name' => 'Servis PC / Komputer',
                'description' => 'Layanan servis PC / Komputer.',
                'short_description' => 'Servis PC / Komputer',
                'price_start' => 0,
                'price_end' => null,
                'price_jasa' => 0,
                'estimated_days' => 3,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
                'image' => null,
            ],
            'software' => [
                'name' => 'Instalasi Software',
                'description' => 'Layanan instalasi software.',
                'short_description' => 'Instalasi Software',
                'price_start' => 0,
                'price_end' => null,
                'price_jasa' => 0,
                'estimated_days' => 3,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
                'image' => null,
            ],
        ];

        foreach ($defaults as $category => $data) {
            // Cek berdasarkan category; kalau sudah ada, tidak diisi lagi.
            $exists = Service::query()->where('category', $category)->exists();
            if ($exists) {
                continue;
            }

            Service::create([
                'name' => $data['name'],
                'slug' => $category === 'pc' ? 'servis-pc-komputer' : 'instalasi-software',
                'category' => $category,
                'description' => $data['description'],
                'short_description' => $data['short_description'],
                'price_start' => $data['price_start'],
                'price_end' => $data['price_end'],
                'price_jasa' => $data['price_jasa'],
                'estimated_days' => $data['estimated_days'],
                'is_active' => $data['is_active'],
                'is_featured' => $data['is_featured'],
                'sort_order' => $data['sort_order'],
                'image' => $data['image'],
            ]);
        }
    }
}

