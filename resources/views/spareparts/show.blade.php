@extends('layouts.app')
@section('title', $sparepart->name . ' | Alsha Media Center')

@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center gap-2 text-gray-500 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-900">Beranda</a> /
            <a href="{{ route('spareparts.index') }}" class="hover:text-gray-900">Sparepart</a> /
            <a href="{{ route('spareparts.category', $sparepart->category) }}" class="hover:text-gray-900">
                {{ $sparepart->category == 'laptop' ? 'Laptop' : ($sparepart->category == 'printer' ? 'Printer' : 'PC / Desktop') }}
            </a> /
            <span class="text-red-600">{{ $sparepart->name }}</span>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block px-4 py-2 bg-gradient-to-r {{ $sparepart->category == 'laptop' ? 'from-blue-500 to-blue-600' : ($sparepart->category == 'printer' ? 'from-purple-500 to-purple-600' : 'from-green-500 to-green-600') }} text-white text-xs font-bold uppercase rounded-full mb-6">
                    {{ $sparepart->category == 'laptop' ? 'Laptop' : ($sparepart->category == 'printer' ? 'Printer' : 'PC') }}
                </span>
                <h1 class="text-4xl font-black text-gray-900 mb-6 leading-tight">{{ $sparepart->name }}</h1>
                <div class="mb-8">
                    <p class="text-2xl font-black text-red-600 mb-4">
                        {{ $sparepart->price ? 'Rp ' . number_format($sparepart->price, 0, ',', '.') : 'Hubungi Kami' }}
                    </p>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-{{ $sparepart->is_available ? 'green' : 'red' }}-100 text-{{ $sparepart->is_available ? 'green' : 'red' }}-800 text-sm font-bold rounded-xl">
                        <i class="fas fa-{{ $sparepart->is_available ? 'check' : 'times' }}"></i>
                        {{ $sparepart->is_available ? 'Tersedia' : 'Stok Habis' }}
                    </span>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo AMC, saya tertarik dengan {{ $sparepart->name }} ({{ $sparepart->category }}). Ada stok? Harga {{ $sparepart->price ? number_format($sparepart->price) : 'terupdate' }}?" target="_blank" 
                       class="btn-primary inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-white font-bold shadow-xl hover:shadow-2xl transition-all">
                        <i class="fab fa-whatsapp text-xl"></i> Beli / Tanya Stok
                    </a>
                    <a href="{{ route('contact') }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl border-2 border-red-600 text-red-600 font-bold hover:bg-red-600 hover:text-white transition-all">
                        <i class="fas fa-phone-alt"></i> Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="service-card p-12 rounded-3xl relative">
                @if($sparepart->image)
                    <img src="{{ asset('storage/' . $sparepart->image) }}" alt="{{ $sparepart->name }}" class="w-full h-64 object-cover rounded-2xl mx-auto shadow-2xl">
                @else
                    <div class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center text-6xl text-gray-400 mx-auto">
                        <i class="fas fa-box-open"></i>
                    </div>
                @endif
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-microchip text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="service-card p-10 rounded-3xl mb-12" data-animate>
            <h2 class="text-3xl font-black text-gray-900 mb-6 text-center">Detail Sparepart</h2>
            <div class="prose prose-headings:text-gray-900 prose-headings:font-black prose-p:leading-relaxed max-w-none">
                {!! nl2br(e($sparepart->description)) !!}
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12" data-animate>
            <div class="service-card p-8 rounded-2xl text-center hover:shadow-xl transition-all">
                <div class="text-4xl mb-4 text-red-600"><i class="fas fa-medal"></i></div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kualitas Original</h3>
                <p class="text-gray-600">Sparepart 100% original dari distributor resmi.</p>
            </div>
            <div class="service-card p-8 rounded-2xl text-center hover:shadow-xl transition-all">
                <div class="text-4xl mb-4 text-red-600"><i class="fas fa-shield-alt"></i></div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Garansi 1 Tahun</h3>
                <p class="text-gray-600">Garansi resmi hingga 1 tahun untuk setiap pembelian.</p>
            </div>
            <div class="service-card p-8 rounded-2xl text-center hover:shadow-xl transition-all">
                <div class="text-4xl mb-4 text-green-600"><i class="fas fa-shipping-fast"></i></div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Siap Kirim</h3>
                <p class="text-gray-600">Pesan sekarang, kirim hari ini untuk stok tersedia.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-gray-900 mb-4">Sparepart Lainnya</h2>
            <p class="text-gray-600">Sparepart serupa untuk kebutuhan {{ strtolower($sparepart->category_label ?? $sparepart->category) }}</p>
        </div>
        {{-- Note: Add related spareparts logic in controller if needed --}}
        <p class="text-center text-gray-500 py-12 border-2 border-dashed border-gray-200 rounded-3xl">Related spareparts akan ditambahkan di update berikutnya</p>
    </div>
</section>
@endsection

