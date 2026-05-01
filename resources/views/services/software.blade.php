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
            <div class="service-card p-6 rounded-2xl group" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-red-600/10 border border-red-600/20 flex items-center justify-center text-2xl"><i class="fas fa-compact-disc text-red-600"></i></div>
                    @if($service->is_featured)<span class="badge badge-red"><i class="fas fa-star text-red-600"></i> Populer</span>@endif
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $service->name }}</h3>
                <p class="text-gray-600 text-sm mb-5 line-clamp-3">{{ $service->short_description ?? Str::limit($service->description, 120) }}</p>
                <div class="border-t border-red-600/10 pt-4 flex items-center justify-between">
                    <div>
                        <p class="text-red-600 font-bold">{{ $service->price_range }}</p>
                        <p class="text-gray-500 text-xs">⏱ Est. {{ $service->estimated_days }} hari kerja</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('services.show', $service->slug) }}" class="px-3 py-2 rounded-xl glass text-gray-700 hover:text-gray-900 text-xs transition-all">Detail</a>
                    </div>
                </div>
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
