<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatSeeder extends Seeder
{
    public function run(): void
    {
        Stat::create([
            'icon'       => 'fas fa-clock',
            'label'      => 'Tahun Pengalaman',
            'value'      => '10',
            'sort_order' => 0,
            'is_active'  => true,
        ]);

        Stat::create([
            'icon'       => 'fas fa-users',
            'label'      => 'Pelanggan Puas',
            'value'      => '500',
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        Stat::create([
            'icon'       => 'fas fa-tools',
            'label'      => 'Perangkat Diperbaiki/Bln',
            'value'      => '100',
            'sort_order' => 2,
            'is_active'  => true,
        ]);

        Stat::create([
            'icon'       => 'fas fa-th-large',
            'label'      => 'Jenis Layanan',
            'value'      => '2',
            'sort_order' => 3,
            'is_active'  => true,
        ]);
    }
}
