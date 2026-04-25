@extends('layouts.admin')
@section('title','Detail Pesanan')
@section('page-title','Detail Pesanan')
@section('page-subtitle','{{ $order->order_number }}')

@section('content')
<div class="max-w-4xl grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Info -->
    <div class="lg:col-span-2 space-y-5">
        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-clipboard-list text-red-600"></i> Informasi Pesanan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">No. Pesanan</span><span class="text-red-600 font-mono font-bold">{{ $order->order_number }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Layanan</span><span class="text-gray-900">{{ $order->service->name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Perangkat</span><span class="text-gray-900">{{ $order->device_description }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Pengiriman</span><span class="text-gray-900">{{ $order->shipmentOption?->name ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Pembayaran</span><span class="text-gray-900">{{ $order->paymentMethod?->name ?? '-' }}</span></div>
                <div class="border-t border-red-600/10 pt-3 flex justify-between font-black text-base"><span class="text-gray-900">Total</span><span class="text-gradient">Rp {{ number_format($order->total_price,0,',','.') }}</span></div>
            </div>
        </div>

        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-3"><i class="fas fa-file-alt"></i> Deskripsi Kerusakan</h3>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $order->problem_description }}</p>
        </div>

        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-user text-red-600"></i> Data Pelanggan</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Nama</span><span class="text-gray-900">{{ $order->customer_name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Email</span><span class="text-gray-900">{{ $order->customer_email }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Telepon</span><span class="text-gray-900">{{ $order->customer_phone }}</span></div>
                @if($order->customer_address)<div class="flex justify-between"><span class="text-gray-600">Alamat</span><span class="text-gray-900">{{ $order->customer_address }}</span></div>@endif
            </div>
        </div>
    </div>

    <!-- Update Status -->
    <div class="space-y-5">
        <div class="service-card p-6 rounded-2xl">
            @php $sb=$order->status_badge; $pb=$order->payment_badge; @endphp
            <div class="mb-4 space-y-2">
                <span class="badge badge-{{ $sb['color'] }} text-sm">{{ $sb['label'] }}</span>
                <span class="badge badge-{{ $pb['color'] }} text-sm">{{ $pb['label'] }}</span>
            </div>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Update Status</label>
                    <select name="status" class="form-input w-full px-3 py-2.5 rounded-xl text-sm">
                        @foreach(['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','in_progress'=>'Diproses','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ $order->status===$val?'selected':'' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Status Pembayaran</label>
                    <select name="payment_status" class="form-input w-full px-3 py-2.5 rounded-xl text-sm">
                        <option value="unpaid" {{ $order->payment_status==='unpaid'?'selected':'' }}>Belum Dibayar</option>
                        <option value="paid" {{ $order->payment_status==='paid'?'selected':'' }}>Sudah Dibayar</option>
                        <option value="refunded" {{ $order->payment_status==='refunded'?'selected':'' }}>Refund</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Catatan Admin</label>
                    <textarea name="notes" rows="3" class="form-input w-full px-3 py-2.5 rounded-xl text-sm resize-none">{{ $order->notes }}</textarea>
                </div>
                <button type="submit" class="btn-primary w-full py-3 rounded-xl text-white text-sm font-semibold">Update Status</button>
            </form>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.orders.index') }}" class="btn-outline text-center py-3 rounded-xl text-red-600 text-sm font-semibold"><i class="fas fa-arrow-left"></i> Kembali</a>
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full py-3 rounded-xl bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 text-sm font-semibold transition-colors"><i class="fas fa-trash-alt text-red-400"></i> Hapus Pesanan</button>
            </form>
        </div>
    </div>
</div>
@endsection
