@extends('layouts.app')
@section('title', 'Pesanan Berhasil!')
@section('content')
<section class="min-h-screen flex items-center justify-center py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-8xl mb-6 animate-float"><i class="fas fa-check-circle text-red-600"></i></div>
        <h1 class="text-4xl font-black text-gray-900 mb-3">Pesanan <span class="text-gradient">Berhasil!</span></h1>
        <p class="text-gray-600 mb-8">Terima kasih, {{ $order->customer_name }}! Pesanan Anda telah diterima.</p>

        <div class="service-card p-8 rounded-2xl text-left mb-8">
            <div class="text-center mb-6">
                <p class="text-gray-600 text-sm">Nomor Pesanan</p>
                <p class="text-3xl font-black text-gradient">{{ $order->order_number }}</p>
                <p class="text-gray-500 text-xs mt-1">Simpan nomor ini untuk melacak pesanan Anda</p>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Layanan</span><span class="text-gray-900 font-semibold">{{ $order->service->name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Perangkat</span><span class="text-gray-900">{{ $order->device_description }}</span></div>
                <div class="border-t border-red-600/10 pt-3 flex justify-between text-base font-black"><span class="text-gray-900">Total</span><span class="text-gradient">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>
            </div>
        </div>

        <div class="service-card p-6 rounded-2xl mb-8 text-left">
            <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-clipboard-list text-red-600"></i> Langkah Selanjutnya</h3>
            <div class="space-y-3">
                @foreach([
                    ['icon'=>'<i class="fas fa-phone-alt text-red-600"></i>','text'=>'Kami akan menghubungi Anda untuk konfirmasi pesanan'],
                    ['icon'=>'<i class="fas fa-box text-red-600"></i>','text'=>'Kirim perangkat ke alamat kami atau datang langsung'],
                    ['icon'=>'<i class="fas fa-wrench text-red-600"></i>','text'=>'Kami akan proses dan menginfokan perkembangan via WA/email'],
                ] as $step)
                <div class="flex items-center gap-3">
                    <span class="text-xl">{!! $step['icon'] !!}</span>
                    <p class="text-gray-600 text-sm">{{ $step['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex flex-wrap gap-4 justify-center">
            <a href="https://wa.me/{{ preg_replace('/\D/','',optional($store)->whatsapp ?? '6281234567890') }}?text=Halo, nomor pesanan saya: {{ $order->order_number }}" target="_blank" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fas fa-comments text-red-600"></i> Konfirmasi via WA</a>
            <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-red-600 font-bold"><i class="fas fa-search"></i> Lacak Pesanan</a>
            <a href="{{ route('home') }}" class="btn-outline inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-red-600 font-bold"><i class="fas fa-home text-red-600"></i> Beranda</a>
        </div>
    </div>
</section>
@endsection
