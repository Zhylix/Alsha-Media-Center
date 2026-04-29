@extends('layouts.app')

@section('title', 'AMC | Service Bangsri')

@section('content')

<!-- ===================== HERO ===================== -->
@php
$heroImageUrl = $store && $store->hero_image ? asset('storage/' . $store->hero_image) : asset('images/image.png');
@endphp
<section class="relative min-h-screen overflow-hidden">
    
    <!-- BACKGROUND SPLIT -->
    <div class="absolute inset-0 grid grid-cols-1 lg:grid-cols-2">
        <!-- kiri box -->
        <div class="bg-white"></div>

        <!-- kanan gambar -->
        <div 
            class="bg-cover bg-center"
            style="background-image: url('{{ $heroImageUrl }}');"
        ></div>
    </div>
    <div 
        class="absolute inset-y-0 left-1/2 w-40 -translate-x-1/2 z-[1]"
        style="
            background: linear-gradient(
                to right,
                rgba(255,255,255,1) 0%,
                rgba(255,255,255,0.95) 20%,
                rgba(255,255,255,0.7) 50%,
                rgba(255,255,255,0.3) 75%,
                rgba(255,255,255,0) 100%
            );
            filter: blur(20px);
        "
    ></div>

    <!-- overlay tipis biar gambar lebih smooth -->
    <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent"></div>

    <!-- CONTENT -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border-white/20 text-black backdrop-blur-sm text-sm font-medium mb-6 animate-fade-up">
                    <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                    Terpercaya sejak {{ date('Y') - $stats['experience'] }} · {{ $store->city ?? 'Bangsri, Jawa Tengah' }}
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-black leading-tight mb-6 animate-fade-up" style="animation-delay: 0.1s;">
                    Jasa Service
                    <span class="text-red-600 block">Elektronik</span>
                    Terpercaya
                </h1>

                <p class="text-black text-lg leading-relaxed mb-8 animate-fade-up" style="animation-delay: 0.2s;">
                    Spesialis perbaikan <strong class="text-black">laptop</strong>, <strong class="text-black">printer</strong>, dan <strong class="text-black">handphone</strong>.
                    Teknisi berpengalaman, spare part original, garansi 30 hari. Antar jemput tersedia!
                </p>

                <div class="flex flex-col sm:flex-row gap-4 mb-10 justify-center lg:justify-start">
                    <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20konsultasi..." target="_blank" class="btn-primary inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-white font-bold text-base shadow-md transition-all hover:scale-105 hover:shadow-xl w-full sm:w-auto">
                        <i class="fab fa-whatsapp"></i>
                        Chat WhatsApp
                    </a>
                    <a href="{{ route('services.index') }}" class="border-white/30 text-black hover:bg-black/10 inline-flex items-center gap-2 px-8 py-4 rounded-2xl font-bold text-base transition-all">
                        Lihat Layanan
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <!-- Quick Category Buttons -->
                <div class="flex flex-wrap gap-3 animate-fade-up" style="animation-delay: 0.4s;">
                    <a href="{{ route('services.laptop') }}" class="flex items-center gap-2 px-4 py-2 bg-black/10 border-black/20 text-black hover:bg-black/20 rounded-xl transition-all text-sm"><i class="fas fa-laptop text-red-500"></i> Laptop</a>
                    <a href="{{ route('services.printer') }}" class="flex items-center gap-2 px-4 py-2 bg-black/10 border-black/20 text-black hover:bg-black/20 rounded-xl transition-all text-sm"><i class="fas fa-print text-red-500"></i> Printer</a>
                    <a href="{{ route('services.pc') }}" class="flex items-center gap-2 px-4 py-2 bg-black/10 border-black/20 text-black hover:bg-black/20 rounded-xl transition-all text-sm"><i class="fas fa-desktop text-red-500"></i> PC</a>
                    <a href="{{ route('services.software') }}" class="flex items-center gap-2 px-4 py-2 bg-black/10 border-black/20 text-black hover:bg-black/20 rounded-xl transition-all text-sm"><i class="fas fa-compact-disc text-red-500"></i> Software</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== STATS ===================== -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center" data-animate>
                <div class="w-14 h-14 mx-auto rounded-full bg-red-600 flex items-center justify-center mb-3 shadow-lg">
                    <i class="fas fa-history text-white text-xl"></i>
                </div>
                <div class="text-4xl font-black text-gradient stat-number" data-counter="{{ $stats['experience'] }}">0</div>
                <p class="text-gray-600 text-sm mt-2 font-medium">Tahun Pengalaman</p>
            </div>
            <div class="text-center" data-animate>
                <div class="w-14 h-14 mx-auto rounded-full bg-red-600 flex items-center justify-center mb-3 shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="text-4xl font-black text-gradient-warm stat-number" data-counter="{{ $stats['customers'] }}">0</div>
                <p class="text-gray-600 text-sm mt-2 font-medium">Pelanggan Puas</p>
            </div>
            <div class="text-center" data-animate>
                <div class="w-14 h-14 mx-auto rounded-full bg-red-600 flex items-center justify-center mb-3 shadow-lg">
                    <i class="fas fa-tools text-white text-xl"></i>
                </div>
                <div class="text-4xl font-black text-gradient stat-number" data-counter="{{ $stats['services'] * 10 + 100 }}">0</div>
                <p class="text-gray-600 text-sm mt-2 font-medium">Perangkat Diperbaiki/Bln</p>
            </div>
            <div class="text-center" data-animate>
                <div class="w-14 h-14 mx-auto rounded-full bg-red-600 flex items-center justify-center mb-3 shadow-lg">
                    <i class="fas fa-th-large text-white text-xl"></i>
                </div>
                <div class="text-4xl font-black text-gradient stat-number" data-counter="{{ $stats['services'] }}">0</div>
                <p class="text-gray-600 text-sm mt-2 font-medium">Jenis Layanan</p>
            </div>
        </div>
    </div>
