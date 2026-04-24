@extends('layouts.app')
@section('title', $service->name)
@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a> /
            <a href="{{ route('services.index') }}" class="hover:text-white">Layanan</a> /
            <a href="{{ route('services.'.$service->category) }}" class="hover:text-white">{{ $service->category_label }}</a> /
            <span class="text-blue-400">{{ $service->name }}</span>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="badge badge-{{ $service->category === 'laptop' ? 'blue' : ($service->category === 'printer' ? 'purple' : 'green') }} mb-4 inline-block">{{ $service->category_label }}</span>
                <h1 class="text-4xl font-black text-white mb-4">{{ $service->name }}</h1>
                <p class="text-slate-400 text-lg mb-6">{{ $service->short_description }}</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('order.create') }}?service={{ $service->slug }}" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fas fa-wrench text-orange-400"></i> Pesan Sekarang</a>
                    <a href="https://wa.me/{{ preg_replace('/\D/','',optional($store)->whatsapp ?? '6281234567890') }}?text=Halo, saya ingin tanya tentang {{ $service->name }}" target="_blank" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fas fa-comments text-green-500"></i> Tanya WA</a>
                </div>
            </div>
            <div class="service-card p-8 rounded-2xl">
                <div class="text-6xl text-center mb-4">{!! $service->category === 'laptop' ? '<i class="fas fa-laptop text-blue-400"></i>' : ($service->category === 'printer' ? '<i class="fas fa-print text-purple-400"></i>' : '<i class="fas fa-mobile-alt text-green-400"></i>') !!}</div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-blue-500/10">
                        <span class="text-slate-400 text-sm">Harga</span>
                        <span class="text-blue-400 font-bold">{{ $service->price_range }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-blue-500/10">
                        <span class="text-slate-400 text-sm">Estimasi Waktu</span>
                        <span class="text-white font-semibold">{{ $service->estimated_days }} hari kerja</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <span class="text-slate-400 text-sm">Garansi</span>
                        <span class="text-green-400 font-semibold">30 Hari</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="service-card p-8 rounded-2xl mb-8" data-animate>
            <h2 class="text-2xl font-black text-white mb-4">Deskripsi Layanan</h2>
            <p class="text-slate-400 leading-relaxed">{{ $service->description }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10" data-animate>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-check text-green-500"></i></div>
                <p class="text-white font-semibold text-sm">Garansi 30 Hari</p>
            </div>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-cogs text-slate-400"></i></div>
                <p class="text-white font-semibold text-sm">Spare Part Original</p>
            </div>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-bolt text-yellow-400"></i></div>
                <p class="text-white font-semibold text-sm">Teknisi Berpengalaman</p>
            </div>
        </div>
    </div>
</section>

@if($related->count() > 0)
<section class="py-16 bg-slate-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-black text-white mb-8" data-animate>Layanan <span class="text-gradient">Terkait</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $rel)
            <div class="service-card p-5 rounded-2xl" data-animate>
                <h3 class="font-bold text-white mb-2">{{ $rel->name }}</h3>
                <p class="text-slate-400 text-sm mb-3 line-clamp-2">{{ Str::limit($rel->description, 80) }}</p>
                <div class="flex items-center justify-between">
                    <p class="text-blue-400 font-bold text-sm">{{ $rel->price_range }}</p>
                    <a href="{{ route('services.show', $rel->slug) }}" class="btn-primary px-3 py-2 rounded-lg text-white text-xs">Lihat</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
