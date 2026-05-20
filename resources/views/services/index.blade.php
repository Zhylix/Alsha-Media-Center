@extends('layouts.app')
@section('title', 'Semua Layanan | Alsha Media Center')

@section('content')

<!-- ===================== HERO ===================== -->
<section class="relative py-36 bg-white overflow-hidden">
    <div class="absolute top-0 right-0 w-[45%] h-full bg-gray-50 hidden lg:block" style="clip-path: polygon(15% 0%, 100% 0%, 100% 100%, 0% 100%)"></div>
    <div class="absolute bottom-0 left-0 w-48 h-1 bg-[#C8000A]"></div>
    
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2.5 mb-6">
                <span class="block w-6 h-px bg-[#C8000A]"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Layanan Kami</span>
            </div>
            <h1 class="text-5xl sm:text-6xl font-black text-gray-900 tracking-tight leading-tight mb-5">
                Semua <span class="text-[#C8000A]">Jasa Service</span>
            </h1>
            <p class="text-gray-400 text-lg leading-relaxed mb-10">Pilih layanan yang Anda butuhkan. Semua dikerjakan oleh teknisi berpengalaman dengan garansi resmi.</p>

            <!-- Quick Nav -->
            <div class="flex flex-wrap gap-3">
                <a href="#laptop" class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-200 text-gray-600 text-xs font-black uppercase tracking-wider hover:border-[#C8000A] hover:text-[#C8000A] transition-all rounded-sm">
                    <i class="fas fa-laptop text-xs"></i> Laptop
                </a>
                <a href="#pc" class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-200 text-gray-600 text-xs font-black uppercase tracking-wider hover:border-[#C8000A] hover:text-[#C8000A] transition-all rounded-sm">
                    <i class="fas fa-desktop text-xs"></i> PC / Komputer
                </a>
                <a href="#printer" class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-200 text-gray-600 text-xs font-black uppercase tracking-wider hover:border-[#C8000A] hover:text-[#C8000A] transition-all rounded-sm">
                    <i class="fas fa-print text-xs"></i> Printer
                </a>
                <a href="#software" class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-200 text-gray-600 text-xs font-black uppercase tracking-wider hover:border-[#C8000A] hover:text-[#C8000A] transition-all rounded-sm">
                    <i class="fas fa-compact-disc text-xs"></i> Software
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===================== LAPTOP SERVICES ===================== -->
@if($laptopServices->count() > 0)
<section class="py-24 bg-white" id="laptop">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <!-- Section title -->
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-[#C8000A] flex items-center justify-center flex-shrink-0 rounded-sm">
                    <i class="fas fa-laptop text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-0.5">Kategori</div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Service <span class="text-[#C8000A]">Laptop</span></h2>
                </div>
            </div>
            <a href="{{ route('services.laptop') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-black text-gray-400 uppercase tracking-wider hover:text-[#C8000A] transition-colors">
                Semua <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($laptopServices as $service)
            <!-- Modern Service Card - SaaS Dashboard Style -->
            <div class="group relative bg-white rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-0.5 border border-gray-300">
                
                <!-- Hover Accent - Red Square -->
                <div class="absolute -right-1 -top-1 w-3 h-3 bg-[#C8000A] opacity-0 group-hover:opacity-100 transition-opacity rounded-xl scale-0 group-hover:scale-100"></div>
                
                <!-- TOP SECTION: Icon + Title + Desc -->
                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon with red gradient -->
                    <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                        <i class="fas fa-laptop text-white text-xl"></i>
                    </div>
                    
                    <!-- Title & Description -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-gray-900 text-base leading-tight">
                                {{ $service->name }}
                            </h3>
                            
                            @if($service->is_featured)
                            <span class="flex-shrink-0 px-2.5 py-1 bg-red-100 text-[#C8000A] text-[10px] font-bold uppercase tracking-wide rounded-full">
                                Populer
                            </span>
                            @endif
                        </div>
                        
                    </div>
                </div>
                <div>
                    <p class="text-gray-500 text-sm leading-relaxed mt-1 line-clamp-2">
                        {{ $service->short_description ?? Str::limit($service->description, 100) }}
                    </p>
                </div>
                
                <!-- Divider -->
                <div class="h-px bg-gray-200 mb-4 mt-2"></div>
                
                <!-- BOTTOM SECTION: Price + Time -->
                <div class="flex items-center gap-3 mb-3">
                    <!-- Price Box (Larger) -->
                    <div class="bg-gray-50 rounded-xl px-4 py-2.5 shadow-sm flex-[2]">
                        <div class="flex items-center gap-2 text-gray-400 text-[10px] uppercase font-semibold">
                            <i class="fas fa-tag text-[8px] text-[#C8000A]"></i>
                            Harga
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->price_range }}
                        </div>
                    </div>
                    
                    <!-- Time Box (Smaller) -->
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 shadow-sm flex-1">
                        <div class="flex items-center gap-1.5 text-gray-400 text-[9px] uppercase font-semibold">
                            <i class="fas fa-clock text-[7px] text-[#C8000A]"></i>
                            Estimasi
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->estimated_days }} hari
                        </div>
                    </div>
                </div>
                
                <!-- Detail Button -->
                <a href="{{ route('services.show', $service->slug) }}" 
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 w-full
                bg-[#C8000A] text-white text-xs font-bold uppercase tracking-wide rounded-xl
                hover:bg-[#A00008] transition-all shadow-md hover:shadow-lg">
                    Detail 
                    <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Divider -->
@if($laptopServices->count() > 0 && ($printerServices->count() > 0 || $pcServices->count() > 0))
<div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
    <div class="h-px bg-gray-100"></div>
</div>
@endif

<!-- ===================== PC SERVICES ===================== -->
@if($pcServices->count() > 0)
<section class="py-24 bg-white" id="pc">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-[#C8000A] flex items-center justify-center flex-shrink-0 rounded-sm">
                    <i class="fas fa-desktop text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-0.5">Kategori</div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Service <span class="text-[#C8000A]">Komputer</span></h2>
                </div>
            </div>
            <a href="{{ route('services.pc') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-black text-gray-400 uppercase tracking-wider hover:text-[#C8000A] transition-colors">
                Semua <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pcServices as $service)
            <!-- Modern Service Card - SaaS Dashboard Style -->
            <div class="group relative bg-white rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-0.5 border border-gray-300">
                
                <!-- Hover Accent - Red Square -->
                <div class="absolute -right-1 -top-1 w-3 h-3 bg-[#C8000A] opacity-0 group-hover:opacity-100 transition-opacity rounded-xl scale-0 group-hover:scale-100"></div>
                
                <!-- TOP SECTION: Icon + Title + Desc -->
                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon with red gradient -->
                    <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                        <i class="fas fa-desktop text-white text-xl"></i>
                    </div>
                    
                    <!-- Title & Description -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-gray-900 text-base leading-tight">
                                {{ $service->name }}
                            </h3>
                            
                            @if($service->is_featured)
                            <span class="flex-shrink-0 px-2.5 py-1 bg-red-100 text-[#C8000A] text-[10px] font-bold uppercase tracking-wide rounded-full">
                                Populer
                            </span>
                            @endif
                        </div>  
                    </div>
                </div>
                <div>
                    <p class="text-gray-500 text-sm leading-relaxed mt-1 line-clamp-2">
                        {{ $service->short_description ?? Str::limit($service->description, 100) }}
                    </p>
                </div>
                
                <!-- Divider -->
                <div class="h-px bg-gray-200 mb-4"></div>
                
                <!-- BOTTOM SECTION: Price + Time -->
                <div class="flex items-center gap-3 mb-3">
                    <!-- Price Box (Larger) -->
                    <div class="bg-gray-50 rounded-xl px-4 py-2.5 shadow-sm flex-[2]">
                        <div class="flex items-center gap-2 text-gray-400 text-[10px] uppercase font-semibold">
                            <i class="fas fa-tag text-[8px] text-[#C8000A]"></i>
                            Harga
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->price_range }}
                        </div>
                    </div>
                    
                    <!-- Time Box (Smaller) -->
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 shadow-sm flex-1">
                        <div class="flex items-center gap-1.5 text-gray-400 text-[9px] uppercase font-semibold">
                            <i class="fas fa-clock text-[7px] text-[#C8000A]"></i>
                            Estimasi
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->estimated_days }} hari
                        </div>
                    </div>
                </div>
                
                <!-- Detail Button -->
                <a href="{{ route('services.show', $service->slug) }}" 
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 w-full
                bg-[#C8000A] text-white text-xs font-bold uppercase tracking-wide rounded-xl
                hover:bg-[#A00008] transition-all shadow-md hover:shadow-lg">
                    Detail 
                    <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Divider - Between PC and Software -->
@if($pcServices->count() > 0 && $softwareServices->count() > 0)
<div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
    <div class="h-px bg-gray-100"></div>
</div>
@endif

<!-- ===================== PRINTER SERVICES ===================== -->
@if($printerServices->count() > 0)
<section class="py-24 bg-white" id="printer">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-[#C8000A] flex items-center justify-center flex-shrink-0 rounded-sm">
                    <i class="fas fa-print text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-0.5">Kategori</div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Service <span class="text-[#C8000A]">Printer</span></h2>
                </div>
            </div>
            <a href="{{ route('services.printer') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-black text-gray-400 uppercase tracking-wider hover:text-[#C8000A] transition-colors">
                Semua <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($printerServices as $service)
            <!-- Modern Service Card - SaaS Dashboard Style -->
            <div class="group relative bg-white rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-0.5 border border-gray-300">
                
                <!-- Hover Accent - Red Square -->
                <div class="absolute -right-1 -top-1 w-3 h-3 bg-[#C8000A] opacity-0 group-hover:opacity-100 transition-opacity rounded-xl scale-0 group-hover:scale-100"></div>
                
                <!-- TOP SECTION: Icon + Title + Desc -->
                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon with red gradient -->
                    <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                        <i class="fas fa-print text-white text-xl"></i>
                    </div>
                    
                    <!-- Title & Description -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-gray-900 text-base leading-tight">
                                {{ $service->name }}
                            </h3>
                            
                            @if($service->is_featured)
                            <span class="flex-shrink-0 px-2.5 py-1 bg-red-100 text-[#C8000A] text-[10px] font-bold uppercase tracking-wide rounded-full">
                                Populer
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-gray-500 text-sm leading-relaxed mt-1 line-clamp-2">
                        {{ $service->short_description ?? Str::limit($service->description, 100) }}
                    </p>
                </div>
                
                <!-- Divider -->
                <div class="h-px bg-gray-200 mb-4"></div>
                
                <!-- BOTTOM SECTION: Price + Time -->
                <div class="flex items-center gap-3 mb-3">
                    <!-- Price Box (Larger) -->
                    <div class="bg-gray-50 rounded-xl px-4 py-2.5 shadow-sm flex-[2]">
                        <div class="flex items-center gap-2 text-gray-400 text-[10px] uppercase font-semibold">
                            <i class="fas fa-tag text-[8px] text-[#C8000A]"></i>
                            Harga
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->price_range }}
                        </div>
                    </div>
                    
                    <!-- Time Box (Smaller) -->
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 shadow-sm flex-1">
                        <div class="flex items-center gap-1.5 text-gray-400 text-[9px] uppercase font-semibold">
                            <i class="fas fa-clock text-[7px] text-[#C8000A]"></i>
                            Estimasi
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->estimated_days }} hari
                        </div>
                    </div>
                </div>
                
                <!-- Detail Button -->
                <a href="{{ route('services.show', $service->slug) }}" 
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 w-full
                bg-[#C8000A] text-white text-xs font-bold uppercase tracking-wide rounded-xl
                hover:bg-[#A00008] transition-all shadow-md hover:shadow-lg">
                    Detail 
                    <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Divider -->
@if(($laptopServices->count() > 0 || $printerServices->count() > 0) && $pcServices->count() > 0)
<div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
    <div class="h-px bg-gray-100"></div>
</div>
@endif

<!-- ===================== SOFTWARE SERVICES ===================== -->
@if($softwareServices->count() > 0)
<section class="py-24 bg-white" id="software">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-[#C8000A] flex items-center justify-center flex-shrink-0 rounded-sm">
                    <i class="fas fa-compact-disc text-white"></i>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-0.5">Kategori</div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Installasi <span class="text-[#C8000A]">Software</span></h2>
                </div>
            </div>
            <a href="{{ route('services.software') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-black text-gray-400 uppercase tracking-wider hover:text-[#C8000A] transition-colors">
                Semua <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($softwareServices as $service)
            <!-- Modern Service Card - SaaS Dashboard Style -->
            <div class="group relative bg-white rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-0.5 border border-gray-300">
                
                <!-- Hover Accent - Red Square -->
                <div class="absolute -right-1 -top-1 w-3 h-3 bg-[#C8000A] opacity-0 group-hover:opacity-100 transition-opacity rounded-xl scale-0 group-hover:scale-100"></div>
                
                <!-- TOP SECTION: Icon + Title + Desc -->
                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon with red gradient -->
                    <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                        <i class="fas fa-compact-disc text-white text-xl"></i>
                    </div>
                    
                    <!-- Title & Description -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-gray-900 text-base leading-tight">
                                {{ $service->name }}
                            </h3>
                            
                            @if($service->is_featured)
                            <span class="flex-shrink-0 px-2.5 py-1 bg-red-100 text-[#C8000A] text-[10px] font-bold uppercase tracking-wide rounded-full">
                                Populer
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div>
                    <p class="text-gray-500 text-sm leading-relaxed mt-1 line-clamp-2">
                        {{ $service->short_description ?? Str::limit($service->description, 100) }}
                    </p>
                </div>

                <!-- Divider -->
                <div class="h-px bg-gray-200 mb-4"></div>
                
                <!-- BOTTOM SECTION: Price + Time -->
                <div class="flex items-center gap-3 mb-3">
                    <!-- Price Box (Larger) -->
                    <div class="bg-gray-50 rounded-xl px-4 py-2.5 shadow-sm flex-[2]">
                        <div class="flex items-center gap-2 text-gray-400 text-[10px] uppercase font-semibold">
                            <i class="fas fa-tag text-[8px] text-[#C8000A]"></i>
                            Harga
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->price_range }}
                        </div>
                    </div>
                    
                    <!-- Time Box (Smaller) -->
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 shadow-sm flex-1">
                        <div class="flex items-center gap-1.5 text-gray-400 text-[9px] uppercase font-semibold">
                            <i class="fas fa-clock text-[7px] text-[#C8000A]"></i>
                            Estimasi
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">
                            {{ $service->estimated_days }} hari
                        </div>
                    </div>
                </div>
                
                <!-- Detail Button -->
                <a href="{{ route('services.show', $service->slug) }}" 
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 w-full
                bg-[#C8000A] text-white text-xs font-bold uppercase tracking-wide rounded-xl
                hover:bg-[#A00008] transition-all shadow-md hover:shadow-lg">
                    Detail 
                    <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Divider -->
@if(($laptopServices->count() > 0 || $printerServices->count() > 0) && $pcServices->count() > 0)
<div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
    <div class="h-px bg-gray-100"></div>
</div>
@endif

<!-- ===================== CTA STRIP ===================== -->
<section class="py-16 bg-[#C8000A] relative overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>
    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-black text-white">Tidak menemukan yang Anda cari?</h3>
            <p class="text-white/70 text-sm mt-1">Hubungi kami langsung, kami siap membantu!</p>
        </div>
        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC!" 
           target="_blank"
           class="flex-shrink-0 inline-flex items-center gap-3 px-8 py-4 bg-white text-[#C8000A] font-black text-sm uppercase tracking-wider hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-black/40 rounded-sm">
            <i class="fab fa-whatsapp text-lg"></i>
            Konsultasi Gratis
        </a>
    </div>
</section>

@endsection
