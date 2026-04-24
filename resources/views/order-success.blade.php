@extends('layouts.app')
@section('title', 'Pesanan Berhasil!')
@section('content')
<section class="min-h-screen flex items-center justify-center py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-8xl mb-6 animate-float"><i class="fas fa-check-circle text-green-500"></i></div>
        <h1 class="text-4xl font-black text-white mb-3">Pesanan <span class="text-gradient">Berhasil!</span></h1>
        <p class="text-slate-400 mb-8">Terima kasih, {{ $order->customer_name }}! Pesanan Anda telah diterima.</p>

        <div class="service-card p-8 rounded-2xl text-left mb-8">
            <div class="text-center mb-6">
                <p class="text-slate-400 text-sm">Nomor Pesanan</p>
                <p class="text-3xl font-black text-gradient">{{ $order->order_number }}</p>
                <p class="text-slate-500 text-xs mt-1">Simpan nomor ini untuk melacak pesanan Anda</p>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-slate-400">Layanan</span><span class="text-white font-semibold">{{ $order->service->name }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Perangkat</span><span class="text-white">{{ $order->device_description }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Pengiriman</span><span class="text-white">{{ $order->shipmentOption?->name ?? 'Tidak dipilih' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Pembayaran</span><span class="text-white">{{ $order->paymentMethod?->name }}</span></div>
                <div class="border-t border-blue-500/10 pt-3 flex justify-between text-base font-black"><span class="text-white">Total</span><span class="text-gradient">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>
            </div>
        </div>

        <div class="service-card p-6 rounded-2xl mb-8 text-left">
            <h3 class="font-bold text-white mb-4"><i class="fas fa-clipboard-list text-yellow-400"></i> Langkah Selanjutnya</h3>
            <div class="space-y-3">
                @foreach([
                    ['icon'=>'<i class="fas fa-credit-card text-purple-500"></i>','text'=>'Lakukan pembayaran sesuai metode yang dipilih'],
                    ['icon'=>'<i class="fas fa-camera text-blue-400"></i>','text'=>'Kirim bukti pembayaran ke WhatsApp kami'],
                    ['icon'=>'<i class="fas fa-box text-amber-500"></i>','text'=>'Kirim perangkat ke alamat kami atau tunggu antar jemput'],
                    ['icon'=>'<i class="fas fa-wrench text-orange-400"></i>','text'=>'Kami akan proses dan menginfokan perkembangan via WA/email'],
                ] as $step)
                <div class="flex items-center gap-3">
                    <span class="text-xl">{!! $step['icon'] !!}</span>
                    <p class="text-slate-400 text-sm">{{ $step['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex flex-wrap gap-4 justify-center">
            <a href="https://wa.me/{{ preg_replace('/\D/','',optional($store)->whatsapp ?? '6281234567890') }}?text=Halo, nomor pesanan saya: {{ $order->order_number }}" target="_blank" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fas fa-comments text-green-500"></i> Konfirmasi via WA</a>
            <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fas fa-search"></i> Lacak Pesanan</a>
            <a href="{{ route('home') }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fas fa-home text-blue-400"></i> Beranda</a>
        </div>
    </div>
</section>
@endsection