</section>

<div class="section-line"></div>

<!-- ===================== PROMOS ===================== -->
@if($activePromos->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i class="fas fa-bullhorn mr-1"></i> Penawaran Spesial</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-3">Promo <span class="text-gradient">Terbaru</span> Kami</h2>
            <p class="text-gray-600 mt-4 max-w-xl mx-auto">Manfaatkan promo menarik untuk layanan service pilihan Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($activePromos as $promo)
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-xl border border-red-500/5 transition-all hover:scale-[1.02]" data-animate>
                <div class="aspect-[16/9] relative overflow-hidden">
                    @if($promo->image)
                    <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center text-white text-4xl">
                        <i class="fas fa-tags"></i>
                    </div>
                    @endif
                    @if($promo->discount_info)
                    <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-xl font-bold text-sm shadow-lg">
                        {{ $promo->discount_info }}
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $promo->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $promo->description }}</p>
                    <div class="text-xs text-gray-500">
                        <i class="fas fa-clock mr-1"></i> S/D {{ $promo->end_date->format('d M') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===================== FEATURED SERVICES ===================== -->
@if($featuredServices->count() > 0)
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i class="fas fa-star mr-1"></i> Layanan Terbaik</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-3">Layanan <span class="text-gradient">Unggulan</span> Kami</h2>
            <p class="text-gray-600 mt-4 max-w-xl mx-auto">Perbaikan profesional dengan garansi kualitas dan kepuasan pelanggan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredServices as $service)
            <div class="service-card p-6 rounded-2xl" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="text-3xl">
                        {!! $service->category === 'laptop' ? '<i class="fas fa-laptop text-red-600"></i>' : ($service->category === 'printer' ? '<i class="fas fa-print text-red-600"></i>' : '<i class="fas fa-desktop text-red-600"></i>') !!}
                    </div>
                    <span class="badge badge-{{ $service->category === 'laptop' ? 'gray' : ($service->category === 'printer' ? 'dark' : 'red') }}">
                        {{ $service->category_label }}
                    </span>
                </div>
                <h3 class="text-gray-900 font-bold text-lg mb-2">{{ $service->name }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->short_description ?? Str::limit($service->description, 100) }}</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 font-bold">{{ $service->price_range }}</p>
                        <p class="text-gray-500 text-xs">Est. {{ $service->estimated_days }} hari kerja</p>
                    </div>
                    <a href="{{ route('services.show', $service->slug) }}" class="btn-primary inline-flex items-center gap-1 px-4 py-2 rounded-xl text-white text-sm font-semibold">
                        Detail
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10" data-animate>
            <a href="{{ route('services.index') }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-red-600 font-bold">
                Lihat Semua Layanan
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ===================== WHY US ===================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i></i> Keunggulan Kami</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-3">Mengapa Memilih <span class="text-gradient">Alsha Media Center</span>?</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => '<i class="fas fa-trophy text-white"></i>', 'title' => 'Teknisi Bersertifikat', 'desc' => 'Tim teknisi kami berpengalaman dan bersertifikat resmi', 'color' => 'yellow'],
                ['icon' => '<i class="fas fa-bolt text-white"></i>', 'title' => 'Pengerjaan Cepat', 'desc' => 'Kebanyakan perbaikan selesai dalam 1-3 hari kerja', 'color' => 'blue'],
                ['icon' => '<i class="fas fa-lock text-white"></i>', 'title' => 'Garansi 30 Hari', 'desc' => 'Setiap perbaikan bergaransi penuh selama 30 hari', 'color' => 'green'],
                ['icon' => '<i class="fas fa-gem text-white"></i>', 'title' => 'Spare Part Original', 'desc' => 'Menggunakan komponen original berkualitas tinggi', 'color' => 'purple'],
            ] as $item)
            <div class="service-card p-6 rounded-2xl text-center" data-animate>
                <div class="w-16 h-16 mx-auto rounded-full bg-red-600 flex items-center justify-center mb-4 shadow-lg animate-float">
                    {!! $item['icon'] !!}
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $item['title'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== HOW IT WORKS ===================== -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i class="fas fa-tasks mr-1"></i> Proses Service Kami?</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-3">4 Langkah Mudah Service di <span class="text-gradient">AMC</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
            <div class="hidden md:block absolute top-10 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-red-600 via-red-600 to-red-600 z-0"></div>
            @foreach([
                ['step' => '01', 'icon' => '<i class="fas fa-phone-volume text-white"></i>', 'title' => 'Hubungi Kami', 'desc' => 'Sampaikan masalah perangkat anda melalui whatsapp, telepon, atau datang langsung'],
                ['step' => '02', 'icon' => '<i class="fas fa-clipboard text-white"></i>', 'title' => 'Cek & Estimasi', 'desc' => 'Teknisi kami akan mengecek perangkat Anda dan memberikan estimasi biaya'],
                ['step' => '03', 'icon' => '<i class="fas fa-wrench text-white"></i>', 'title' => 'Proses Service', 'desc' => 'Perbaikan dilakukan dengan cepat menggunakan sparepart original berkualitas dan teknisi berpengalaman'],
                ['step' => '04', 'icon' => '<i class="fas fa-check text-white"></i>', 'title' => 'Selesai & Garansi', 'desc' => 'Perangkat Anda siap digunakan kembali dengan garansi 30 hari untuk setiap layanan yang kami berikan'],
            ] as $step)
            <div class="text-center relative z-10" data-animate>
                <div class="w-20 h-20 mx-auto rounded-full gradient-anim flex items-center justify-center text-3xl mb-4 shadow-2xl">{!! $step['icon'] !!}</div>
                <div class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-600 text-white text-xs font-bold mb-3">{{ $step['step'] }}</div>
                <h3 class="font-bold text-gray-900 text-base mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== TESTIMONIALS ===================== -->
@if($testimonials->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i class="fas fa-comment-dots mr-1"></i> Testimoni</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-3">Apa Kata <span class="text-gradient-warm">Pelanggan</span> Kami?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
            <div class="service-card p-6 rounded-2xl" data-animate>
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="text-{{ $i <= $t->rating ? 'yellow-400' : 'slate-600' }}"><i class="fas fa-star text-xs"></i></span>
                    @endfor
                </div>
                <p class="text-gray-700 text-sm leading-relaxed mb-5 italic">"{{ $t->comment }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full gradient-anim flex items-center justify-center text-gray-900 font-bold text-sm">
                        {{ strtoupper(substr($t->customer_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-semibold text-sm">{{ $t->customer_name }}</p>
                        <p class="text-gray-500 text-xs">
                            {!! $t->service_type === 'laptop' ? '<i class="fas fa-laptop text-red-600"></i> Service Laptop' : ($t->service_type === 'printer' ? '<i class="fas fa-print text-red-600"></i> Service Printer' : '<i class="fas fa-desktop text-red-600"></i> Service PC') !!}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===================== MAP SECTION ===================== -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i class="fas fa-map-marker-alt mr-1"></i> Lokasi Toko</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-3">Temukan <span class="text-gradient">Kami di Sini</span></h2>
            <p class="text-gray-600 mt-4">{{ $store->address ?? 'Jl. Raya Bangsri No 02. Kecamatan Bangsri' }}, {{ $store->city ?? 'Bangsri, Jawa Tengah' }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Map -->
            <div class="lg:col-span-2" data-animate>
                @if($store && $store->google_maps_link)
                <iframe src="{{ $store->google_maps_link }}" width="100%" style="border:0; min-height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-2xl shadow-2xl border border-red-600/10"></iframe>
                @else
                <div id="map" class="rounded-2xl shadow-2xl border border-red-600/10"></div>
                @endif
            </div>

            <!-- Store Info -->
            <div class="space-y-4" data-animate>
                @if($store)
                <div class="service-card p-5 rounded-2xl">
                    <h3 class="font-bold text-gray-900 mb-1"><i class="fas fa-map-marker-alt text-red-500"></i> Alamat</h3>
                    <p class="text-gray-600 text-sm">{{ $store->address }}, {{ $store->city }}</p>
                </div>
                <div class="service-card p-5 rounded-2xl">
                    <h3 class="font-bold text-gray-900 mb-1"><i class="fas fa-clock"></i> Jam Operasional</h3>
                    <p class="text-gray-600 text-sm">{{ $store->open_days }}</p>
                    <p class="text-red-600 font-semibold text-sm">{{ $store->open_hours }}</p>
                </div>
                <div class="service-card p-5 rounded-2xl">
                    <h3 class="font-bold text-gray-900 mb-3"><i class="fas fa-phone-alt text-red-600"></i> Hubungi Kami</h3>
                    <div class="space-y-2">
                        <a href="tel:{{ $store->phone }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 text-sm transition-colors">
                            <i class="fas fa-phone-alt text-red-600"></i> {{ $store->phone }}
                        </a>
                        @if($store->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}" class="flex items-center gap-2 text-gray-600 hover:text-red-600 text-sm transition-colors">
                            <i class="fas fa-comments text-red-600"></i> WhatsApp
                        </a>
                        @endif
                        <a href="mailto:{{ $store->email }}" class="flex items-center gap-2 text-gray-600 hover:text-red-600 text-sm transition-colors">
                            <i class="fas fa-envelope text-red-600"></i> {{ $store->email }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-red-800 opacity-90"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <h2 class="text-4xl sm:text-5xl font-black text-white mb-6">Siap Perbaiki Perangkat Anda?</h2>
        <p class="text-gray-300 text-lg mb-10">Jangan biarkan masalah elektronik mengganggu produktivitas Anda. Hubungi kami sekarang!</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20konsultasi..." target="_blank" class="bg-white inline-flex items-center gap-2 px-10 py-5 rounded-2xl text-red-800 font-bold text-lg">
                <i class="fab fa-whatsapp"></i> Kontak Kami
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
@if(!($store && $store->google_maps_link))
@php
    $storeData = [
        'lat' => $store->latitude ?? -6.9147,
        'lng' => $store->longitude ?? 107.6098,
        'address' => $store->address ?? 'Jl. Raya Bangsri No 02. Kecamatan Bangsri',
        'city' => $store->city ?? 'Bangsri, Jawa Tengah',
        'open_days' => $store->open_days ?? 'Buka',
        'open_hours' => $store->open_hours ?? '08:00 - 20:00'
    ];
@endphp
<script>
    const storeData = {{ json_encode($storeData) }};

    const map = L.map('map').setView([storeData.lat, storeData.lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const icon = L.divIcon({ 
        html: `<div style="background:linear-gradient(135deg,#dc2626,#991b1b);width:40px;height:40px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 15px rgba(220,38,38,0.5);border:3px solid white;display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:18px;"><i class="fas fa-wrench text-white"></i></span></div>`, 
        className: '', 
        iconSize: [40,40], 
        iconAnchor: [20,40] 
    });

    L.marker([storeData.lat, storeData.lng], { icon })
        .addTo(map)
        .bindPopup(`
            <div style="font-family:Inter,sans-serif;padding:8px;min-width:200px;">
                <strong style="color:#dc2626;font-size:15px;"><i class="fas fa-wrench text-red-600"></i> Alsha Media Center</strong><br>
                <span style="color:#64748b;font-size:13px;">${storeData.address}, ${storeData.city}</span><br>
                <span style="color:#4b5563;font-size:12px;font-weight:600;"><i class="fas fa-clock text-red-500"></i> ${storeData.open_days}: ${storeData.open_hours}</span>
            </div>
        `, { maxWidth: 250 })
        .openPopup();
</script>
@endif
@endpush