@extends('layouts.app')
@section('title', 'Lacak Pesanan')
@section('content')
<section class="relative py-24 bg-hero overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl font-black text-gray-900 mb-4">Lacak <span class="text-gradient">Pesanan</span></h1>
        <p class="text-gray-600">Masukkan nomor pesanan Anda untuk melihat status terkini.</p>
    </div>
</section>
<section class="py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('order.track') }}" class="service-card p-8 rounded-2xl mb-8">
            <div class="flex gap-3">
                <input type="text" name="order_number" value="{{ request('order_number') }}" placeholder="Contoh: TFP-20260424-ABCD" class="form-input flex-1 px-4 py-3 rounded-xl text-sm">
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl text-white font-bold whitespace-nowrap"><i class="fas fa-search"></i> Cari</button>
            </div>
        </form>

        @if($order)
        <div class="service-card p-8 rounded-2xl">
            <div class="text-center mb-6">
                <p class="text-gray-600 text-sm">Nomor Pesanan</p>
                <p class="text-2xl font-black text-gradient">{{ $order->order_number }}</p>
            </div>

            <!-- Status Timeline -->
            <div class="relative mb-8">
                @php
                $statuses = ['pending','confirmed','in_progress','completed'];
                $currentIdx = array_search($order->status, $statuses);
                @endphp
                <div class="flex justify-between relative">
                    <div class="absolute top-5 left-0 right-0 h-0.5 bg-slate-700 z-0"></div>
                    @foreach([
                        ['key'=>'pending','label'=>'Menunggu','icon'=>'⏳'],
                        ['key'=>'confirmed','label'=>'Dikonfirmasi','icon'=>'<i class="fas fa-check text-red-600"></i>'],
                        ['key'=>'in_progress','label'=>'Diproses','icon'=>'<i class="fas fa-wrench text-red-600"></i>'],
                        ['key'=>'completed','label'=>'Selesai','icon'=>'<i class="fas fa-check-circle text-red-600"></i>'],
                    ] as $i => $s)
                    @php $stepIdx = $i; $isDone = $currentIdx >= $stepIdx; $isCurrent = $currentIdx === $stepIdx; @endphp
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-base {{ $isDone ? 'step-active' : 'step-inactive' }}">{!! $s['icon'] !!}</div>
                        <p class="text-xs mt-2 {{ $isCurrent ? 'text-red-600 font-bold' : ($isDone ? 'text-gray-700' : 'text-gray-500') }}">{{ $s['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($order->status === 'cancelled')
            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6 text-center">
                <p class="text-red-400 font-bold">Pesanan Dibatalkan</p>
            </div>
            @endif

            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Pelanggan</span><span class="text-gray-900">{{ $order->customer_name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Layanan</span><span class="text-gray-900">{{ $order->service->name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Perangkat</span><span class="text-gray-900">{{ $order->device_description }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Status Pembayaran</span>
                    @php $pb = $order->payment_badge; @endphp
                    <span class="badge badge-{{ $pb['color'] }}">{{ $pb['label'] }}</span>
                </div>
                <div class="border-t border-red-600/10 pt-3 flex justify-between font-black text-base"><span class="text-gray-900">Total</span><span class="text-gradient">Rp {{ number_format($order->total_price,0,',','.') }}</span></div>
            </div>

            @if($order->notes)
            <div class="mt-4 p-4 bg-red-600/10 border border-red-600/20 rounded-xl">
                <p class="text-red-600 text-xs font-bold mb-1">Catatan dari Admin:</p>
                <p class="text-gray-700 text-sm">{{ $order->notes }}</p>
            </div>
            @endif
        </div>
        @elseif(request('order_number'))
        <div class="service-card p-8 rounded-2xl text-center">
            <div class="text-5xl mb-4"><i class="fas fa-search"></i></div>
            <h3 class="font-bold text-gray-900 mb-2">Pesanan Tidak Ditemukan</h3>
            <p class="text-gray-600 text-sm">Nomor pesanan "{{ request('order_number') }}" tidak ditemukan. Pastikan nomor yang Anda masukkan benar.</p>
        </div>
        @endif
    </div>
</section>
@endsection
