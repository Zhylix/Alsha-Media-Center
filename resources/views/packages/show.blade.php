@extends('layouts.app')
@section('title', $promo->title . ' | Paket Spesial - Alsha Media Center')

@section('content')

<section class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-6 sm:px-8">
        <div class="flex flex-col lg:flex-row gap-10 items-start">
            <div class="lg:w-1/2 w-full">
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm">
                    <div class="aspect-[16/10] bg-gray-100 relative">
                        @if($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-[#C8000A] flex items-center justify-center">
                                <i class="fas fa-tags text-white/20 text-7xl"></i>
                            </div>
                        @endif
                        @if($promo->discount_info)
                            <div class="absolute top-5 left-5">
                                <div class="px-4 py-2 rounded-full bg-[#C8000A] text-white text-xs font-black uppercase tracking-wider shadow-lg">
                                    {{ $promo->discount_info }}
                                </div>
                            </div>
                        @endif
                        @if($promo->end_date && $promo->end_date->isFuture())
                            <div class="absolute top-5 right-5">
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/95 text-gray-800 text-[10px] font-black uppercase tracking-wider shadow-sm">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    Aktif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 w-full">
                <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                    <div class="mb-6">
                        <a href="/paket" class="inline-flex items-center gap-2 text-sm font-black text-[#C8000A] uppercase tracking-wider hover:gap-3">
                            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Paket
                        </a>
                    </div>

                    <h1 class="text-4xl font-black text-gray-900 leading-tight mb-4">
                        Paket <span class="text-[#C8000A]">Spesial</span>
                    </h1>
                    <h2 class="text-2xl font-black text-gray-900 mb-4">{{ $promo->title }}</h2>

                    <p class="text-gray-600 text-base leading-relaxed mb-8">{{ $promo->description }}</p>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-100 rounded-2xl">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-white border border-gray-200 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-[#C8000A] text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.12em]">Berlaku Hingga</p>
                                    <p class="text-sm font-black text-gray-900">{{ $promo->end_date?->format('d M Y') }}</p>
                                </div>
                            </div>

                            @php
                                $daysLeft = $promo->end_date?->isFuture()
                                    ? floor(now()->diffInDays($promo->end_date, false))
                                    : null;
                            @endphp
                            @if(!is_null($daysLeft))
                            <div class="text-right">
                                <p class="text-xs font-black text-[#C8000A]">
                                    {{ $daysLeft }} hari
                                </p>
                                <p class="text-[10px] text-gray-400">tersisa</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC,%20saya%20ingin%20klaim%20paket%3A%20{{ urlencode($promo->title) }}"
                       target="_blank"
                       class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-[#C8000A] text-white font-black text-sm uppercase tracking-widest hover:bg-[#A00008] transition-colors rounded-2xl">
                        <i class="fab fa-whatsapp text-base"></i>
                        Klaim Paket Sekarang
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>

                    <p class="text-xs text-gray-400 mt-4 text-center">
                        *Paket ini berlaku sesuai jadwal yang tertera.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

