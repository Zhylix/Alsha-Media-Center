@extends('layouts.app')

@section('title', 'AMC | Service Bangsri')

@section('content')

@php
$heroImageUrl = $store && $store->hero_image ? asset('storage/' . $store->hero_image) : asset('images/image.png');
@endphp

<!-- ===================== HERO ===================== -->
<section class="amc-hero relative min-h-screen overflow-hidden flex items-center">
    <!-- Background Architecture -->
    <div class="absolute inset-0 bg-white"></div>
    
    <!-- Diagonal Red Panel -->
    <div class="absolute inset-y-0 right-0 w-[55%] bg-[#C8000A] clip-diagonal hidden lg:block"></div>
    
    <!-- Hero Image overlay on red panel -->
    <div 
        class="absolute inset-y-0 right-0 w-[55%] hidden lg:block clip-diagonal"
        style="background-image: url('{{ $heroImageUrl }}'); background-size: cover; background-position: center; opacity: 0.15;"
    ></div>

    <!-- Geometric accents -->
    <div class="absolute top-0 right-[45%] w-px h-full bg-red-100 hidden lg:block"></div>
    <div class="absolute bottom-24 left-12 w-24 h-24 border border-red-100 rotate-45 hidden xl:block"></div>
    <div class="absolute top-32 right-[48%] w-3 h-3 bg-[#C8000A] rounded-full hidden lg:block"></div>
    <div class="absolute top-48 right-[46%] w-1.5 h-1.5 bg-red-300 rounded-full hidden lg:block"></div>

    <!-- Mobile background image -->
    <div 
        class="absolute inset-0 lg:hidden"
        style="background-image: url('{{ $heroImageUrl }}'); background-size: cover; background-position: center;"
    ></div>
    <div class="absolute inset-0 lg:hidden bg-gradient-to-b from-white via-white/95 to-white/90"></div>

    <!-- CONTENT -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-28 lg:py-36">
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-20 items-center">
            
            <!-- Left: Copy -->
            <div class="amc-hero-left">
                <!-- Eyebrow -->
                <div class="inline-flex items-center gap-2.5 mb-8">
                    <span class="block w-8 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">
                        Terpercaya Sejak {{ date('Y') - 12 }}
                    </span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-gray-900 leading-[0.95] mb-8 tracking-tight">
                    Solusi<br>
                    <span class="text-[#C8000A]">Service</span><br>
                    Elektronik
                </h1>

                <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-md font-light">
                    Spesialis perbaikan <strong class="text-gray-800 font-semibold">laptop</strong>, <strong class="text-gray-800 font-semibold">printer</strong>, dan <strong class="text-gray-800 font-semibold">komputer</strong>. Teknisi bersertifikat, spare part original, garansi 30 hari.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mb-14">
                    <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC,%20saya%20ingin%20konsultasi..." 
                       target="_blank" 
                       class="amc-btn-primary group inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#C8000A] text-white font-bold text-sm uppercase tracking-widest transition-all duration-300 hover:bg-[#A00008] hover:shadow-2xl hover:shadow-red-900/30 hover:-translate-y-0.5">
                        <i class="fab fa-whatsapp text-base"></i>
                        Chat WhatsApp
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('services.index') }}" 
                       class="inline-flex items-center justify-center gap-3 px-8 py-4 border border-gray-200 text-gray-700 font-bold text-sm uppercase tracking-widest transition-all duration-300 hover:border-[#C8000A] hover:text-[#C8000A]">
                        Lihat Layanan
                    </a>
                </div>

                <!-- Category Pills -->
                <div class="flex flex-wrap gap-3">
                    @foreach([
                        ['route' => route('services.laptop'), 'icon' => 'fa-laptop', 'label' => 'Laptop'],
                        ['route' => route('services.printer'), 'icon' => 'fa-print', 'label' => 'Printer'],
                        ['route' => route('services.pc'), 'icon' => 'fa-desktop', 'label' => 'PC / Komputer'],
                        ['route' => route('services.software'), 'icon' => 'fa-compact-disc', 'label' => 'Software'],
                    ] as $cat)
                    <a href="{{ $cat['route'] }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-100 bg-gray-50 text-gray-600 text-xs font-semibold uppercase tracking-wider hover:border-[#C8000A] hover:text-[#C8000A] hover:bg-red-50 transition-all duration-200">
                        <i class="fas {{ $cat['icon'] }} text-[#C8000A] text-xs"></i>
                        {{ $cat['label'] }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <!-- Bottom marquee strip -->
    <div class="absolute bottom-0 left-0 right-0 bg-[#C8000A] py-3 overflow-hidden">
        <div class="amc-marquee-track flex gap-12 whitespace-nowrap">
            @foreach(['Laptop', 'Printer', 'PC', 'Software', 'Konsultasi Gratis', 'Garansi 30 Hari', 'Spare Part Original'] as $item)
            <span class="text-white text-xs font-black uppercase tracking-[0.15em] flex items-center gap-3">
                <span class="w-1 h-1 bg-white/50 rounded-full inline-block"></span>
                {{ $item }}
            </span>
            @endforeach
            @foreach(['Laptop', 'Printer', 'PC', 'Software', 'Konsultasi Gratis', 'Garansi 30 Hari', 'Spare Part Original'] as $item)
            <span class="text-white text-xs font-black uppercase tracking-[0.15em] flex items-center gap-3">
                <span class="w-1 h-1 bg-white/50 rounded-full inline-block"></span>
                {{ $item }}
            </span>
            @endforeach
        </div>
    </div>
</section>

    <!-- ===================== STATISTICS ===================== -->
    <section class="py-16 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            @if($stats_items->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-{{ min($stats_items->count(), 4) }} lg:grid-cols-{{ $stats_items->count() }} gap-4 lg:gap-6 justify-items-center">
                    @foreach($stats_items as $stat)
                        <div class="group bg-white border border-gray-100 p-4 md:p-5 lg:p-6 text-center shadow-sm hover:shadow-md hover:border-red-100 transition-all duration-300 max-w-xs w-full mx-auto">
                            <div class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-[#C8000A] flex items-center justify-center mb-3 md:mb-4 mx-auto">
                                <i class="{{ $stat->icon }} text-white text-xs md:text-sm lg:text-base"></i>
                            </div>
                            <div class="text-xl md:text-2xl lg:text-3xl font-black text-gray-900 stat-number lg:mb-1" data-counter="{{ $stat->value }}">0</div>
                            <div class="text-xs lg:text-sm text-[#C8000A] font-black uppercase tracking-wider mb-1 md:mb-0.5 hidden lg:block"></div>
                            <div class="text-xs text-gray-400 font-medium">{{ $stat->label }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 md:py-20 lg:py-24 bg-white border border-dashed border-gray-200 rounded-3xl max-w-2xl mx-auto">
                    <i class="fas fa-chart-line text-5xl md:text-6xl lg:text-7xl text-gray-300 mb-6 md:mb-8"></i>
                    <p class="text-xl md:text-2xl lg:text-3xl font-black text-gray-500 mb-3 md:mb-4">Belum ada statistik</p>
                    <span class="text-base md:text-lg text-gray-400 block mb-6 md:mb-8 lg:mb-12">Kelola statistik melalui panel admin</span>
                    <a href="{{ route('admin.stats.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 text-gray-700 font-bold text-sm uppercase tracking-wider hover:border-[#C8000A] hover:text-[#C8000A] transition-all">
                        <i class="fas fa-chart-bar"></i> Kelola Statistik
                    </a>
                </div>
            @endif
        </div>
    </section>


<!-- ===================== PAKET INSTAL WINDOWS ===================== -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between gap-6 mb-14">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2.5 mb-4">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Paket Service</span>
                </div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">Paket <span class="text-[#C8000A]">Instal Ulang / Cuci Windows</span></h2>
                <p class="mt-4 text-gray-500">Kelola paket promo langsung dari admin panel. Setiap paket yang aktif akan tampil di halaman home dalam format card sederhana dan elegan.</p>
            </div>
            <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC%2C%20saya%20ingin%20mengetahui%20detail%20paket%20instal%20ulang%20Windows" target="_blank" class="btn-primary inline-flex items-center gap-3 px-6 py-4 rounded-2xl text-white font-bold text-sm uppercase tracking-[0.15em]">
                <i class="fab fa-whatsapp"></i> Hubungi WhatsApp
            </a>
        </div>

        @if($activePromos->count() > 0)
        <div class="grid gap-8 xl:grid-cols-3">
            @foreach($activePromos as $promo)
            <div class="group bg-white border border-gray-200 rounded-[2rem] overflow-hidden shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                @if($promo->image)
                <div class="h-56 overflow-hidden">
                    <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="w-full h-full object-cover" />
                </div>
                @endif
                <div class="px-8 py-10">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between 2gap-3 mb-5">
                        <span class="text-xs font-black uppercase tracking-[0.3em] text-[#C8000A]">Paket</span>
                        @if($promo->discount_info)
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF1F1] px-4 py-2 text-xs font-bold text-[#C8000A] uppercase">{{ $promo->discount_info }}</span>
                        @endif
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">{{ $promo->title }}</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ \Illuminate\Support\Str::limit($promo->description, 160) }}</p>
                    <div class="space-y-3 text-sm text-gray-500">
                        @if($promo->start_date && $promo->end_date)
                        <div class="flex items-center gap-3">
                            <span class="text-[#C8000A]"><i class="fas fa-calendar-alt"></i></span>
                            <span>{{ $promo->start_date->format('d M Y') }} - {{ $promo->end_date->format('d M Y') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <span class="text-[#C8000A]"><i class="fas fa-check-circle"></i></span>
                            <span class="font-semibold">Paket aktif dan dapat diubah dari admin</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 md:py-20 lg:py-24 bg-white border border-dashed border-gray-200 rounded-3xl max-w-2xl mx-auto">
            <i class="fas fa-box-open text-5xl md:text-6xl lg:text-7xl text-gray-300 mb-6 md:mb-8"></i>
            <p class="text-xl md:text-2xl lg:text-3xl font-black text-gray-500 mb-3 md:mb-4">Belum ada paket aktif</p>
            <span class="text-base md:text-lg text-gray-400 block mb-6 md:mb-8 lg:mb-12">Tambahkan atau aktifkan paket melalui admin panel agar tampil di halaman home.</span>
            <a href="{{ route('admin.promos.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 text-gray-700 font-bold text-sm uppercase tracking-wider hover:border-[#C8000A] hover:text-[#C8000A] transition-all">
                <i class="fas fa-cog"></i> Kelola Paket Admin
            </a>
        </div>
        @endif
    </div>
</section>

<!-- ===================== FEATURED SERVICES ===================== -->
@if($featuredServices->count() > 0)
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-end justify-between mb-14">
            <div>
                <div class="inline-flex items-center gap-2.5 mb-4">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Layanan Unggulan</span>
                </div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">Layanan <span class="text-[#C8000A]">Terpopuler</span></h2>
            </div>
            <a href="{{ route('services.index') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#C8000A] uppercase tracking-wider transition-colors">
                Semua Layanan <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredServices as $service)
            <div class="group bg-white border border-gray-100 p-8 transition-all duration-300 hover:border-[#C8000A]/20 hover:shadow-xl hover:shadow-red-900/5 hover:-translate-y-1 relative overflow-hidden">
                <!-- Number watermark -->
                <div class="absolute -right-4 -bottom-6 text-8xl font-black text-gray-50 select-none">{{ $loop->iteration }}</div>
                
                <!-- Category icon -->
                <div class="w-12 h-12 bg-red-50 flex items-center justify-center mb-6 group-hover:bg-[#C8000A] transition-colors duration-300">
                    @php
                    $icons = ['laptop' => 'fa-laptop', 'printer' => 'fa-print', 'pc' => 'fa-desktop', 'software' => 'fa-compact-disc'];
                    $icon = $icons[$service->category] ?? 'fa-wrench';
                    @endphp
                    <i class="fas {{ $icon }} text-[#C8000A] group-hover:text-white transition-colors duration-300"></i>
                </div>

                <!-- Badge -->
                <div class="inline-block px-2 py-1 bg-gray-50 text-gray-400 text-[10px] font-black uppercase tracking-[0.15em] mb-3">
                    {{ $service->category_label }}
                </div>

                <h3 class="text-xl font-black text-gray-900 mb-3 leading-tight">{{ $service->name }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">{{ $service->short_description ?? Str::limit($service->description, 100) }}</p>
                
                <div class="flex items-end justify-between pt-5 border-t border-gray-50">
                    <div>
                        <div class="text-[#C8000A] font-black text-lg">{{ $service->price_range }}</div>
                        <div class="text-gray-400 text-xs mt-0.5">Est. {{ $service->estimated_days }} hari kerja</div>
                    </div>
                    <a href="{{ route('services.show', $service->slug) }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#C8000A] text-white text-xs font-black uppercase tracking-wider hover:bg-[#A00008] transition-colors">
                        Detail
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-3 px-10 py-4 border border-gray-200 text-gray-600 font-bold text-sm uppercase tracking-widest hover:border-[#C8000A] hover:text-[#C8000A] transition-all duration-200">
                Lihat Semua Layanan
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ===================== WHY US ===================== -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16 items-center">
            <!-- Left copy -->
            <div class="lg:col-span-2">
                <div class="inline-flex items-center gap-2.5 mb-5">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Keunggulan Kami</span>
                </div>
                <h2 class="text-4xl font-black text-gray-900 leading-tight mb-6 tracking-tight">
                    Mengapa Pilih<br><span class="text-[#C8000A]">Alsha Media<br>Center?</span>
                </h2>
                <p class="text-gray-400 text-base leading-relaxed mb-8">
                    Kami berkomitmen memberikan layanan service elektronik terbaik dengan standar kualitas tinggi dan kepuasan pelanggan sebagai prioritas utama.
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-sm font-black text-[#C8000A] uppercase tracking-wider hover:gap-4 transition-all">
                    Hubungi Kami <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Right grid -->
            <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach([
                    ['icon' => 'fa-trophy', 'title' => 'Teknisi Bersertifikat', 'desc' => 'Tim teknisi kami berpengalaman dan bersertifikat resmi dengan keahlian terverifikasi.'],
                    ['icon' => 'fa-bolt', 'title' => 'Pengerjaan Cepat', 'desc' => 'Kebanyakan perbaikan selesai dalam 1–3 hari kerja tanpa mengorbankan kualitas.'],
                    ['icon' => 'fa-shield-alt', 'title' => 'Garansi 30 Hari', 'desc' => 'Setiap perbaikan bergaransi penuh selama 30 hari untuk ketenangan pikiran Anda.'],
                    ['icon' => 'fa-gem', 'title' => 'Spare Part Original', 'desc' => 'Menggunakan komponen original berkualitas tinggi untuk hasil perbaikan terbaik.'],
                ] as $item)
                <div class="group p-7 border border-gray-100 hover:border-[#C8000A]/20 hover:shadow-lg hover:shadow-red-900/5 transition-all duration-300">
                    <div class="w-10 h-10 bg-[#C8000A] flex items-center justify-center mb-5">
                        <i class="fas {{ $item['icon'] }} text-white text-sm"></i>
                    </div>
                    <h3 class="font-black text-gray-900 text-base mb-2">{{ $item['title'] }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ===================== HOW IT WORKS ===================== -->
<section class="py-24 bg-[#C8000A] relative overflow-hidden">
    <!-- Background texture -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2.5 mb-5">
                <span class="block w-6 h-px bg-white/40"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-white/60">Proses Kami</span>
                <span class="block w-6 h-px bg-white/40"></span>
            </div>
            <h2 class="text-4xl font-black text-white tracking-tight">4 Langkah Mudah Service di <span class="underline decoration-white/30">AMC</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Connector line (desktop) -->
            <div class="hidden md:block absolute top-12 left-[12.5%] right-[12.5%] h-px bg-white/20 z-0"></div>

            @foreach([
                ['step' => '01', 'icon' => 'fa-phone-volume', 'title' => 'Hubungi Kami', 'desc' => 'Sampaikan masalah perangkat Anda via WhatsApp, telepon, atau kunjungi kami langsung.'],
                ['step' => '02', 'icon' => 'fa-clipboard-list', 'title' => 'Cek & Estimasi', 'desc' => 'Teknisi mengecek perangkat dan memberikan estimasi biaya transparan tanpa biaya tersembunyi.'],
                ['step' => '03', 'icon' => 'fa-wrench', 'title' => 'Proses Service', 'desc' => 'Perbaikan cepat menggunakan spare part original oleh teknisi berpengalaman dan bersertifikat.'],
                ['step' => '04', 'icon' => 'fa-check-circle', 'title' => 'Selesai & Garansi', 'desc' => 'Perangkat siap digunakan kembali dengan garansi 30 hari untuk setiap layanan kami.'],
            ] as $step)
            <div class="relative z-10 text-center group">
                <!-- Step circle -->
                <div class="w-24 h-24 mx-auto bg-white flex items-center justify-center mb-6 group-hover:bg-gray-50 transition-colors shadow-2xl shadow-black/20">
                    <i class="fas {{ $step['icon'] }} text-[#C8000A] text-2xl"></i>
                </div>
                <div class="inline-block px-3 py-1 bg-white/10 text-white/80 text-xs font-black uppercase tracking-[0.2em] mb-4">{{ $step['step'] }}</div>
                <h3 class="font-black text-white text-lg mb-3">{{ $step['title'] }}</h3>
                <p class="text-white/60 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== TESTIMONIALS ===================== -->
@if($testimonials->count() > 0)
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-end justify-between mb-14">
            <div>
                <div class="inline-flex items-center gap-2.5 mb-4">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Testimoni Pelanggan</span>
                </div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">Kata <span class="text-[#C8000A]">Pelanggan</span> Kami</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
            <div class="group p-8 border border-gray-100 hover:border-[#C8000A]/20 transition-all duration-300 hover:shadow-xl hover:shadow-red-900/5 relative">
                <!-- Quote mark -->
                <div class="absolute top-6 right-8 text-5xl font-black text-gray-50 select-none leading-none">"</div>
                
                <!-- Stars -->
                <div class="flex items-center gap-1 mb-6">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-xs {{ $i <= $t->rating ? 'text-[#C8000A]' : 'text-gray-200' }}"></i>
                    @endfor
                </div>

                <p class="text-gray-600 text-sm leading-relaxed mb-8 relative z-10">"{{ $t->comment }}"</p>
                
                <div class="flex items-center gap-4 pt-5 border-t border-gray-50">
                    <div class="w-10 h-10 bg-[#C8000A] flex items-center justify-center text-white font-black text-sm flex-shrink-0">
                        {{ strtoupper(substr($t->customer_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-bold text-sm">{{ $t->customer_name }}</p>
                        <p class="text-gray-400 text-xs">
                            @php
                            $serviceLabels = ['laptop' => 'Service Laptop', 'printer' => 'Service Printer', 'pc' => 'Service PC'];
                            @endphp
                            {{ $serviceLabels[$t->service_type] ?? 'Service Elektronik' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===================== MAP / LOCATION ===================== -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2.5 mb-4">
                <span class="block w-6 h-px bg-[#C8000A]"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Lokasi Toko</span>
                <span class="block w-6 h-px bg-[#C8000A]"></span>
            </div>
            <h2 class="text-4xl font-black text-gray-900 mb-3 tracking-tight">Temukan <span class="text-[#C8000A]">Kami di Sini</span></h2>
            <p class="text-gray-400">{{ $store->address ?? 'Jl. Raya Bangsri No 02. Kecamatan Bangsri' }}, {{ $store->city ?? 'Bangsri, Jawa Tengah' }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Map -->
            <div class="lg:col-span-2 overflow-hidden border border-gray-200">
                @if($store && $store->google_maps_link)
                <iframe src="{{ $store->google_maps_link }}" width="100%" style="border:0; min-height: 420px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @else
                <div id="map" style="min-height: 420px;"></div>
                @endif
            </div>

            <!-- Store Info -->
            <div class="space-y-3">
                @if($store)
                @foreach([
                    ['icon' => 'fa-map-marker-alt', 'label' => 'Alamat', 'content' => $store->address . ', ' . $store->city],
                    ['icon' => 'fa-clock', 'label' => 'Jam Operasional', 'content' => $store->open_days . ' · ' . $store->open_hours],
                    ['icon' => 'fa-phone-alt', 'label' => 'Telepon', 'content' => $store->phone, 'href' => 'tel:' . $store->phone],
                    ['icon' => 'fa-envelope', 'label' => 'Email', 'content' => $store->email, 'href' => 'mailto:' . $store->email],
                ] as $info)
                <div class="bg-white p-5 border border-gray-100 flex items-start gap-4">
                    <div class="w-9 h-9 bg-red-50 flex items-center justify-center flex-shrink-0">
                        <i class="fas {{ $info['icon'] }} text-[#C8000A] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.12em] mb-1">{{ $info['label'] }}</p>
                        @if(isset($info['href']))
                        <a href="{{ $info['href'] }}" class="text-gray-800 text-sm font-medium hover:text-[#C8000A] transition-colors">{{ $info['content'] }}</a>
                        @else
                        <p class="text-gray-800 text-sm font-medium">{{ $info['content'] }}</p>
                        @endif
                    </div>
                </div>
                @endforeach

                @if($store->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}?text=Halo%20AMC!" 
                   target="_blank"
                   class="flex items-center gap-4 bg-[#C8000A] p-5 text-white group hover:bg-[#A00008] transition-colors">
                    <i class="fab fa-whatsapp text-2xl flex-shrink-0"></i>
                    <div>
                        <p class="font-black text-sm">Chat via WhatsApp</p>
                        <p class="text-white/70 text-xs">Respon cepat, balas dalam menit</p>
                    </div>
                    <i class="fas fa-arrow-right text-sm ml-auto group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ===================== CTA ===================== -->
<section class="py-28 bg-gray-900 relative overflow-hidden">
    <!-- Background accent -->
    <div class="absolute inset-y-0 left-0 w-2 bg-[#C8000A]"></div>
    <div class="absolute top-0 right-0 w-64 h-64 bg-[#C8000A]/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>

    <div class="relative max-w-4xl mx-auto px-6 sm:px-8 text-center">
        <div class="inline-flex items-center gap-2.5 mb-6">
            <span class="block w-6 h-px bg-[#C8000A]"></span>
            <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Mulai Sekarang</span>
            <span class="block w-6 h-px bg-[#C8000A]"></span>
        </div>
        <h2 class="text-5xl sm:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            Siap Perbaiki<br>Perangkat Anda?
        </h2>
        <p class="text-gray-400 text-lg mb-12 max-w-xl mx-auto">
            Jangan biarkan perangkat rusak menghambat produktivitas Anda. Hubungi kami sekarang untuk konsultasi gratis.
        </p>
        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC,%20saya%20ingin%20konsultasi..." 
           target="_blank" 
           class="group inline-flex items-center gap-3 px-12 py-5 bg-[#C8000A] text-white font-black text-sm uppercase tracking-widest hover:bg-white hover:text-[#C8000A] transition-all duration-300 shadow-2xl shadow-red-900/30">
            <i class="fab fa-whatsapp text-xl"></i>
            Kontak Kami Sekarang
            <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</section>

@endsection

@push('scripts')
<style>
/* Hero diagonal clip */
.clip-diagonal {
    clip-path: polygon(8% 0%, 100% 0%, 100% 100%, 0% 100%);
}

/* Marquee animation */
@keyframes amc-marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.amc-marquee-track {
    animation: amc-marquee 28s linear infinite;
}
.amc-marquee-track:hover {
    animation-play-state: paused;
}

/* Stat counter animation */
.stat-number {
    transition: all 0.3s ease;
}
</style>

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
        html: `<div style="background:#C8000A;width:40px;height:40px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(200,0,10,0.4);"><span style="color:white;font-size:18px;"><i class="fas fa-wrench"></i></span></div>`, 
        className: '', 
        iconSize: [40,40], 
        iconAnchor: [20,40] 
    });
    L.marker([storeData.lat, storeData.lng], { icon })
        .addTo(map)
        .bindPopup(`<div style="font-family:sans-serif;padding:6px;min-width:180px;"><strong style="color:#C8000A;">Alsha Media Center</strong><br><span style="color:#888;font-size:12px;">${storeData.address}, ${storeData.city}</span></div>`, { maxWidth: 250 })
        .openPopup();
</script>
@endif

<script>
// Counter animation
function animateCounters() {
    document.querySelectorAll('.stat-number[data-counter]').forEach(el => {
        const target = parseInt(el.dataset.counter);
        const duration = 1500;
        const step = target / (duration / 16);
        let current = 0;
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = Math.round(current).toLocaleString();
            if (current >= target) clearInterval(timer);
        }, 16);
    });
}

// Intersection observer for counters
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            animateCounters();
            observer.disconnect();
        }
    });
});
const firstStat = document.querySelector('.stat-number');
if (firstStat) observer.observe(firstStat);
</script>
@endpush