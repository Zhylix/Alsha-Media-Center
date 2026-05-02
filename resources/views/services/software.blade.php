@extends('layouts.app')
@section('title', 'Jasa Installasi Software')

@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 left-1/4 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center gap-2 text-gray-500 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-900">Beranda</a> / <a href="{{ route('services.index') }}" class="hover:text-gray-900">Layanan</a> / <span class="text-red-600">Software</span>
        </div>
        <div class="flex items-center gap-4 mb-4"><span class="text-6xl animate-float"><i class="fas fa-compact-disc text-red-600"></i></span><span class="badge badge-gray text-base px-4 py-2">Installasi Software</span></div>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">Jasa Installasi <span class="text-gradient">Software</span> Lengkap</h1>
        <p class="text-gray-600 text-lg max-w-2xl">Layanan installasi Windows, Office, software desain, aplikasi perkantoran, dan optimasi sistem untuk PC & Laptop Anda.</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <!-- Modern Service Card - SaaS Dashboard Style -->
            <div class="group relative bg-white rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-0.5 border border-gray-300">
                
                <!-- Hover Accent - Red Square -->
                <div class="absolute -right-1 -top-1 w-3 h-3 bg-[#C8000A] opacity-0 group-hover:opacity-100 transition-opacity rounded-xl scale-0 group-hover:scale-100"></div>
                
                <!-- TOP SECTION: Icon + Title + Desc -->
                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon with red gradient -->
                    <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                        <i class="fas fa-compact-disc text-white"></i>
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
                        
                        <p class="text-gray-500 text-sm leading-relaxed mt-1 line-clamp-2">
                            {{ $service->short_description ?? Str::limit($service->description, 100) }}
                        </p>
                    </div>
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
        @else
        <div class="text-center py-20 glass rounded-3xl" data-animate>
            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-3xl mb-6">
                <i class="fas fa-box-open"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Layanan belum tersedia</h3>
            <p class="text-gray-500">Kami sedang menyiapkan daftar layanan software terbaik untuk Anda.</p>
        </div>
        @endif
    </div>
</section>

<!-- Why Install at AMC? -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-animate>
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-gray-900">Keunggulan Install Software di <span class="text-gradient">AMC</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 mx-auto bg-red-600/10 rounded-2xl flex items-center justify-center text-red-600 text-2xl mb-4">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Aman & Terpercaya</h4>
                <p class="text-gray-600 text-sm">Software bebas dari malware dan dipastikan berjalan stabil pada perangkat Anda.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 mx-auto bg-red-600/10 rounded-2xl flex items-center justify-center text-red-600 text-2xl mb-4">
                    <i class="fas fa-bolt"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Proses Cepat</h4>
                <p class="text-gray-600 text-sm">Installasi dilakukan oleh teknisi profesional sehingga lebih cepat selesai.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 mx-auto bg-red-600/10 rounded-2xl flex items-center justify-center text-red-600 text-2xl mb-4">
                    <i class="fas fa-headset"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Dukungan Teknis</h4>
                <p class="text-gray-600 text-sm">Konsultasi gratis mengenai software yang paling cocok untuk spesifikasi perangkat Anda.</p>
            </div>
        </div>
    </div>
</section>
@endsection
