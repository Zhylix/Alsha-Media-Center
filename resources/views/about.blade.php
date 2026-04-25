@extends('layouts.app')
@section('title', 'Tentang Kami')

@section('content')
<!-- Hero -->
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/3 w-64 h-64 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-4">
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Tentang Kami</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 text-center mb-6">Mengenal <span class="text-gradient">Alsha Media Center</span></h1>
        <p class="text-gray-600 text-lg text-center max-w-2xl mx-auto">{{ $store->tagline ?? 'Solusi terpercaya untuk semua masalah elektronik Anda' }}</p>
    </div>
</section>

<!-- Story -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div data-animate>
                <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Cerita Kami</span>
                <h2 class="text-3xl font-black text-gray-900 mt-3 mb-6">Berawal dari <span class="text-gradient">Passion</span> Teknologi</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>{{ $store->description ?? 'Alsha Media Center adalah bengkel service elektronik profesional yang berpengalaman lebih dari 10 tahun.' }}</p>
                    <p>Berdiri sejak tahun 2014, kami telah melayani ribuan pelanggan di Bangsri dan sekitarnya. Komitmen kami adalah memberikan solusi terbaik dengan harga yang terjangkau dan transparansi penuh kepada pelanggan.</p>
                    <p>Kami percaya bahwa setiap perangkat elektronik memiliki nilai dan layak untuk diperbaiki. Dengan teknisi berpengalaman dan peralatan modern, kami siap mengembalikan performa perangkat Anda seperti semula.</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4" data-animate>
                @foreach([
                    ['icon' => '<i class="fas fa-trophy text-red-600"></i>', 'number' => '10+', 'label' => 'Tahun Pengalaman'],
                    ['icon' => '<i class="fas fa-users text-red-600"></i>', 'number' => '5K+', 'label' => 'Pelanggan Puas'],
                    ['icon' => '<i class="fas fa-wrench text-red-600"></i>', 'number' => '50+', 'label' => 'Jenis Perbaikan'],
                    ['icon' => '<i class="fas fa-star text-red-600"></i>', 'number' => '4.9', 'label' => 'Rating Pelanggan'],
                ] as $stat)
                <div class="service-card p-6 rounded-2xl text-center">
                    <div class="text-3xl mb-2">{!! $stat['icon'] !!}</div>
                    <div class="text-2xl font-black text-gradient">{{ $stat['number'] }}</div>
                    <p class="text-gray-600 text-sm mt-1">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<div class="section-line"></div>

<!-- Team -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Tim Kami</span>
            <h2 class="text-3xl font-black text-gray-900 mt-3">Teknisi <span class="text-gradient">Profesional</span> Kami</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['name' => 'Budi Teknisi', 'role' => 'Lead Technician - Laptop', 'exp' => '8 Tahun', 'icon' => '<i class="fas fa-tools text-red-600"></i>'],
                ['name' => 'Sari Handayani', 'role' => 'HP & Smartphone Specialist', 'exp' => '5 Tahun', 'icon' => '<i class="fas fa-laptop-medical text-red-600"></i>'],
                ['name' => 'Agus Purnama', 'role' => 'Printer & Peripherals Expert', 'exp' => '6 Tahun', 'icon' => '<i class="fas fa-user-tie"></i><i class="fas fa-laptop text-red-600"></i>'],
            ] as $member)
            <div class="service-card p-6 rounded-2xl text-center" data-animate>
                <div class="text-6xl mb-4">{!! $member['icon'] !!}</div>
                <h3 class="font-bold text-gray-900 text-lg">{{ $member['name'] }}</h3>
                <p class="text-red-600 text-sm mb-2">{{ $member['role'] }}</p>
                <span class="badge badge-red">Pengalaman {{ $member['exp'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Nilai Kami</span>
            <h2 class="text-3xl font-black text-gray-900 mt-3">Komitmen <span class="text-gradient">Kami Untuk Anda</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach([
                ['icon' => '<i class="fas fa-bullseye text-red-400"></i>', 'title' => 'Akurasi Diagnosa', 'desc' => 'Setiap kerusakan diidentifikasi dengan tepat sebelum dilakukan perbaikan, tidak ada biaya tersembunyi.'],
                ['icon' => '<i class="fas fa-coins text-red-600"></i>', 'title' => 'Harga Transparan', 'desc' => 'Estimasi biaya disampaikan sebelum pengerjaan dimulai. Anda bisa memutuskan tanpa tekanan.'],
                ['icon' => '<i class="fas fa-rocket text-red-600"></i>', 'title' => 'Pengerjaan Cepat', 'desc' => 'Kami menghargai waktu Anda. Sebagian besar perbaikan selesai dalam waktu yang dijanjikan.'],
                ['icon' => '<i class="fas fa-shield-alt text-red-600"></i>', 'title' => 'Garansi Perbaikan', 'desc' => 'Setiap perbaikan dilindungi garansi 30 hari. Jika masalah yang sama muncul, kami perbaiki tanpa biaya tambahan.'],
            ] as $val)
            <div class="service-card p-6 rounded-2xl flex gap-5" data-animate>
                <div class="text-4xl flex-shrink-0">{!! $val['icon'] !!}</div>
                <div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $val['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $val['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Map -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10" data-animate>
            <h2 class="text-3xl font-black text-gray-900">Lokasi <span class="text-gradient">Toko Kami</span></h2>
            <p class="text-gray-600 mt-3">{{ $store->address ?? 'Jl. Jepara No. 123' }}, {{ $store->city ?? 'Bangsri, Jawa Tengah' }}</p>
        </div>
        <div id="map" class="rounded-2xl shadow-2xl border border-red-600/10"></div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const map = L.map('map').setView([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
    const icon = L.divIcon({ html: `<div style="background:linear-gradient(135deg,#dc2626,#991b1b);width:40px;height:40px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 15px rgba(220,38,38,0.5);border:3px solid white;display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:18px;"><i class="fas fa-wrench text-white"></i></span></div>`, className: '', iconSize:[40,40], iconAnchor:[20,40] });
    L.marker([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], {icon}).addTo(map).bindPopup('<strong><i class="fas fa-wrench text-red-600"></i> Alsha Media Center</strong><br>{{ $store->address ?? "Jl. Jepara No. 123" }}, {{ $store->city ?? "Bangsri, Jawa Tengah" }}').openPopup();
</script>
@endpush
