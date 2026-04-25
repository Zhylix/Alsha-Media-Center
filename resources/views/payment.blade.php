@extends('layouts.app')
@section('title', 'Metode Pembayaran')
@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 left-1/4 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Pembayaran</span>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 mt-3 mb-4">Metode <span class="text-gradient">Pembayaran</span></h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">Berbagai pilihan pembayaran tersedia untuk kemudahan transaksi Anda.</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Bank Transfer -->
        <div class="mb-12" data-animate>
            <div class="flex items-center gap-3 mb-6">
                <div class="text-3xl"><i class="fas fa-university text-red-600"></i></div>
                <h2 class="text-2xl font-black text-gray-900">Transfer <span class="text-gradient">Bank</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($bankTransfers as $method)
                <div class="service-card p-6 rounded-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-red-600/10 border border-red-600/20 flex items-center justify-center font-black text-red-600">{{ strtoupper(substr($method->provider, 0, 3)) }}</div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $method->name }}</h3>
                            <span class="badge badge-gray">Transfer Bank</span>
                        </div>
                    </div>
                    @if($method->account_number)
                    <div class="bg-gray-50/50 rounded-xl p-4 mb-3">
                        <p class="text-gray-500 text-xs mb-1">Nomor Rekening</p>
                        <p class="text-gray-900 font-mono font-bold text-lg">{{ $method->account_number }}</p>
                        <p class="text-gray-600 text-sm">a.n. {{ $method->account_name }}</p>
                    </div>
                    @endif
                    @if($method->instructions)
                    <p class="text-gray-500 text-xs">{{ $method->instructions }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="section-line mb-12"></div>

        <!-- E-Wallet -->
        <div class="mb-12" data-animate>
            <div class="flex items-center gap-3 mb-6">
                <div class="text-3xl"><i class="fas fa-mobile-alt text-red-600"></i></div>
                <h2 class="text-2xl font-black text-gray-900">E-Wallet / <span class="text-gradient">Dompet Digital</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($eWallets as $method)
                <div class="service-card p-6 rounded-2xl text-center">
                    <div class="text-4xl mb-3">
                        @if($method->provider === 'GoPay') <i class="fas fa-heart text-red-600"></i>
                        @elseif($method->provider === 'OVO') <i class="fas fa-heart text-red-600"></i>
                        @elseif($method->provider === 'DANA') <i class="fas fa-heart text-red-600"></i>
                        @else <i class="fas fa-coins text-red-600"></i>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">{{ $method->name }}</h3>
                    @if($method->account_number)
                    <p class="text-gray-600 text-sm font-mono">{{ $method->account_number }}</p>
                    <p class="text-gray-500 text-xs">{{ $method->account_name }}</p>
                    @endif
                    <span class="badge badge-dark mt-3 inline-block">E-Wallet</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section-line mb-12"></div>

        <!-- COD -->
        @if($cod)
        <div class="mb-12" data-animate>
            <div class="flex items-center gap-3 mb-6">
                <div class="text-3xl"><i class="fas fa-money-bill-wave text-red-600"></i></div>
                <h2 class="text-2xl font-black text-gray-900">Bayar di <span class="text-gradient-warm">Tempat (COD)</span></h2>
            </div>
            <div class="service-card p-6 rounded-2xl flex gap-6 items-center">
                <div class="text-6xl flex-shrink-0"><i class="fas fa-handshake"></i></div>
                <div>
                    <h3 class="font-bold text-gray-900 text-xl mb-2">{{ $cod->name }}</h3>
                    <p class="text-gray-600">{{ $cod->instructions }}</p>
                    <span class="badge badge-red mt-3 inline-block">Khusus Bangsri</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment Steps -->
        <div class="service-card p-8 rounded-2xl" data-animate>
            <h3 class="font-bold text-gray-900 text-xl mb-6 flex items-center gap-2"><i class="fas fa-clipboard-list text-red-600"></i> Cara Pembayaran</h3>
            <div class="space-y-4">
                @foreach([
                    ['num'=>'1','text'=>'Buat pesanan service melalui form pemesanan di website kami.'],
                    ['num'=>'2','text'=>'Pilih metode pembayaran yang Anda inginkan saat checkout.'],
                    ['num'=>'3','text'=>'Lakukan pembayaran sesuai instruksi yang tertera.'],
                    ['num'=>'4','text'=>'Upload bukti pembayaran atau kirimkan ke WhatsApp kami.'],
                    ['num'=>'5','text'=>'Pesanan akan dikonfirmasi dan proses service dimulai.'],
                ] as $step)
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full gradient-anim flex items-center justify-center text-gray-900 text-sm font-bold flex-shrink-0">{{ $step['num'] }}</div>
                    <p class="text-gray-600 text-sm pt-1">{{ $step['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-10" data-animate>
            <a href="{{ route('order.create') }}" class="btn-primary inline-flex items-center gap-2 px-10 py-4 rounded-2xl text-white font-bold text-base">
                <i class="fas fa-wrench text-red-600"></i> Buat Pesanan Sekarang
            </a>
        </div>
    </div>
</section>
@endsection
