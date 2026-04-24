@extends('layouts.app')
@section('title', 'Metode Pembayaran')
@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 left-1/4 w-72 h-72 bg-green-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-green-400 text-sm font-bold uppercase tracking-widest">Pembayaran</span>
        <h1 class="text-4xl sm:text-5xl font-black text-white mt-3 mb-4">Metode <span class="text-gradient-green">Pembayaran</span></h1>
        <p class="text-slate-400 text-lg max-w-2xl mx-auto">Berbagai pilihan pembayaran tersedia untuk kemudahan transaksi Anda.</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Bank Transfer -->
        <div class="mb-12" data-animate>
            <div class="flex items-center gap-3 mb-6">
                <div class="text-3xl"><i class="fas fa-university text-indigo-400"></i></div>
                <h2 class="text-2xl font-black text-white">Transfer <span class="text-gradient">Bank</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($bankTransfers as $method)
                <div class="service-card p-6 rounded-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center font-black text-blue-400">{{ strtoupper(substr($method->provider, 0, 3)) }}</div>
                        <div>
                            <h3 class="font-bold text-white">{{ $method->name }}</h3>
                            <span class="badge badge-blue">Transfer Bank</span>
                        </div>
                    </div>
                    @if($method->account_number)
                    <div class="bg-slate-800/50 rounded-xl p-4 mb-3">
                        <p class="text-slate-500 text-xs mb-1">Nomor Rekening</p>
                        <p class="text-white font-mono font-bold text-lg">{{ $method->account_number }}</p>
                        <p class="text-slate-400 text-sm">a.n. {{ $method->account_name }}</p>
                    </div>
                    @endif
                    @if($method->instructions)
                    <p class="text-slate-500 text-xs">{{ $method->instructions }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="section-line mb-12"></div>

        <!-- E-Wallet -->
        <div class="mb-12" data-animate>
            <div class="flex items-center gap-3 mb-6">
                <div class="text-3xl"><i class="fas fa-mobile-alt text-green-400"></i></div>
                <h2 class="text-2xl font-black text-white">E-Wallet / <span class="text-gradient">Dompet Digital</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($eWallets as $method)
                <div class="service-card p-6 rounded-2xl text-center">
                    <div class="text-4xl mb-3">
                        @if($method->provider === 'GoPay') <i class="fas fa-heart text-green-500"></i>
                        @elseif($method->provider === 'OVO') <i class="fas fa-heart text-purple-500"></i>
                        @elseif($method->provider === 'DANA') <i class="fas fa-heart text-blue-500"></i>
                        @else <i class="fas fa-coins text-yellow-400"></i>
                        @endif
                    </div>
                    <h3 class="font-bold text-white mb-1">{{ $method->name }}</h3>
                    @if($method->account_number)
                    <p class="text-slate-400 text-sm font-mono">{{ $method->account_number }}</p>
                    <p class="text-slate-500 text-xs">{{ $method->account_name }}</p>
                    @endif
                    <span class="badge badge-purple mt-3 inline-block">E-Wallet</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section-line mb-12"></div>

        <!-- COD -->
        @if($cod)
        <div class="mb-12" data-animate>
            <div class="flex items-center gap-3 mb-6">
                <div class="text-3xl"><i class="fas fa-money-bill-wave text-green-400"></i></div>
                <h2 class="text-2xl font-black text-white">Bayar di <span class="text-gradient-warm">Tempat (COD)</span></h2>
            </div>
            <div class="service-card p-6 rounded-2xl flex gap-6 items-center">
                <div class="text-6xl flex-shrink-0"><i class="fas fa-handshake"></i></div>
                <div>
                    <h3 class="font-bold text-white text-xl mb-2">{{ $cod->name }}</h3>
                    <p class="text-slate-400">{{ $cod->instructions }}</p>
                    <span class="badge badge-yellow mt-3 inline-block">Khusus Bandung Kota</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment Steps -->
        <div class="service-card p-8 rounded-2xl" data-animate>
            <h3 class="font-bold text-white text-xl mb-6 flex items-center gap-2"><i class="fas fa-clipboard-list text-yellow-400"></i> Cara Pembayaran</h3>
            <div class="space-y-4">
                @foreach([
                    ['num'=>'1','text'=>'Buat pesanan service melalui form pemesanan di website kami.'],
                    ['num'=>'2','text'=>'Pilih metode pembayaran yang Anda inginkan saat checkout.'],
                    ['num'=>'3','text'=>'Lakukan pembayaran sesuai instruksi yang tertera.'],
                    ['num'=>'4','text'=>'Upload bukti pembayaran atau kirimkan ke WhatsApp kami.'],
                    ['num'=>'5','text'=>'Pesanan akan dikonfirmasi dan proses service dimulai.'],
                ] as $step)
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full gradient-anim flex items-center justify-center text-white text-sm font-bold flex-shrink-0">{{ $step['num'] }}</div>
                    <p class="text-slate-400 text-sm pt-1">{{ $step['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-10" data-animate>
            <a href="{{ route('order.create') }}" class="btn-primary inline-flex items-center gap-2 px-10 py-4 rounded-2xl text-white font-bold text-base">
                <i class="fas fa-wrench text-orange-400"></i> Buat Pesanan Sekarang
            </a>
        </div>
    </div>
</section>
@endsection
