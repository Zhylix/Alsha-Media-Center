@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data dan aktivitas terbaru')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-clipboard-list text-yellow-400"></i></div>
            <span class="badge badge-blue">Total</span>
        </div>
        <p class="text-3xl font-black text-white">{{ $stats['total_orders'] }}</p>
        <p class="text-slate-400 text-sm mt-1">Total Pesanan</p>
    </div>
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-hourglass-half text-yellow-400"></i></div>
            <span class="badge badge-yellow">Pending</span>
        </div>
        <p class="text-3xl font-black text-white">{{ $stats['pending_orders'] }}</p>
        <p class="text-slate-400 text-sm mt-1">Pesanan Menunggu</p>
    </div>
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-check text-green-500"></i></div>
            <span class="badge badge-green">Selesai</span>
        </div>
        <p class="text-3xl font-black text-white">{{ $stats['completed_orders'] }}</p>
        <p class="text-slate-400 text-sm mt-1">Pesanan Selesai</p>
    </div>
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-tools text-orange-400"></i></div>
            <span class="badge badge-purple">Aktif</span>
        </div>
        <p class="text-3xl font-black text-white">{{ $stats['total_services'] }}</p>
        <p class="text-slate-400 text-sm mt-1">Layanan Aktif</p>
    </div>
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-envelope-open-text"></i></div>
            <span class="badge badge-red">Baru</span>
        </div>
        <p class="text-3xl font-black text-white">{{ $stats['unread_messages'] }}</p>
        <p class="text-slate-400 text-sm mt-1">Pesan Belum Dibaca</p>
    </div>
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-coins text-yellow-400"></i></div>
            <span class="badge badge-green">Revenue</span>
        </div>
        <p class="text-xl font-black text-white">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        <p class="text-slate-400 text-sm mt-1">Total Pendapatan</p>
    </div>
</div>

<!-- Recent Orders & Messages -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="service-card rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-blue-500/10">
            <h3 class="font-bold text-white">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-400 text-sm hover:text-white transition-colors">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Order #</th><th>Pelanggan</th><th>Layanan</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    @php $badge = $order->status_badge; @endphp
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="text-blue-400 hover:text-white text-xs font-mono">{{ $order->order_number }}</a></td>
                        <td class="text-slate-300 text-sm">{{ $order->customer_name }}</td>
                        <td class="text-slate-400 text-xs">{{ Str::limit($order->service->name, 25) }}</td>
                        <td><span class="badge badge-{{ $badge['color'] }}">{{ $badge['label'] }}</span></td>
                    </tr>
                    @endforeach
                    @if($recentOrders->isEmpty())
                    <tr><td colspan="4" class="text-center text-slate-500 py-6 text-sm">Belum ada pesanan</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="service-card rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-blue-500/10">
            <h3 class="font-bold text-white">Pesan Terbaru</h3>
            <a href="{{ route('admin.contacts.index') }}" class="text-blue-400 text-sm hover:text-white transition-colors">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="divide-y divide-blue-500/5">
            @foreach($recentMessages as $msg)
            <a href="{{ route('admin.contacts.show', $msg) }}" class="block px-6 py-4 hover:bg-white/5 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate">{{ $msg->name }} @if(!$msg->is_read)<span class="w-2 h-2 bg-blue-400 rounded-full inline-block ml-2"></span>@endif</p>
                        <p class="text-slate-400 text-xs truncate">{{ $msg->subject }}</p>
                        <p class="text-slate-500 text-xs">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @if(!$msg->is_read)<span class="badge badge-blue text-xs flex-shrink-0">Baru</span>@endif
                </div>
            </a>
            @endforeach
            @if($recentMessages->isEmpty())
            <div class="px-6 py-6 text-center text-slate-500 text-sm">Belum ada pesan</div>
            @endif
        </div>
    </div>
</div>
@endsection
