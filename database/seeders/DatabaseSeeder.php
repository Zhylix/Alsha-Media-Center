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
            'store_name'  => 'TechFix Pro',
            'tagline'     => 'Solusi Terpercaya untuk Semua Masalah Elektronik Anda',
            'description' => 'TechFix Pro adalah bengkel service elektronik profesional yang berpengalaman lebih dari 10 tahun dalam menangani perbaikan laptop, printer, dan handphone. Kami menggunakan spare part original dan bergaransi untuk setiap pekerjaan yang kami lakukan.',
            'address'     => 'Jl. Asia Afrika No. 123, Bandung',
            'city'        => 'Bandung, Jawa Barat',
            'phone'       => '+62 22 1234 5678',
            'whatsapp'    => '+6281234567890',
            'email'       => 'info@techfixpro.com',
            'instagram'   => '@techfixpro_bdg',
            'facebook'    => 'TechFix Pro Bandung',
            'latitude'    => -6.9147440,
            'longitude'   => 107.6098100,
            'open_hours'  => '08:00 - 20:00',
            'open_days'   => 'Senin - Sabtu',
        ]);

        // Services - Laptop
        $laptopServices = [
            ['name' => 'Servis Keyboard Laptop', 'category' => 'laptop', 'price_start' => 75000, 'price_end' => 200000, 'estimated_days' => 1, 'short_description' => 'Perbaikan atau penggantian keyboard laptop yang rusak, macet, atau tidak berfungsi.', 'description' => 'Layanan servis keyboard laptop mencakup pembersihan keyboard, perbaikan tombol yang macet, penggantian key cap, hingga penggantian keyboard unit secara keseluruhan. Kami menangani semua merek laptop.'],
            ['name' => 'Servis LCD/Layar Laptop', 'category' => 'laptop', 'price_start' => 350000, 'price_end' => 1500000, 'estimated_days' => 3, 'short_description' => 'Penggantian layar LCD laptop yang pecah, bergaris, atau tidak menyala.', 'description' => 'Layanan penggantian layar laptop untuk semua jenis kerusakan: layar pecah, bergaris, backlight mati, warna tidak normal, dll. Menggunakan LCD original atau berkualitas tinggi dengan garansi 30 hari.', 'is_featured' => true],
            ['name' => 'Servis Motherboard Laptop', 'category' => 'laptop', 'price_start' => 200000, 'price_end' => 800000, 'estimated_days' => 5, 'short_description' => 'Perbaikan motherboard laptop yang mati total, mati mendadak, atau tidak mau booting.', 'description' => 'Servis motherboard laptop tingkat lanjut untuk kerusakan IC power, VGA, RAM slot, dan komponen lainnya. Dikerjakan oleh teknisi berpengalaman dengan peralatan reballing dan soldering profesional.'],
            ['name' => 'Install Ulang Windows', 'category' => 'laptop', 'price_start' => 100000, 'price_end' => 150000, 'estimated_days' => 1, 'short_description' => 'Install ulang Windows 10/11 beserta driver dan software dasar.', 'description' => 'Layanan instalasi ulang sistem operasi Windows 10 atau Windows 11 lengkap dengan driver hardware, software antivirus, dan aplikasi dasar. Termasuk backup data jika diperlukan.'],
            ['name' => 'Upgrade RAM & SSD Laptop', 'category' => 'laptop', 'price_start' => 50000, 'price_end' => 100000, 'estimated_days' => 1, 'short_description' => 'Upgrade RAM dan ganti HDD ke SSD untuk performa lebih cepat.', 'description' => 'Tingkatkan performa laptop Anda dengan upgrade RAM dan penggantian HDD ke SSD. Laptop menjadi lebih cepat, responsif, dan hemat baterai. Harga belum termasuk komponen.'],
        ];

        foreach ($laptopServices as $i => $service) {
            Service::create(array_merge($service, ['slug' => \Illuminate\Support\Str::slug($service['name']), 'is_active' => true, 'is_featured' => $service['is_featured'] ?? false, 'sort_order' => $i + 1]));
        }

        // Services - Printer
        $printerServices = [
            ['name' => 'Servis Printer Tidak Bisa Print', 'category' => 'printer', 'price_start' => 75000, 'price_end' => 200000, 'estimated_days' => 2, 'short_description' => 'Perbaikan printer yang tidak bisa mencetak, macet kertas, atau error.', 'description' => 'Diagnosa dan perbaikan printer yang tidak mau mencetak, paper jam, error kode, hingga masalah konektivitas. Melayani semua merek: Canon, Epson, HP, Brother, dll.'],
            ['name' => 'Reset Printer & Tinta', 'category' => 'printer', 'price_start' => 50000, 'price_end' => 100000, 'estimated_days' => 1, 'short_description' => 'Reset counter tinta printer dan isi ulang tinta.', 'description' => 'Layanan reset printer untuk pesan "ink absorber is full", reset counter cetak, dan isi ulang cartridge atau infus tinta. Tersedia untuk semua merek printer.', 'is_featured' => true],
            ['name' => 'Servis Head Printer Buntu', 'category' => 'printer', 'price_start' => 100000, 'price_end' => 300000, 'estimated_days' => 2, 'short_description' => 'Pembersihan head printer yang buntu atau bergaris saat mencetak.', 'description' => 'Layanan deep cleaning head printer yang buntu, bergaris, warna tidak keluar, atau kualitas cetak menurun. Menggunakan cairan pembersih profesional yang aman.'],
            ['name' => 'Servis Printer Garis-Garis', 'category' => 'printer', 'price_start' => 150000, 'price_end' => 400000, 'estimated_days' => 3, 'short_description' => 'Perbaikan printer yang hasil cetakannya bergaris atau buram.', 'description' => 'Diagnosa dan perbaikan masalah cetakan bergaris, buram, atau tidak rata. Meliputi pembersihan head, penggantian cartridge, kalibrasi, hingga penggantian komponen rusak.'],
        ];

        foreach ($printerServices as $i => $service) {
            Service::create(array_merge($service, ['slug' => \Illuminate\Support\Str::slug($service['name']), 'is_active' => true, 'is_featured' => $service['is_featured'] ?? false, 'sort_order' => $i + 1]));
        }

        // Services - HP
        $hpServices = [
            ['name' => 'Ganti LCD HP', 'category' => 'hp', 'price_start' => 150000, 'price_end' => 800000, 'estimated_days' => 1, 'short_description' => 'Penggantian layar HP yang pecah, mati, atau bergaris.', 'description' => 'Layanan penggantian LCD atau OLED HP untuk semua merek: Samsung, iPhone, Xiaomi, Oppo, Vivo, Realme, dll. Menggunakan layar original atau OEM berkualitas dengan garansi 30 hari.', 'is_featured' => true],
            ['name' => 'Servis HP Mati Total', 'category' => 'hp', 'price_start' => 100000, 'price_end' => 400000, 'estimated_days' => 3, 'short_description' => 'Perbaikan HP yang mati total, tidak mau menyala, atau bootloop.', 'description' => 'Diagnosa dan perbaikan HP mati total, bootloop, atau tidak merespon. Meliputi perbaikan IC power, flash ulang firmware, perbaikan jalur, dan komponen lainnya.'],
            ['name' => 'Ganti Baterai HP', 'category' => 'hp', 'price_start' => 75000, 'price_end' => 250000, 'estimated_days' => 1, 'short_description' => 'Penggantian baterai HP yang drop, kembung, atau cepat habis.', 'description' => 'Layanan penggantian baterai HP untuk semua merek. Menggunakan baterai original atau OEM berkualitas. Baterai kembung sangat berbahaya, segera diganti!'],
            ['name' => 'Servis Touchscreen HP', 'category' => 'hp', 'price_start' => 100000, 'price_end' => 500000, 'estimated_days' => 1, 'short_description' => 'Perbaikan touchscreen HP yang tidak responsif atau mati sebagian.', 'description' => 'Penggantian kaca touchscreen HP yang pecah, tidak responsif, atau mati sebagian. Tersedia untuk semua merek dan tipe HP.'],
            ['name' => 'Flash / Unbrick HP', 'category' => 'hp', 'price_start' => 100000, 'price_end' => 200000, 'estimated_days' => 2, 'short_description' => 'Flash ulang firmware HP yang bootloop, kena virus, atau terkunci.', 'description' => 'Layanan flash ulang/unbrick HP yang mengalami bootloop, terkunci FRP (Factory Reset Protection), kena virus, atau masalah software lainnya.'],
        ];

        foreach ($hpServices as $i => $service) {
            Service::create(array_merge($service, ['slug' => \Illuminate\Support\Str::slug($service['name']), 'is_active' => true, 'is_featured' => $service['is_featured'] ?? false, 'sort_order' => $i + 1]));
        }

        // Shipment Options
        ShipmentOption::create(['name' => 'Antar Jemput (Bandung)', 'provider' => 'Antar Jemput', 'description' => 'Kami antar jemput perangkat Anda khusus wilayah Bandung Kota', 'price' => 25000, 'estimated_days' => 1, 'is_active' => true]);
        ShipmentOption::create(['name' => 'JNE Reguler', 'provider' => 'JNE', 'description' => 'Pengiriman via JNE Reguler ke seluruh Indonesia', 'price' => 35000, 'estimated_days' => 3, 'is_active' => true]);
        ShipmentOption::create(['name' => 'J&T Express', 'provider' => 'J&T', 'description' => 'Pengiriman via J&T Express, cepat dan terpercaya', 'price' => 30000, 'estimated_days' => 3, 'is_active' => true]);
        ShipmentOption::create(['name' => 'SiCepat Reguler', 'provider' => 'SiCepat', 'description' => 'Pengiriman via SiCepat, harga terjangkau', 'price' => 28000, 'estimated_days' => 4, 'is_active' => true]);
        ShipmentOption::create(['name' => 'Ambil Sendiri (Pick Up)', 'provider' => 'Pick Up', 'description' => 'Ambil langsung ke toko kami', 'price' => 0, 'estimated_days' => 0, 'is_active' => true]);

        // Payment Methods
        PaymentMethod::create(['name' => 'Transfer BCA', 'type' => 'bank_transfer', 'provider' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'TechFix Pro', 'instructions' => 'Transfer ke rekening BCA di atas, kemudian kirim bukti transfer ke WhatsApp kami.', 'is_active' => true]);
        PaymentMethod::create(['name' => 'Transfer Mandiri', 'type' => 'bank_transfer', 'provider' => 'Mandiri', 'account_number' => '0987654321', 'account_name' => 'TechFix Pro', 'instructions' => 'Transfer ke rekening Mandiri di atas, kemudian kirim bukti transfer ke WhatsApp kami.', 'is_active' => true]);
        PaymentMethod::create(['name' => 'GoPay', 'type' => 'e_wallet', 'provider' => 'GoPay', 'account_number' => '081234567890', 'account_name' => 'TechFix Pro', 'instructions' => 'Transfer GoPay ke nomor di atas, kemudian kirim screenshot bukti transfer.', 'is_active' => true]);
        PaymentMethod::create(['name' => 'OVO', 'type' => 'e_wallet', 'provider' => 'OVO', 'account_number' => '081234567890', 'account_name' => 'TechFix Pro', 'instructions' => 'Transfer OVO ke nomor di atas, kemudian kirim screenshot bukti transfer.', 'is_active' => true]);
        PaymentMethod::create(['name' => 'DANA', 'type' => 'e_wallet', 'provider' => 'DANA', 'account_number' => '081234567890', 'account_name' => 'TechFix Pro', 'instructions' => 'Transfer DANA ke nomor di atas, kemudian kirim screenshot bukti transfer.', 'is_active' => true]);
        PaymentMethod::create(['name' => 'Bayar di Tempat (COD)', 'type' => 'cod', 'provider' => 'COD', 'instructions' => 'Bayar langsung saat perangkat Anda diambil/diantar. Khusus area Bandung Kota.', 'is_active' => true]);

        // Testimonials
        $testimonials = [
            ['customer_name' => 'Budi Santoso', 'service_type' => 'laptop', 'rating' => 5, 'comment' => 'LCD laptop saya yang pecah berhasil diganti dalam waktu 2 hari. Hasil bagus, harga terjangkau, dan teknisinya ramah. Sangat recommended!'],
            ['customer_name' => 'Siti Rahayu', 'service_type' => 'hp', 'rating' => 5, 'comment' => 'HP Samsung saya yang mati total berhasil diperbaiki di sini. Pelayanan cepat dan profesional. Sudah berjalan normal kembali!'],
            ['customer_name' => 'Ahmad Fauzi', 'service_type' => 'printer', 'rating' => 4, 'comment' => 'Printer Epson saya berhasil direset dan dibersihkan head-nya. Sekarang hasil cetak sudah bersih kembali. Harga reasonable!'],
            ['customer_name' => 'Dewi Lestari', 'service_type' => 'laptop', 'rating' => 5, 'comment' => 'Upgrade SSD laptop saya dari HDD di sini. Perbedaannya drastis, laptop jadi super cepat. Teknisinya sangat knowledgeable!'],
            ['customer_name' => 'Riko Pratama', 'service_type' => 'hp', 'rating' => 5, 'comment' => 'Ganti baterai iPhone di sini, hasilnya memuaskan. Baterai original dan ada garansi 30 hari. Tempat nyaman dan bersih.'],
            ['customer_name' => 'Maya Putri', 'service_type' => 'printer', 'rating' => 4, 'comment' => 'Printer HP saya yang paper jam terus sudah bisa normal. Servis cepat dan terjangkau. Akan kembali lagi kalau ada masalah lain.'],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create(array_merge($t, ['is_active' => true]));
        }
    }
}
