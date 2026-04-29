@extends('layouts.app')

@section('title', ($title ?? 'Sparepart') . ' | Alsha Media Center')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <span class="text-red-600 text-sm font-bold uppercase tracking-widest"><i class="fas fa-microchip mr-1"></i> Suku Cadang Berkualitas</span>
            <h1 class="text-4xl font-black text-gray-900 mt-3">{{ $title }}</h1>
            <p class="text-gray-600 mt-4 max-w-xl mx-auto">Kami menyediakan berbagai sparepart original dan berkualitas tinggi untuk laptop, printer, dan PC Anda.</p>
        </div>

        <!-- Category Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-12" data-animate>
            <a href="{{ route('spareparts.index') }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all {{ !isset($category) ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                Semua
            </a>
            <a href="{{ route('spareparts.category', 'laptop') }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all {{ (isset($category) && $category == 'laptop') ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                Laptop
            </a>
            <a href="{{ route('spareparts.category', 'printer') }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all {{ (isset($category) && $category == 'printer') ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                Printer
            </a>
            <a href="{{ route('spareparts.category', 'pc') }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all {{ (isset($category) && $category == 'pc') ? 'bg-red-600 text-white shadow-lg shadow-red-500/30' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                PC / Desktop
            </a>
        </div>

        @if($spareparts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($spareparts as $item)
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-red-500/5 transition-all hover:scale-[1.03] flex flex-col h-full group" data-animate>
                <div class="relative aspect-square overflow-hidden">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400 text-4xl">
                        <i class="fas fa-box"></i>
                    </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-lg text-[10px] font-black uppercase tracking-wider text-red-600 shadow-sm">{{ $item->category }}</span>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <h2 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ $item->name }}</h2>
                    <p class="text-gray-500 text-xs mb-4 line-clamp-2">{{ $item->description }}</p>
                    
                    <div class="mt-auto">
                        <p class="text-red-600 font-black text-xl mb-4">
                            {{ $item->price ? 'Rp ' . number_format($item->price, 0, ',', '.') : 'Hubungi Kami' }}
                        </p>
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp ?? '6281234567890') }}?text=Halo%20AMC,%20saya%20tertarik%20dengan%20{{ $item->name }}" target="_blank" class="w-full btn-primary inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-white font-bold text-sm transition-all">
                            <i class="fab fa-whatsapp"></i> Tanya Stok
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-12">
            {{ $spareparts->links() }}
        </div>
        @else
        <div class="text-center py-20 glass rounded-3xl" data-animate>
            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-3xl mb-6">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada sparepart</h3>
            <p class="text-gray-500">Kami akan segera memperbarui daftar stok sparepart kami.</p>
        </div>
        @endif
    </div>
</section>
@endsection
