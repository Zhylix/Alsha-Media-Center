@extends('layouts.app')
@section('title', $service->name)
@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center gap-2 text-gray-500 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-900">Beranda</a> /
            <a href="{{ route('services.index') }}" class="hover:text-gray-900">Layanan</a> /
            <a href="{{ route('services.'.$service->category) }}" class="hover:text-gray-900">{{ $service->category_label }}</a> /
            <span class="text-red-600">{{ $service->name }}</span>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
        <span class="badge badge-{{ $service->category === 'laptop' ? 'blue' : ($service->category === 'printer' ? 'purple' : 'green') }} mb-4 inline-block">{{ $service->category_label }}</span>
                <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $service->name }}</h1>
                <p class="text-gray-600 text-lg mb-6">{{ $service->short_description }}</p>
                <div class="flex flex-wrap gap-4">
                    <a href="https://wa.me/{{ preg_replace('/\D/','',optional($store)->whatsapp ?? '6281234567890') }}?text=Halo, saya ingin tanya tentang {{ $service->name }}" target="_blank" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fab fa-whatsapp"></i> Tanya via WhatsApp</a>
                </div>
            </div>
            <div class="service-card p-8 rounded-2xl">
                <div class="text-6xl text-center mb-4">{!! $service->category === 'laptop' ? '<i class="fas fa-laptop text-red-600"></i>' : ($service->category === 'printer' ? '<i class="fas fa-print text-red-600"></i>' : '<i class="fas fa-desktop text-red-600"></i>') !!}</div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-red-600/10">
                        <span class="text-gray-600 text-sm">Harga</span>
                        <span class="text-red-600 font-bold">{{ $service->price_range }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-red-600/10">
                        <span class="text-gray-600 text-sm">Estimasi Waktu</span>
                        <span class="text-gray-900 font-semibold">{{ $service->estimated_days }} hari kerja</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <span class="text-gray-600 text-sm">Garansi</span>
                        <span class="text-red-600 font-semibold">30 Hari</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="service-card p-8 rounded-2xl mb-8" data-animate>
            <h2 class="text-2xl font-black text-gray-900 mb-4">Deskripsi Layanan</h2>
            <p class="text-gray-600 leading-relaxed">{{ $service->description }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10" data-animate>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-check text-red-600"></i></div>
                <p class="text-gray-900 font-semibold text-sm">Garansi 30 Hari</p>
            </div>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-cogs text-gray-600"></i></div>
                <p class="text-gray-900 font-semibold text-sm">Spare Part Original</p>
            </div>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-bolt text-red-600"></i></div>
                <p class="text-gray-900 font-semibold text-sm">Teknisi Berpengalaman</p>
            </div>
        </div>
    </div>
</section>

@if($related->count() > 0)
<section class="py-24 bg-white" id="related">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-5">
                <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                    @php
                    $icons = ['laptop' => 'fa-laptop', 'printer' => 'fa-print', 'pc' => 'fa-desktop', 'software' => 'fa-compact-disc'];
                    $icon = $icons[$service->category] ?? 'fa-wrench';
                    @endphp
                    <i class="fas {{ $icon }} text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-0.5">Kategori</div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Installasi <span class="text-[#C8000A]">Terkait</span></h2>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center gap-2 text-xs font-black text-gray-400 uppercase tracking-wider">Layanan Terkait</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($related as $service)
            <!-- Modern Service Card - SaaS Dashboard Style -->
            <div class="group relative bg-white rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-0.5 border border-gray-300">
                <!-- Hover Accent - Red Square -->
                <div class="absolute -right-1 -top-1 w-3 h-3 bg-[#C8000A] opacity-0 group-hover:opacity-100 transition-opacity rounded-xl scale-0 group-hover:scale-100"></div>

                <!-- TOP SECTION: Icon + Title + Desc -->
                <div class="flex items-start gap-4 mb-4">
                    <!-- Icon with red gradient -->
                    <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                        @php
                        $icons = ['laptop' => 'fa-laptop', 'printer' => 'fa-print', 'pc' => 'fa-desktop', 'software' => 'fa-compact-disc'];
                        $icon = $icons[$service->category] ?? 'fa-wrench';
                        @endphp
                        <i class="fas {{ $icon }} text-white text-xl"></i>
                    </div>

                    <!-- Title & Description -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-gray-900 text-base leading-tight">{{ $service->name }}</h3>

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
                        <div class="text-gray-900 font-bold text-xs mt-0.5">{{ $service->price_range }}</div>
                    </div>

                    <!-- Time Box (Smaller) -->
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 shadow-sm flex-1">
                        <div class="flex items-center gap-1.5 text-gray-400 text-[9px] uppercase font-semibold">
                            <i class="fas fa-clock text-[7px] text-[#C8000A]"></i>
                            Estimasi
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">{{ $service->estimated_days }} hari</div>
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
@endsection
