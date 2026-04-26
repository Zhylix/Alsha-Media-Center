@extends('layouts.app')

@section('title', 'Alsha Media Center - Jasa Service Laptop, Printer & HP Terpercaya Bangsri')

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
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass border border-red-600/20 text-red-600 text-sm font-medium mb-6 animate-fade-up">
                    <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                    Terpercaya sejak {{ date('Y') - ($stats['experience'] ?? 5) }} · {{ $store->city ?? 'Bangsri, Jawa Tengah' }}
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-6 animate-fade-up" style="animation-delay: 0.1s;">
                    Jasa Service
                    <span class="text-gradient block">Elektronik</span>
                    Terpercaya
                </h1>

                <p class="text-gray-600 text-lg leading-relaxed mb-8 animate-fade-up" style="animation-delay: 0.2s;">
                    Spesialis perbaikan <strong class="text-gray-900">PC</strong>, <strong class="text-gray-900">laptop</strong>, dan <strong class="text-gray-900">printer</strong>.
                    Teknisi berpengalaman, spare part original, garansi 30 hari. Antar jemput tersedia!
                </p>

                <div class="flex flex-wrap gap-4 mb-10 animate-fade-up" style="animation-delay: 0.3s;">
                    <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20konsultasi..." target="_blank" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold text-base">
                        <i class="fab fa-whatsapp"></i>
                        Chat WhatsApp
                    </a>
                    <a href="{{ route('services.index') }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-red-600 font-bold text-base">
                        Lihat Layanan
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <!-- Quick Category Buttons -->
                <div class="flex flex-wrap gap-3 animate-fade-up" style="animation-delay: 0.4s;">
                    <a href="{{ route('services.pc') }}" class="flex items-center gap-2 px-4 py-2 glass rounded-xl hover:border-red-600/30 transition-all text-sm text-gray-700 hover:text-gray-900"><i class="fas fa-desktop text-red-600"></i> PC</a>
                    <a href="{{ route('services.laptop') }}" class="flex items-center gap-2 px-4 py-2 glass rounded-xl hover:border-red-600/30 transition-all text-sm text-gray-700 hover:text-gray-900"><i class="fas fa-laptop text-red-600"></i> Laptop</a>
                    <a href="{{ route('services.printer') }}" class="flex items-center gap-2 px-4 py-2 glass rounded-xl hover:border-red-600/30 transition-all text-sm text-gray-700 hover:text-gray-900"><i class="fas fa-print text-red-600"></i> Printer</a>
                </div>
            </div>

            <!-- Right - Hero Cards (Dynamic from CRUD) -->
            <div class="grid grid-cols-2 gap-4 animate-fade-up" style="animation-delay: 0.3s;">
                <!-- Laptop Card -->
                @if($heroLaptop)
                <div class="service-card p-6 rounded-2xl text-center hover-glow group">
                    <div class="text-4xl mb-3 animate-float"><i class="fas fa-laptop text-red-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $heroLaptop->name }}</h3>
                    <p class="text-gray-500 text-xs mt-1 line-clamp-2">{{ $heroLaptop->short_description }}</p>
                    <p class="text-red-600 font-bold text-sm mt-3">{{ $heroLaptop->price_range }}</p>
                    <p class="text-gray-600 text-xs mt-1">Est. {{ $heroLaptop->estimated_days }} hari</p>
                </div>
                @else
                <div class="service-card p-6 rounded-2xl text-center hover-glow">
                    <div class="text-4xl mb-3 animate-float"><i class="fas fa-laptop text-red-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm">Service Laptop</h3>
                    <p class="text-gray-500 text-xs mt-1">Data belum tersedia</p>
                </div>
                @endif

                <!-- Printer Card -->
                @if($heroPrinter)
                <div class="service-card p-6 rounded-2xl text-center hover-glow group" style="margin-top: 24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 0.5s;"><i class="fas fa-print text-red-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $heroPrinter->name }}</h3>
                    <p class="text-gray-500 text-xs mt-1 line-clamp-2">{{ $heroPrinter->short_description }}</p>
                    <p class="text-red-600 font-bold text-sm mt-3">{{ $heroPrinter->price_range }}</p>
                    <p class="text-gray-600 text-xs mt-1">Est. {{ $heroPrinter->estimated_days }} hari</p>
                </div>
                @else
                <div class="service-card p-6 rounded-2xl text-center hover-glow" style="margin-top: 24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 0.5s;"><i class="fas fa-print text-red-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm">Service Printer</h3>
                    <p class="text-gray-500 text-xs mt-1">Data belum tersedia</p>
                </div>
                @endif

                <!-- PC Card -->
                @if($heroPc)
                <div class="service-card p-6 rounded-2xl text-center hover-glow group" style="margin-top: -24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 1s;"><i class="fas fa-desktop text-red-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $heroPc->name }}</h3>
                    <p class="text-gray-500 text-xs mt-1 line-clamp-2">{{ $heroPc->short_description }}</p>
                    <p class="text-red-600 font-bold text-sm mt-3">{{ $heroPc->price_range }}</p>
                    <p class="text-gray-600 text-xs mt-1">Est. {{ $heroPc->estimated_days }} hari</p>
                </div>
                @else
                <div class="service-card p-6 rounded-2xl text-center hover-glow" style="margin-top: -24px;">
                    <div class="text-4xl mb-3 animate-float" style="animation-delay: 1s;"><i class="fas fa-desktop text-red-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm">Service PC</h3>
                    <p class="text-gray-500 text-xs mt-1">Data belum tersedia</p>
                </div>
                @endif
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
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i class="fas fa-award mr-1"></i> Keunggulan Kami</span>
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

