<?php

namespace Database\Seeders;

use App\Models\SparepartCategory;
use Illuminate\Database\Seeder;

class SparepartCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // PC Categories
            ['service_category' => 'pc', 'part_type' => 'RAM', 'is_active' => true, 'sort_order' => 1],
            ['service_category' => 'pc', 'part_type' => 'SSD', 'is_active' => true, 'sort_order' => 2],
            ['service_category' => 'pc', 'part_type' => 'HDD', 'is_active' => true, 'sort_order' => 3],
            ['service_category' => 'pc', 'part_type' => 'Processor', 'is_active' => true, 'sort_order' => 4],
            ['service_category' => 'pc', 'part_type' => 'Motherboard', 'is_active' => true, 'sort_order' => 5],
            ['service_category' => 'pc', 'part_type' => 'Power Supply', 'is_active' => true, 'sort_order' => 6],
            ['service_category' => 'pc', 'part_type' => 'VGA Card', 'is_active' => true, 'sort_order' => 7],
            ['service_category' => 'pc', 'part_type' => 'Cooling Fan', 'is_active' => true, 'sort_order' => 8],

            // Laptop Categories
            ['service_category' => 'laptop', 'part_type' => 'Keyboard', 'is_active' => true, 'sort_order' => 1],
            ['service_category' => 'laptop', 'part_type' => 'Screen', 'is_active' => true, 'sort_order' => 2],
            ['service_category' => 'laptop', 'part_type' => 'Battery', 'is_active' => true, 'sort_order' => 3],
            ['service_category' => 'laptop', 'part_type' => 'RAM', 'is_active' => true, 'sort_order' => 4],
            ['service_category' => 'laptop', 'part_type' => 'SSD', 'is_active' => true, 'sort_order' => 5],
            ['service_category' => 'laptop', 'part_type' => 'HDD', 'is_active' => true, 'sort_order' => 6],
            ['service_category' => 'laptop', 'part_type' => 'Charger', 'is_active' => true, 'sort_order' => 7],
            ['service_category' => 'laptop', 'part_type' => 'Cooling Fan', 'is_active' => true, 'sort_order' => 8],

            // Printer Categories
            ['service_category' => 'printer', 'part_type' => 'Print Head', 'is_active' => true, 'sort_order' => 1],
            ['service_category' => 'printer', 'part_type' => 'Cartridge', 'is_active' => true, 'sort_order' => 2],
            ['service_category' => 'printer', 'part_type' => 'Roller', 'is_active' => true, 'sort_order' => 3],
            ['service_category' => 'printer', 'part_type' => 'Ink System', 'is_active' => true, 'sort_order' => 4],
            ['service_category' => 'printer', 'part_type' => 'Power Supply', 'is_active' => true, 'sort_order' => 5],
            ['service_category' => 'printer', 'part_type' => 'Control Board', 'is_active' => true, 'sort_order' => 6],

            // Software Categories
            ['service_category' => 'software', 'part_type' => 'OS Installation', 'is_active' => true, 'sort_order' => 1],
            ['service_category' => 'software', 'part_type' => 'Driver Installation', 'is_active' => true, 'sort_order' => 2],
            ['service_category' => 'software', 'part_type' => 'Antivirus', 'is_active' => true, 'sort_order' => 3],
            ['service_category' => 'software', 'part_type' => 'Office Software', 'is_active' => true, 'sort_order' => 4],
            ['service_category' => 'software', 'part_type' => 'Data Recovery', 'is_active' => true, 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            SparepartCategory::create($category);
        }
    }
}