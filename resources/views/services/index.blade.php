@extends('layouts.app')
@section('title', 'Semua Layanan')

@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Layanan Kami</span>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 mt-3 mb-4">Semua <span class="text-gradient">Jasa Service</span></h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pilih layanan yang Anda butuhkan. Semua dikerjakan oleh teknisi berpengalaman dengan garansi resmi.</p>
        <!-- Quick Nav -->
        <div class="flex justify-center gap-4 mt-8 flex-wrap">
            <a href="{{ route('services.laptop') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-semibold"><i class="fas fa-laptop text-red-600"></i> Laptop</a>
            <a href="{{ route('services.printer') }}" class="btn-outline inline-flex items-center gap-2 px-6 py-3 rounded-xl text-red-600 font-semibold"><i class="fas fa-print text-red-600"></i> Printer</a>
            <a href="{{ route('services.hp') }}" class="btn-outline inline-flex items-center gap-2 px-6 py-3 rounded-xl text-red-600 font-semibold"><i class="fas fa-mobile-alt text-red-600"></i> HP</a>
        </div>
    </div>
</section>

<!-- Laptop Services -->
<section class="py-20" id="laptop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10" data-animate>
            <div>
                <div class="flex items-center gap-3 mb-2"><span class="text-4xl"><i class="fas fa-laptop text-red-600"></i></span><span class="badge badge-gray">Laptop</span></div>
                <h2 class="text-2xl font-black text-gray-900">Service <span class="text-gradient">Laptop</span></h2>
            </div>
            <a href="{{ route('services.laptop') }}" class="btn-outline px-5 py-2.5 rounded-xl text-red-600 text-sm font-semibold hidden sm:block">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($laptopServices as $service)
            <div class="service-card p-6 rounded-2xl" data-animate>
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-base">{{ $service->name }}</h3>
                    @if($service->is_featured)<span class="badge badge-red"><i class="fas fa-star text-red-600"></i> Populer</span>@endif
                </div>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->short_description ?? Str::limit($service->description, 100) }}</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 font-bold text-sm">{{ $service->price_range }}</p>
                        <p class="text-gray-500 text-xs">Est. {{ $service->estimated_days }} hari</p>
                    </div>
                    <a href="{{ route('services.show', $service->slug) }}" class="btn-primary px-4 py-2 rounded-xl text-white text-xs font-semibold">Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="section-line"></div>

<!-- Printer Services -->
<section class="py-20 bg-white" id="printer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10" data-animate>
            <div>
                <div class="flex items-center gap-3 mb-2"><span class="text-4xl"><i class="fas fa-print text-red-600"></i></span><span class="badge badge-dark">Printer</span></div>
                <h2 class="text-2xl font-black text-gray-900">Service <span class="text-gradient">Printer</span></h2>
            </div>
            <a href="{{ route('services.printer') }}" class="btn-outline px-5 py-2.5 rounded-xl text-red-600 text-sm font-semibold hidden sm:block">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($printerServices as $service)
            <div class="service-card p-6 rounded-2xl" data-animate>
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-base">{{ $service->name }}</h3>
                    @if($service->is_featured)<span class="badge badge-red"><i class="fas fa-star text-red-600"></i> Populer</span>@endif
                </div>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->short_description ?? Str::limit($service->description, 100) }}</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 font-bold text-sm">{{ $service->price_range }}</p>
                        <p class="text-gray-500 text-xs">Est. {{ $service->estimated_days }} hari</p>
                    </div>
                    <a href="{{ route('services.show', $service->slug) }}" class="btn-primary px-4 py-2 rounded-xl text-white text-xs font-semibold">Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="section-line"></div>

<!-- HP Services -->
<section class="py-20" id="hp">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10" data-animate>
            <div>
                <div class="flex items-center gap-3 mb-2"><span class="text-4xl"><i class="fas fa-mobile-alt text-red-600"></i></span><span class="badge badge-red">HP</span></div>
                <h2 class="text-2xl font-black text-gray-900">Service <span class="text-gradient">Handphone</span></h2>
            </div>
            <a href="{{ route('services.hp') }}" class="btn-outline px-5 py-2.5 rounded-xl text-red-600 text-sm font-semibold hidden sm:block">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($hpServices as $service)
            <div class="service-card p-6 rounded-2xl" data-animate>
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-base">{{ $service->name }}</h3>
                    @if($service->is_featured)<span class="badge badge-red"><i class="fas fa-star text-red-600"></i> Populer</span>@endif
                </div>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->short_description ?? Str::limit($service->description, 100) }}</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 font-bold text-sm">{{ $service->price_range }}</p>
                        <p class="text-gray-500 text-xs">Est. {{ $service->estimated_days }} hari</p>
                    </div>
                    <a href="{{ route('services.show', $service->slug) }}" class="btn-primary px-4 py-2 rounded-xl text-white text-xs font-semibold">Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
