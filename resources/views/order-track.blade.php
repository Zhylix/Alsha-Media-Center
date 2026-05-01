@extends('layouts.app')
@section('title', 'Lacak Pesanan |Alsha Media Center')
@section('content')

<!-- ===================== HERO ===================== -->
<section class="relative py-20 bg-white overflow-hidden">
    <div class="absolute top-0 right-0 w-[40%] h-full bg-gray-50 hidden lg:block" style="clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%)"></div>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
        <div class="text-center max-w-xl mx-auto">
            <div class="inline-flex items-center gap-2.5 mb-6">
                <span class="block w-6 h-px bg-[#C8000A]"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Tracking</span>
            </div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight leading-tight mb-4">
                Lacak <span class="text-[#C8000A]">Pesanan</span>
            </h1>
            <p class="text-gray-400">Masukkan nomor pesanan Anda untuk melihat status.</p>
        </div>
    </div>
</section>

<!-- ===================== TRACKING FORM ===================== -->
<section class="py-16 bg-white">
    <div class="max-w-2xl mx-auto px-6">
        
        @if(isset($order))
        <!-- Order Found - Show Status -->
        <div class="service-card rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 text-center">
                @php $sb = $order->status_badge; @endphp
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Nomor Pesanan</p>
                <p class="text-2xl font-black text-[#C8000A] mb-3">{{ $order->order_number }}</p>
                <span class="badge badge-{{ $sb['color'] }} text-sm px-4 py-2">{{ $sb['label'] }}</span>
            </div>
            
            <div class="p-6">
                <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-info-circle text-red-600"></i> Detail Pesanan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama Pelanggan</span>
                        <span class="text-gray-900 font-medium">{{ $order->customer_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Layanan</span>
                        <span class="text-gray-900">{{ $order->service->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Perangkat</span>
                        <span class="text-gray-900">{{ $order->device_description }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-3">
                        <span class="text-gray-900 font-semibold">Total Harga</span>
                        <span class="text-[#C8000A] font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            @if($order->notes)
            <div class="p-6 bg-gray-50 border-t border-gray-100">
                <h3 class="font-bold text-gray-900 mb-2"><i class="fas fa-sticky-note text-red-600"></i> Catatan</h3>
                <p class="text-gray-600 text-sm">{{ $order->notes }}</p>
            </div>
            @endif
            
            <div class="p-6 bg-[#C8000A]/5 border-t border-gray-100">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Dibuat</span>
                    <span class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <div class="p-6">
                <a href="{{ route('order.index') }}" class="btn-outline w-full text-center block py-3 rounded-xl text-red-600 text-sm font-semibold">
                    <i class="fas fa-plus"></i> Buat Pesanan Baru
                </a>
            </div>
        </div>
        
        @else
        <!-- No Order - Show Search Form -->
        @if(session('error'))
        <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 mb-6">
            <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
            <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
        </div>
        @endif
        
        <form method="POST" action="{{ route('order.tracking.post') }}" class="service-card p-8 rounded-2xl">
            @csrf
            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-3">
                    Nomor Pesanan
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" name="order_number" value="{{ old('order_number') }}" required
                           class="form-input w-full pl-11 pr-4 py-4 rounded-xl text-sm font-mono uppercase"
                           placeholder="AMC-YYYYMMDD-XXX">
                </div>
                @error('order_number')
                <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
                @enderror
            </div>
            <button type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-semibold text-sm mt-4">
                <i class="fas fa-search mr-2"></i> Lacak Pesanan
            </button>
        </form>
        
        <!-- Quick Help -->
        <div class="mt-8 p-6 bg-gray-50 rounded-2xl">
            <h4 class="font-bold text-gray-900 mb-3 text-sm">Tidak tahu nomor pesanan?</h4>
            <p class="text-gray-600 text-sm mb-3">Setelah memesan, Anda akan menerima nomor pesanan melalui:</p>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500 text-xs"></i>
                    Halaman konfirmasi setelah submit
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500 text-xs"></i>
                    Email konfirmasi
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500 text-xs"></i>
                    WhatsApp konfirmasi
                </li>
            </ul>
        </div>
        @endif
        
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-red-600 text-sm hover:underline">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

@endsection
