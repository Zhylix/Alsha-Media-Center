@extends('layouts.app')

@section('title', 'Alsha Media Center - Jasa Service Laptop, Printer & HP Terpercaya Bandung')

@section('content')

<!-- ===================== HERO ===================== -->
<section class="relative min-h-screen bg-hero flex items-center overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="particle w-2 h-2 top-1/4 left-1/5 opacity-60" style="animation-delay: 0s;"></div>
        <div class="particle w-3 h-3 top-1/3 left-2/3 opacity-40" style="animation-delay: 1s;"></div>
        <div class="particle w-2 h-2 top-2/3 left-1/4 opacity-50" style="animation-delay: 2s;"></div>
        <div class="particle w-4 h-4 top-3/4 left-3/4 opacity-30" style="animation-delay: 0.5s;"></div>
        <div class="particle w-1 h-1 top-1/2 left-1/2 opacity-70" style="animation-delay: 1.5s;"></div>

        <!-- Glow circles -->
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass border border-blue-500/20 text-blue-400 text-sm font-medium mb-6 animate-fade-up">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Terpercaya sejak {{ date('Y') - ($stats['experience'] ?? 10) }} · {{ $store->city ?? 'Bandung, Jawa Barat' }}
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-6 animate-fade-up" style="animation-delay: 0.1s;">
                    Jasa Service
                    <span class="text-gradient block">Elektronik</span>
                    Terpercaya
                </h1>

                <p class="text-slate-400 text-lg leading-relaxed mb-8 animate-fade-up" style="animation-delay: 0.2s;">
                    Spesialis perbaikan <strong class="text-white">laptop</strong>, <strong class="text-white">printer</strong>, dan <strong class="text-white">handphone</strong>.
                    Teknisi berpengalaman, spare part original, garansi 30 hari. Antar jemput tersedia!
                </p>

                <div class="flex flex-wrap gap-4 mb-10 animate-fade-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('order.create') }}" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold text-base">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Pesan Sekarang
                    </a>
                    <a href="{{ route('services.index') }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold text-base">
                        Lihat Layanan
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <!-- Quick Category Buttons -->
                <div class="flex flex-wrap gap-3 animate-fade-up" style="animation-delay: 0.4s;">
                    <a href="{{ route('services.laptop') }}" class="flex items-center gap-2 px-4 py-2 glass rounded-xl hover:border-blue-400/30 transition-all text-sm text-slate-300 hover:text-white"><i class="fas fa-laptop text-blue-400"></i> Laptop</a>
                    <a href="{{ route('services.printer') }}" class="flex items-center gap-2 px-4 py-2 glass rounded-xl hover:border-blue-400/30 transition-all text-sm text-slate-300 hover:text-white"><i class="fas fa-print text-purple-400"></i> Printer</a>
                    <a href="{{ route('services.hp') }}" class="flex items-center gap-2 px-4 py-2 glass rounded-xl hover:border-blue-400/30 transition-all text-sm text-slate-300 hover:text-white"><i class="fas fa-mobile-alt text-green-400"></i> HP</a>
                </div>
            </div>

            <!-- Right - Hero Cards (Dynamic from CRUD) -->
            <div class="grid grid-cols-2 gap-4 animate-fade-up" style="animation-delay: 0.3s;">
                <!-- Laptop Card -->
                @if($heroLaptop)
                <div class="service-card p-6 rounded-2xl text-center hover-glow group">
                    <div class="text-4xl mb-3 animate-float"><i class="fas fa-laptop text-blue-400"></i></div>
                    <h3 class="font-bold text-white text-sm mb-1">{{ $heroLaptop->name }}</h3>
                    <p class="text-slate-500 text-xs mt-1 line-clamp-2">{{ $heroLaptop->short_description }}</p>
                    <p class="text-blue-400 font-bold text-sm mt-3">{{ $heroLaptop->price_range }}</p>
                    <p class="text-slate-400 text-xs mt-1">Est. {{ $heroLaptop->estimated_days }} hari</p>
                </div>
                @else
                <div class="service-card p-6 rounded-2xl text-center hover-glow">
                    <div class="text-4xl mb-3 animate-float"><i class="fas fa-laptop text-blue-400"></i></div>
                    <h3 class="font-bold text-white text-sm">Service Laptop</h3>
                    <p class="text-slate-500 text-xs mt-1">Data belum tersedia</p>
                </div>
                @endif

                <!-- Printer Card -->
                @if($heroPrinter)
                <div class="service-card p-6 rounded-2xl text-center hover-glow group" style="margin-top: 24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 0.5s;"><i class="fas fa-print text-purple-400"></i></div>
                    <h3 class="font-bold text-white text-sm mb-1">{{ $heroPrinter->name }}</h3>
                    <p class="text-slate-500 text-xs mt-1 line-clamp-2">{{ $heroPrinter->short_description }}</p>
                    <p class="text-purple-400 font-bold text-sm mt-3">{{ $heroPrinter->price_range }}</p>
                    <p class="text-slate-400 text-xs mt-1">Est. {{ $heroPrinter->estimated_days }} hari</p>
                </div>
                @else
                <div class="service-card p-6 rounded-2xl text-center hover-glow" style="margin-top: 24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 0.5s;"><i class="fas fa-print text-purple-400"></i></div>
                    <h3 class="font-bold text-white text-sm">Service Printer</h3>
                    <p class="text-slate-500 text-xs mt-1">Data belum tersedia</p>
                </div>
                @endif

                <!-- HP Card -->
                @if($heroHp)
                <div class="service-card p-6 rounded-2xl text-center hover-glow group" style="margin-top: -24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 1s;"><i class="fas fa-mobile-alt text-green-400"></i></div>
                    <h3 class="font-bold text-white text-sm mb-1">{{ $heroHp->name }}</h3>
                    <p class="text-slate-500 text-xs mt-1 line-clamp-2">{{ $heroHp->short_description }}</p>
                    <p class="text-cyan-400 font-bold text-sm mt-3">{{ $heroHp->price_range }}</p>
                    <p class="text-slate-400 text-xs mt-1">Est. {{ $heroHp->estimated_days }} hari</p>
                </div>
                @else
                <div class="service-card p-6 rounded-2xl text-center hover-glow" style="margin-top: -24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 1s;"><i class="fas fa-mobile-alt text-green-400"></i></div>
                    <h3 class="font-bold text-white text-sm">Service HP</h3>
                    <p class="text-slate-500 text-xs mt-1">Data belum tersedia</p>
                </div>
                @endif

                <!-- Shipment Card -->
                @if($heroShipment)
                <div class="service-card p-6 rounded-2xl text-center hover-glow group">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 1.5s;"><i class="fas fa-truck text-yellow-400"></i></div>
                    <h3 class="font-bold text-white text-sm mb-1">{{ $heroShipment->name }}</h3>
                    <p class="text-slate-500 text-xs mt-1">{{ $heroShipment->description }}</p>
                    <p class="text-green-400 font-bold text-sm mt-3">{{ $heroShipment->price_display }}</p>
                </div>
                @else
                <div class="service-card p-6 rounded-2xl text-center hover-glow">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 1.5s;"><i class="fas fa-truck text-yellow-400"></i></div>
                    <h3 class="font-bold text-white text-sm">Antar Jemput</h3>
                    <p class="text-slate-500 text-xs mt-1">Data belum tersedia</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ===================== STATS ===================== -->