<!-- ===================== CTA ===================== -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 gradient-anim opacity-10"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6">Siap Perbaiki Perangkat Anda?</h2>
        <p class="text-gray-600 text-lg mb-10">Jangan biarkan masalah elektronik mengganggu produktivitas Anda. Hubungi kami sekarang!</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20konsultasi..." target="_blank" class="btn-primary inline-flex items-center gap-2 px-10 py-5 rounded-2xl text-white font-bold text-lg">
                <i class="fab fa-whatsapp text-white"></i> Chat WhatsApp
            </a>
            <a href="{{ route('contact') }}" class="btn-outline inline-flex items-center gap-2 px-10 py-5 rounded-2xl text-red-600 font-bold text-lg">
                <i class="fas fa-phone-alt text-red-600"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
@if(!($store && $store->google_maps_link))
<script>
    const map = L.map('map').setView([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const icon = L.divIcon({ html: `<div style="background:linear-gradient(135deg,#dc2626,#991b1b);width:40px;height:40px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 15px rgba(220,38,38,0.5);border:3px solid white;display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:18px;"><i class="fas fa-wrench text-white"></i></span></div>`, className: '', iconSize:[40,40], iconAnchor:[20,40] });

    L.marker([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], { icon })
        .addTo(map)
        .bindPopup(`
            <div style="font-family:Inter,sans-serif;padding:8px;min-width:200px;">
                <strong style="color:#dc2626;font-size:15px;"><i class="fas fa-wrench text-red-600"></i> Alsha Media Center</strong><br>
                <span style="color:#64748b;font-size:13px;">{{ $store->address ?? 'Jl. Raya Bangsri No 02. Kecamatan Bangsri' }}, {{ $store->city ?? 'Bangsri, Jawa Tengah' }}</span><br>
                <span style="color:#4b5563;font-size:12px;font-weight:600;"><i class="fas fa-clock text-red-500"></i> {{ $store->open_days ?? 'Buka' }}: {{ $store->open_hours ?? '08:00 - 20:00' }}</span>
            </div>
        `, { maxWidth: 250 })
        .openPopup();
</script>
@endif
@endpush
