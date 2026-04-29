@extends('layouts.app')

@section('title', 'Promo Spesial | Alsha Media Center')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden bg-white">
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-5%] w-[40%] h-[40%] rounded-full bg-red-600 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[40%] h-[40%] rounded-full bg-red-900 blur-[120px]"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20" data-animate>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-50 text-red-600 text-xs font-black uppercase tracking-widest mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                </span>
                Penawaran Terbatas
            </span>
            <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 tracking-tight">
                Promo <span class="text-gradient">Spesial</span> Menanti Anda
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
                Nikmati potongan harga dan penawaran menarik lainnya khusus untuk layanan perbaikan laptop, printer, dan PC di Alsha Media Center.
            </p>
        </div>

        @if($promos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($promos as $promo)
            <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-gray-200/50 border border-gray-100 transition-all duration-500 hover:translate-y-[-12px] flex flex-col h-full" data-animate>
                <div class="relative aspect-[4/3] overflow-hidden">
                    @if($promo->image)
                    <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                    <div class="w-full h-full gradient-anim flex items-center justify-center text-white text-6xl">
                        <i class="fas fa-tags"></i>
                    </div>
                    @endif
                    
                    @if($promo->discount_info)
                    <div class="absolute top-6 left-6">
                        <div class="px-5 py-2.5 bg-red-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-red-600/30">
                            {{ $promo->discount_info }}
                        </div>
                    </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>

                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-8 h-[2px] bg-red-600"></span>
                        <span class="text-xs font-bold text-red-600 uppercase tracking-widest">Active Deal</span>
                    </div>
                    
                    <h2 class="text-2xl font-black text-gray-900 mb-4 group-hover:text-red-600 transition-colors leading-tight">
                        {{ $promo->title }}
                    </h2>
                    
                    <p class="text-gray-600 text-sm mb-8 line-clamp-3 leading-relaxed">
                        {{ $promo->description }}
                    </p>
                    
                    <div class="mt-auto space-y-6">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-red-600 shadow-sm">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Berlaku Hingga</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $promo->end_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            @if($promo->end_date->isFuture())
                            <span class="text-[10px] font-black text-green-600 bg-green-50 px-3 py-1 rounded-full border border-green-100">Aktif</span>
                            @endif
                        </div>

                        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC,%20saya%20tertarik%20dengan%20promo%20{{ $promo->title }}" target="_blank" class="w-full btn-primary group/btn inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-black text-sm transition-all">
                            <span>Ambil Promo Sekarang</span>
                            <i class="fas fa-arrow-right transition-transform group-hover/btn:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="max-w-3xl mx-auto text-center py-24 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200" data-animate>
            <div class="w-24 h-24 mx-auto bg-white rounded-3xl flex items-center justify-center text-gray-300 text-4xl mb-8 shadow-xl shadow-gray-200/50">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-4">Belum Ada Promo Aktif</h3>
            <p class="text-gray-500 text-lg mb-10 px-8">Nantikan penawaran menarik kami selanjutnya. Kami selalu memberikan yang terbaik untuk pelanggan setia kami.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-red-600 font-black hover:gap-5 transition-all">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Why Choose Us Mini Section -->
<section class="py-20 bg-gray-900 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
            <div data-animate>
                <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center text-white text-xl mb-6 mx-auto md:mx-0 shadow-lg shadow-red-600/30">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-3">Layanan Terpercaya</h4>
                <p class="text-gray-400 text-sm leading-relaxed">Teknisi profesional yang sudah berpengalaman bertahun-tahun dalam menangani ribuan perangkat.</p>
            </div>
            <div data-animate>
                <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center text-white text-xl mb-6 mx-auto md:mx-0 shadow-lg shadow-red-600/30">
                    <i class="fas fa-bolt"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-3">Proses Cepat</h4>
                <p class="text-gray-400 text-sm leading-relaxed">Kami menghargai waktu Anda. Pengerjaan dilakukan secara efisien namun tetap mengutamakan kualitas.</p>
            </div>
            <div data-animate>
                <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center text-white text-xl mb-6 mx-auto md:mx-0 shadow-lg shadow-red-600/30">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-3">Bergaransi Resmi</h4>
                <p class="text-gray-400 text-sm leading-relaxed">Setiap perbaikan yang kami lakukan disertai dengan garansi untuk memberikan rasa aman bagi Anda.</p>
            </div>
        </div>
    </div>
</section>
@endsection
