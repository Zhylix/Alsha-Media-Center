    @extends('layouts.app')
@section('title', 'Service Printer')

@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 left-1/4 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center gap-2 text-gray-500 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-900">Beranda</a> / <a href="{{ route('services.index') }}" class="hover:text-gray-900">Layanan</a> / <span class="text-red-600">Printer</span>
        </div>
        <div class="flex items-center gap-4 mb-4"><span class="text-6xl animate-float"><i class="fas fa-print text-red-600"></i></span><span class="badge badge-dark text-base px-4 py-2">Service Printer</span></div>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">Jasa Service <span class="text-gradient">Printer</span> Profesional</h1>
        <p class="text-gray-600 text-lg max-w-2xl">Semua merek printer ditangani: Canon, Epson, HP, Brother, Xerox, dan lainnya.</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <div class="service-card p-6 rounded-2xl group" data-animate>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-red-600/10 border border-red-600/20 flex items-center justify-center text-2xl"><i class="fas fa-print text-red-600"></i></div>
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
                        <a href="{{ route('order.create') }}?service={{ $service->slug }}" class="btn-primary px-4 py-2 rounded-xl text-white text-xs font-semibold">Pesan</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Supported Brands -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <h2 class="text-2xl font-black text-gray-900 mb-8">Merek Printer yang Kami Tangani</h2>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach(['Canon','Epson','HP','Brother','Xerox','Panasonic','Samsung','Fujitsu'] as $brand)
            <span class="px-5 py-2.5 glass rounded-xl text-gray-700 text-sm font-medium">{{ $brand }}</span>
            @endforeach
        </div>
    </div>
</section>