<section class="py-16 bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center" data-animate>
                <div class="text-4xl font-black text-gradient stat-number" data-counter="{{ $stats['experience'] }}">0</div>
                <p class="text-slate-400 text-sm mt-2 font-medium">Tahun Pengalaman</p>
            </div>
            <div class="text-center" data-animate>
                <div class="text-4xl font-black text-gradient-warm stat-number" data-counter="{{ $stats['customers'] }}">0</div>
                <p class="text-slate-400 text-sm mt-2 font-medium">Pelanggan Puas</p>
            </div>
            <div class="text-center" data-animate>
                <div class="text-4xl font-black text-gradient-green stat-number" data-counter="{{ $stats['services'] * 10 + 100 }}">0</div>
                <p class="text-slate-400 text-sm mt-2 font-medium">Perangkat Diperbaiki/Bln</p>
            </div>
            <div class="text-center" data-animate>
                <div class="text-4xl font-black text-gradient stat-number" data-counter="{{ $stats['services'] }}">0</div>
                <p class="text-slate-400 text-sm mt-2 font-medium">Jenis Layanan</p>
            </div>
        </div>
    </div>
</section>

<div class="section-line"></div>

<!-- ===================== FEATURED SERVICES ===================== -->
@if($featuredServices->count() > 0)
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-blue-400 text-sm font-bold uppercase tracking-widest">Layanan Terbaik</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white mt-3">Layanan <span class="text-gradient">Unggulan</span> Kami</h2>
            <p class="text-slate-400 mt-4 max-w-xl mx-auto">Perbaikan profesional dengan garansi kualitas dan kepuasan pelanggan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredServices as $service)
            <div class="service-card p-6 rounded-2xl" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="text-3xl">
                        {!! $service->category === 'laptop' ? '<i class="fas fa-laptop text-blue-400"></i>' : ($service->category === 'printer' ? '<i class="fas fa-print text-purple-400"></i>' : '<i class="fas fa-mobile-alt text-green-400"></i>') !!}
                    </div>
                    <span class="badge badge-{{ $service->category === 'laptop' ? 'blue' : ($service->category === 'printer' ? 'purple' : 'green') }}">
                        {{ $service->category_label }}
                    </span>
                </div>
                <h3 class="text-white font-bold text-lg mb-2">{{ $service->name }}</h3>
                <p class="text-slate-400 text-sm mb-4 line-clamp-2">{{ $service->short_description ?? Str::limit($service->description, 100) }}</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-400 font-bold">{{ $service->price_range }}</p>
                        <p class="text-slate-500 text-xs">Est. {{ $service->estimated_days }} hari kerja</p>
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
            <a href="{{ route('services.index') }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold">
                Lihat Semua Layanan
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ===================== WHY US ===================== -->
<section class="py-20 bg-slate-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-purple-400 text-sm font-bold uppercase tracking-widest">Keunggulan Kami</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white mt-3">Mengapa Memilih <span class="text-gradient">Alsha Media Center</span>?</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => '<i class="fas fa-trophy text-yellow-400"></i>', 'title' => 'Teknisi Bersertifikat', 'desc' => 'Tim teknisi kami berpengalaman dan bersertifikat resmi', 'color' => 'yellow'],
                ['icon' => '<i class="fas fa-bolt text-blue-400"></i>', 'title' => 'Pengerjaan Cepat', 'desc' => 'Kebanyakan perbaikan selesai dalam 1-3 hari kerja', 'color' => 'blue'],
                ['icon' => '<i class="fas fa-lock"></i>', 'title' => 'Garansi 30 Hari', 'desc' => 'Setiap perbaikan bergaransi penuh selama 30 hari', 'color' => 'green'],
                ['icon' => '<i class="fas fa-gem"></i>', 'title' => 'Spare Part Original', 'desc' => 'Menggunakan komponen original berkualitas tinggi', 'color' => 'purple'],
            ] as $item)
            <div class="service-card p-6 rounded-2xl text-center" data-animate>
                <div class="text-5xl mb-4 animate-float">{!! $item['icon'] !!}</div>
                <h3 class="font-bold text-white text-lg mb-2">{{ $item['title'] }}</h3>
                <p class="text-slate-400 text-sm">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== HOW IT WORKS ===================== -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-cyan-400 text-sm font-bold uppercase tracking-widest">Cara Kerja</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white mt-3">Proses <span class="text-gradient">Mudah & Cepat</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
            <div class="hidden md:block absolute top-10 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500 z-0"></div>
            @foreach([
                ['step' => '01', 'icon' => '<i class="fas fa-file-alt"></i>', 'title' => 'Pilih Layanan', 'desc' => 'Pilih jenis service yang Anda butuhkan'],
                ['step' => '02', 'icon' => '<i class="fas fa-box text-amber-500"></i>', 'title' => 'Kirim Perangkat', 'desc' => 'Antar langsung atau gunakan jasa pengiriman'],
                ['step' => '03', 'icon' => '<i class="fas fa-wrench text-orange-400"></i>', 'title' => 'Proses Perbaikan', 'desc' => 'Teknisi kami mengerjakan dengan profesional'],
                ['step' => '04', 'icon' => '<i class="fas fa-check text-green-500"></i>', 'title' => 'Terima Kembali', 'desc' => 'Perangkat Anda siap diambil atau dikirim balik'],
            ] as $step)
            <div class="text-center relative z-10" data-animate>
                <div class="w-20 h-20 mx-auto rounded-full gradient-anim flex items-center justify-center text-3xl mb-4 shadow-2xl">{!! $step['icon'] !!}</div>
                <div class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-500 text-white text-xs font-bold mb-3">{{ $step['step'] }}</div>
                <h3 class="font-bold text-white text-base mb-2">{{ $step['title'] }}</h3>
                <p class="text-slate-400 text-sm">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== TESTIMONIALS ===================== -->
