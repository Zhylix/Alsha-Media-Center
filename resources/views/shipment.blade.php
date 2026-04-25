@extends('layouts.app')
@section('title', 'Informasi Pengiriman')
@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Pengiriman</span>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 mt-3 mb-4">Opsi <span class="text-gradient">Pengiriman</span></h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pilih metode pengiriman yang sesuai dengan kebutuhan Anda. Kami bekerja sama dengan kurir terpercaya.</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- How to Ship -->
        <div class="text-center mb-14" data-animate>
            <h2 class="text-2xl font-black text-gray-900 mb-4">Cara Mengirim Perangkat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                @foreach([
                    ['step'=>'01','icon'=>'<i class="fas fa-box text-red-600"></i>','title'=>'Kemas dengan Aman','desc'=>'Bungkus perangkat dengan bubble wrap atau kotak yang aman agar tidak rusak saat pengiriman.'],
                    ['step'=>'02','icon'=>'<i class="fas fa-file-alt"></i>','title'=>'Sertakan Info Lengkap','desc'=>'Tuliskan nama, no. HP, dan deskripsi kerusakan di dalam paket untuk memudahkan proses.'],
                    ['step'=>'03','icon'=>'<i class="fas fa-rocket text-red-600"></i>','title'=>'Kirim ke Alamat Kami','desc'=>'Kirim ke Jl. Jepara No. 123, Jepara atau gunakan layanan antar jemput kami.'],
                ] as $step)
                <div class="service-card p-6 rounded-2xl text-center" data-animate>
                    <div class="w-10 h-10 rounded-full gradient-anim flex items-center justify-center text-gray-900 text-sm font-bold mx-auto mb-3">{{ $step['step'] }}</div>
                    <div class="text-4xl mb-3">{!! $step['icon'] !!}</div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="section-line mb-14"></div>

        <!-- Shipment Options -->
        <h2 class="text-2xl font-black text-gray-900 mb-8" data-animate>Pilihan <span class="text-gradient">Pengiriman</span></h2>
        <div class="space-y-4">
            @foreach($shipments as $shipment)
            <div class="service-card p-6 rounded-2xl flex items-center gap-6" data-animate>
                <div class="text-4xl flex-shrink-0">
                    @if($shipment->provider === 'Antar Jemput') <i class="fas fa-motorcycle"></i>
                    @elseif($shipment->provider === 'Pick Up') <i class="fas fa-store"></i>
                    @elseif($shipment->provider === 'JNE') <i class="fas fa-box text-red-600"></i>
                    @elseif($shipment->provider === 'J&T') <i class="fas fa-truck-moving"></i>
                    @else <i class="fas fa-truck text-red-600"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="font-bold text-gray-900">{{ $shipment->name }}</h3>
                        @if($shipment->price == 0)<span class="badge badge-red">Gratis</span>@endif
                    </div>
                    <p class="text-gray-600 text-sm">{{ $shipment->description }}</p>
                    @if($shipment->estimated_days > 0)
                    <p class="text-gray-500 text-xs mt-1">⏱ Estimasi {{ $shipment->estimated_days }} hari</p>
                    @endif
                </div>
                <div class="text-right flex-shrink-0">
                    @if($shipment->price == 0)
                    <p class="text-red-600 font-black text-xl">GRATIS</p>
                    @else
                    <p class="text-red-600 font-black text-xl">Rp {{ number_format($shipment->price, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Notes -->
        <div class="mt-10 service-card p-6 rounded-2xl border-red-600/20" data-animate>
            <h3 class="font-bold text-red-600 mb-3 flex items-center gap-2">⚠ Catatan Penting</h3>
            <ul class="space-y-2 text-gray-600 text-sm">
                <li>• Harga ongkos kirim belum termasuk dalam estimasi biaya service.</li>
                <li>• Kerusakan akibat pengiriman tidak menjadi tanggung jawab Alsha Media Center.</li>
                <li>• Layanan antar jemput hanya tersedia untuk area Bangsri.</li>
                <li>• Setelah selesai, perangkat akan dikirim kembali menggunakan ekspedisi yang sama.</li>
                <li>• Konfirmasi pengiriman akan dikirim via WhatsApp/email.</li>
            </ul>
        </div>

        <div class="text-center mt-10" data-animate>
            <a href="{{ route('order.create') }}" class="btn-primary inline-flex items-center gap-2 px-10 py-4 rounded-2xl text-white font-bold text-base">
                <i class="fas fa-wrench text-red-600"></i> Buat Pesanan Sekarang
            </a>
        </div>
    </div>
</section>
@endsection
