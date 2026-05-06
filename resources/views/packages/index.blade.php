@extends('layouts.app')
@section('title', 'Paket Spesial | Alsha Media Center')

@section('content')

<!-- ===================== HERO ===================== -->
<section class="relative py-36 bg-white overflow-hidden">
    <div class="absolute top-0 right-0 w-[40%] h-full bg-[#C8000A] hidden lg:block" style="clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%)"></div>
    <div class="absolute top-0 right-0 w-[40%] h-full hidden lg:block opacity-10" style="clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%); background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 18px 18px;"></div>

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
        <div class="max-w-xl">
            <div class="inline-flex items-center gap-2.5 mb-6">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#C8000A] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#C8000A]"></span>
                </span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Penawaran Terbatas</span>
            </div>
            <h1 class="text-5xl sm:text-6xl font-black text-gray-900 tracking-tight leading-tight mb-5">
                Paket <span class="text-[#C8000A]">Spesial</span><br>Menanti Anda
            </h1>
            <p class="text-gray-400 text-lg leading-relaxed">
                Nikmati penawaran menarik khusus untuk layanan perbaikan elektronik di Alsha Media Center.
            </p>
        </div>
    </div>
</section>

<!-- ===================== PACKAGES GRID ===================== -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">

        @if($promos->count() > 0)
        <div class="flex items-center justify-between mb-10">
            <p class="text-sm text-gray-400 font-medium">
                Menampilkan <strong class="text-gray-800">{{ $promos->count() }}</strong> paket aktif
            </p>
            <div class="flex items-center gap-2 text-xs text-[#C8000A] font-black uppercase tracking-wider">
                <i class="fas fa-fire"></i> Segera berakhir
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($promos as $promo)
            <div class="group bg-white border border-gray-100 overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-gray-200/80 hover:border-gray-200 flex flex-col h-full relative">

                <div class="h-1 w-full bg-gray-100 group-hover:bg-[#C8000A] transition-colors duration-300"></div>

                <div class="relative aspect-[16/9] overflow-hidden bg-gray-50">
                    @if($promo->image)
                    <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                    <div class="w-full h-full bg-[#C8000A] flex items-center justify-center">
                        <i class="fas fa-tags text-white/20 text-6xl"></i>
                    </div>
                    @endif

                    @if($promo->discount_info)
                    <div class="absolute top-4 left-4">
                        <div class="px-3 py-1.5 bg-[#C8000A] text-white text-xs font-black uppercase tracking-wider shadow-lg">
                            {{ $promo->discount_info }}
                        </div>
                    </div>
                    @endif

                    @if($promo->end_date && $promo->end_date->isFuture())
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white text-gray-800 text-[10px] font-black uppercase tracking-wider shadow-sm">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            Aktif
                        </div>
                    </div>
                    @endif

                    <a href="/paket/{{ $promo->slug }}" class="absolute inset-0 z-10" aria-label="Lihat detail paket"></a>
                </div>

                <div class="p-7 flex flex-col flex-grow">
                    <h2 class="text-xl font-black text-gray-900 mb-3 leading-tight group-hover:text-[#C8000A] transition-colors">
                        {{ $promo->title }}
                    </h2>

                    <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3">{{ $promo->description }}</p>

                    <div class="mt-auto space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-white flex items-center justify-center border border-gray-200">
                                    <i class="fas fa-calendar-alt text-[#C8000A] text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.12em]">Berlaku Hingga</p>
                                    <p class="text-sm font-black text-gray-900">{{ $promo->end_date?->format('d M Y') }}</p>
                                </div>
                            </div>

                            @php
                                $daysLeft = ($promo->end_date) ? now()->diffInDays($promo->end_date, false) : null;
                            @endphp
                            @if($daysLeft !== null && $daysLeft >= 0)
                            <div class="text-right">
                                <p class="text-xs font-black text-[#C8000A]">{{ $daysLeft }} hari</p>
                                <p class="text-[10px] text-gray-400">tersisa</p>
                            </div>
                            @endif
                        </div>

                        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC,%20saya%20ingin%20klaim%20paket%3A%20{{ urlencode($promo->title) }}"
                           target="_blank"
                           class="group/btn w-full flex items-center justify-center gap-3 px-6 py-4 bg-[#C8000A] text-white font-black text-sm uppercase tracking-widest hover:bg-[#A00008] transition-colors">
                            <i class="fab fa-whatsapp text-base"></i>
                            Klaim Paket Sekarang
                            <i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="max-w-2xl mx-auto text-center py-24 bg-white border border-gray-100">
            <div class="w-20 h-20 mx-auto bg-gray-50 flex items-center justify-center text-gray-200 text-3xl mb-8">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-4">Belum Ada Paket Aktif</h3>
            <p class="text-gray-400 text-base mb-10 max-w-md mx-auto">Nantikan penawaran menarik kami selanjutnya. Kami selalu memberikan yang terbaik untuk pelanggan setia kami.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-sm font-black text-[#C8000A] uppercase tracking-wider hover:gap-5 transition-all">
                <i class="fas fa-arrow-left text-xs"></i> Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

<!-- ===================== WHY CHOOSE US ===================== -->
<section class="py-24 bg-gray-900 relative overflow-hidden">
    <div class="absolute inset-y-0 left-0 w-1 bg-[#C8000A]"></div>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2.5 mb-4">
                <span class="block w-6 h-px bg-[#C8000A]"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Keunggulan Kami</span>
                <span class="block w-6 h-px bg-[#C8000A]"></span>
            </div>
            <h2 class="text-4xl font-black text-white tracking-tight">Mengapa Pilih <span class="text-[#C8000A]">AMC?</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['icon' => 'fa-check-circle', 'title' => 'Layanan Terpercaya', 'desc' => 'Teknisi profesional berpengalaman yang telah menangani ribuan perangkat dengan hasil terbaik.'],
                ['icon' => 'fa-bolt', 'title' => 'Proses Cepat', 'desc' => 'Kami menghargai waktu Anda. Pengerjaan efisien tanpa mengorbankan kualitas perbaikan.'],
                ['icon' => 'fa-shield-alt', 'title' => 'Bergaransi Resmi', 'desc' => 'Setiap perbaikan disertai garansi 30 hari untuk memberikan ketenangan pikiran Anda.'],
            ] as $item)
            <div class="group p-8 border border-white/10 hover:border-[#C8000A]/50 transition-all duration-300">
                <div class="w-12 h-12 bg-[#C8000A] flex items-center justify-center mb-6">
                    <i class="fas {{ $item['icon'] }} text-white text-base"></i>
                </div>
                <h4 class="text-xl font-black text-white mb-3">{{ $item['title'] }}</h4>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

