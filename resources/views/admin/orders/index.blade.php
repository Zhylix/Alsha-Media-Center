@extends('layouts.admin')
@section('title','Kelola Pesanan')
@section('page-title','Kelola Pesanan')
@section('page-subtitle','Manajemen semua pesanan service')

@section('content')
<!-- Filters -->
<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/order..." class="form-input px-4 py-2.5 rounded-xl text-sm w-56">
    <select name="status" class="form-input px-4 py-2.5 rounded-xl text-sm">
        <option value="">Semua Status</option>
        @foreach(['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','in_progress'=>'Diproses','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $val=>$lbl)
        <option value="{{ $val }}" {{ request('status')===$val?'selected':'' }}>{{ $lbl }}</option>
        @endforeach
    </select>
    <select name="payment_status" class="form-input px-4 py-2.5 rounded-xl text-sm">
        <option value="">Semua Pembayaran</option>
        <option value="unpaid" {{ request('payment_status')==='unpaid'?'selected':'' }}>Belum Bayar</option>
        <option value="paid" {{ request('payment_status')==='paid'?'selected':'' }}>Sudah Bayar</option>
    </select>
    <button type="submit" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-semibold">Filter</button>
    @if(request()->hasAny(['search','status','payment_status']))
    <a href="{{ route('admin.orders.index') }}" class="btn-outline px-5 py-2.5 rounded-xl text-red-600 text-sm font-semibold">Reset</a>
    @endif
</form>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr><th>Order #</th><th>Pelanggan</th><th>Layanan</th><th>Total</th><th>Status</th><th>Bayar</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($orders as $order)
                @php $sb=$order->status_badge; $pb=$order->payment_badge; @endphp
                <tr>
                    <td class="text-red-600 font-mono text-xs">{{ $order->order_number }}</td>
                    <td>
                        <p class="text-gray-900 text-sm font-medium">{{ $order->customer_name }}</p>
                        <p class="text-gray-500 text-xs">{{ $order->customer_phone }}</p>
                    </td>
                    <td class="text-gray-700 text-xs">{{ Str::limit($order->service->name,30) }}</td>
                    <td class="text-gray-900 font-semibold text-sm">Rp {{ number_format($order->total_price,0,',','.') }}</td>
                    <td><span class="badge badge-{{ $sb['color'] }}">{{ $sb['label'] }}</span></td>
                    <td><span class="badge badge-{{ $pb['color'] }}">{{ $pb['label'] }}</span></td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 rounded-lg bg-red-600/10 text-red-600 hover:bg-red-600/20 text-xs font-medium transition-colors">Detail</a>
                    </td>
                </tr>
                @endforeach
                @if($orders->isEmpty())
                <tr><td colspan="7" class="text-center text-gray-500 py-10">Belum ada pesanan</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">{{ $orders->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