@if($testimonials->count() > 0)
<section class="py-20 bg-slate-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-animate>
            <span class="text-yellow-400 text-sm font-bold uppercase tracking-widest">Testimoni</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white mt-3">Apa Kata <span class="text-gradient-warm">Pelanggan</span> Kami?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
            <div class="service-card p-6 rounded-2xl" data-animate>
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="text-{{ $i <= $t->rating ? 'yellow-400' : 'slate-600' }}"><i class="fas fa-star text-xs"></i></span>
                    @endfor
                </div>
                <p class="text-slate-300 text-sm leading-relaxed mb-5 italic">"{{ $t->comment }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full gradient-anim flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($t->customer_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">{{ $t->customer_name }}</p>
                        <p class="text-slate-500 text-xs">
                            {!! $t->service_type === 'laptop' ? '<i class="fas fa-laptop text-blue-400"></i> Service Laptop' : ($t->service_type === 'printer' ? '<i class="fas fa-print text-purple-400"></i> Service Printer' : '<i class="fas fa-mobile-alt text-green-400"></i> Service HP') !!}
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
            <span class="text-green-400 text-sm font-bold uppercase tracking-widest">Lokasi Toko</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white mt-3">Temukan <span class="text-gradient-green">Kami di Sini</span></h2>
            <p class="text-slate-400 mt-4">{{ $store->address ?? 'Jl. Asia Afrika No. 123' }}, {{ $store->city ?? 'Bandung, Jawa Barat' }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Map -->
            <div class="lg:col-span-2" data-animate>
                <div id="map" class="rounded-2xl shadow-2xl border border-blue-500/10"></div>
            </div>

            <!-- Store Info -->
            <div class="space-y-4" data-animate>
                @if($store)
                <div class="service-card p-5 rounded-2xl">
                    <h3 class="font-bold text-white mb-1"><i class="fas fa-map-marker-alt text-red-500"></i> Alamat</h3>
                    <p class="text-slate-400 text-sm">{{ $store->address }}, {{ $store->city }}</p>
                </div>
                <div class="service-card p-5 rounded-2xl">
                    <h3 class="font-bold text-white mb-1"><i class="fas fa-clock"></i> Jam Operasional</h3>
                    <p class="text-slate-400 text-sm">{{ $store->open_days }}</p>
                    <p class="text-blue-400 font-semibold text-sm">{{ $store->open_hours }}</p>
                </div>
                <div class="service-card p-5 rounded-2xl">
                    <h3 class="font-bold text-white mb-3"><i class="fas fa-phone-alt text-green-400"></i> Hubungi Kami</h3>
                    <div class="space-y-2">
                        <a href="tel:{{ $store->phone }}" class="flex items-center gap-2 text-slate-400 hover:text-white text-sm transition-colors">
                            <i class="fas fa-phone-alt text-green-400"></i> {{ $store->phone }}
                        </a>
                        @if($store->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}" class="flex items-center gap-2 text-slate-400 hover:text-green-400 text-sm transition-colors">
                            <i class="fas fa-comments text-green-500"></i> WhatsApp
                        </a>
                        @endif
                        <a href="mailto:{{ $store->email }}" class="flex items-center gap-2 text-slate-400 hover:text-blue-400 text-sm transition-colors">
                            <i class="fas fa-envelope text-blue-400"></i> {{ $store->email }}
                        </a>
                    </div>
                </div>
                @endif
                <a href="https://maps.google.com/?q={{ $store->latitude ?? -6.9147 }},{{ $store->longitude ?? 107.6098 }}" target="_blank" class="btn-primary w-full flex items-center justify-center gap-2 px-6 py-3 rounded-2xl text-white font-bold">
                    <i class="fas fa-map text-emerald-400"></i> Buka di Google Maps
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===================== CTA ===================== -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 gradient-anim opacity-10"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <h2 class="text-4xl sm:text-5xl font-black text-white mb-6">Siap Perbaiki Perangkat Anda?</h2>
        <p class="text-slate-400 text-lg mb-10">Jangan biarkan masalah elektronik mengganggu produktivitas Anda. Hubungi kami sekarang!</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('order.create') }}" class="btn-primary inline-flex items-center gap-2 px-10 py-5 rounded-2xl text-white font-bold text-lg">
                <i class="fas fa-wrench text-orange-400"></i> Pesan Service Sekarang
            </a>
            <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}" target="_blank" class="btn-outline inline-flex items-center gap-2 px-10 py-5 rounded-2xl text-white font-bold text-lg">
                <i class="fas fa-comments text-green-500"></i> Chat via WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    const map = L.map('map').setView([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const icon = L.divIcon({
        html: `<div style="background:linear-gradient(135deg,#3b82f6,#8b5cf6);width:40px;height:40px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(59,130,246,0.5);border:3px solid white;">
            <span style="transform:rotate(45deg);font-size:18px;"><i class="fas fa-wrench text-orange-400"></i></span></div>`,
        className: '',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
    });

    L.marker([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], { icon })
        .addTo(map)
        .bindPopup(`
            <div style="font-family:Inter,sans-serif;padding:8px;min-width:200px;">
                <strong style="color:#3b82f6;font-size:15px;"><i class="fas fa-wrench text-orange-400"></i> Alsha Media Center</strong><br>
                <span style="color:#64748b;font-size:13px;">{{ $store->address ?? 'Jl. Asia Afrika No. 123' }}, {{ $store->city ?? 'Bandung' }}</span><br>
                <span style="color:#10b981;font-size:12px;font-weight:600;"><i class="fas fa-clock"></i> {{ $store->open_days ?? 'Buka' }}: {{ $store->open_hours ?? '08:00 - 20:00' }}</span>
            </div>
        `, { maxWidth: 250 })
        .openPopup();
</script>
@endpush
