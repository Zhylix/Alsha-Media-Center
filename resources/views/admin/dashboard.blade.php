@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data dan aktivitas terbaru')

@section('content')
<!-- Stats Cards -->
@if($stats_items->isNotEmpty() || array_sum($operational_stats) > 0)
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-10 lg:mb-12">
    {{-- Dynamic Stats from Stat model --}}
    @foreach($stats_items as $stat)
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="{{ $stat->icon }} text-red-600"></i></div>
            <span class="badge badge-gray">Custom</span>
        </div>
        <p class="text-3xl font-black text-gray-900">{{ $stat->value }}</p>
        <p class="text-gray-600 text-sm mt-1">{{ $stat->label }}</p>
    </div>
    @endforeach
    
    {{-- Operational stats (always show if data exists) --}}
    @if(isset($operational_stats['total_orders']) && $operational_stats['total_orders'] > 0)
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-clipboard-list text-red-600"></i></div>
            <span class="badge badge-gray">Total</span>
        </div>
        <p class="text-3xl font-black text-gray-900">{{ $operational_stats['total_orders'] }}</p>
        <p class="text-gray-600 text-sm mt-1">Total Pesanan</p>
    </div>
    @endif
    
    @if(isset($operational_stats['pending_orders']) && $operational_stats['pending_orders'] > 0)
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-hourglass-half text-red-600"></i></div>
            <span class="badge badge-red">Pending</span>
        </div>
        <p class="text-3xl font-black text-gray-900">{{ $operational_stats['pending_orders'] }}</p>
        <p class="text-gray-600 text-sm mt-1">Pesanan Menunggu</p>
    </div>
    @endif
    
    @if(isset($operational_stats['completed_orders']) && $operational_stats['completed_orders'] > 0)
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-check text-red-600"></i></div>
            <span class="badge badge-gray">Selesai</span>
        </div>
        <p class="text-3xl font-black text-gray-900">{{ $operational_stats['completed_orders'] }}</p>
        <p class="text-gray-600 text-sm mt-1">Pesanan Selesai</p>
    </div>
    @endif
    
    @if(isset($operational_stats['total_services']) && $operational_stats['total_services'] > 0)
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-tools text-red-600"></i></div>
            <span class="badge badge-dark">Aktif</span>
        </div>
        <p class="text-3xl font-black text-gray-900">{{ $operational_stats['total_services'] }}</p>
        <p class="text-gray-600 text-sm mt-1">Layanan Aktif</p>
    </div>
    @endif
    
    @if(isset($operational_stats['unread_messages']) && $operational_stats['unread_messages'] > 0)
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-envelope-open-text text-red-600"></i></div>
            <span class="badge badge-red">Baru</span>
        </div>
        <p class="text-3xl font-black text-gray-900">{{ $operational_stats['unread_messages'] }}</p>
        <p class="text-gray-600 text-sm mt-1">Pesan Belum Dibaca</p>
    </div>
    @endif
    
    @if(isset($operational_stats['total_revenue']) && $operational_stats['total_revenue'] > 0)
    <div class="service-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="text-3xl"><i class="fas fa-coins text-red-600"></i></div>
            <span class="badge badge-red">Revenue</span>
        </div>
        <p class="text-xl font-black text-gray-900">Rp {{ number_format($operational_stats['total_revenue'], 0, ',', '.') }}</p>
        <p class="text-gray-600 text-sm mt-1">Total Pendapatan</p>
    </div>
    @endif
</div>

@else
<div class="text-center py-16 bg-white border-2 border-dashed border-gray-200 rounded-3xl mb-8">
    <i class="fas fa-chart-bar text-6xl text-gray-300 mb-6"></i>
    <h3 class="text-2xl font-black text-gray-900 mb-2">Belum Ada Data Statistik</h3>
    <p class="text-gray-600 mb-6 max-w-md mx-auto">Tambahkan statistik melalui menu Statistik atau tunggu aktivitas bisnis untuk mengisi data operasional.</p>
    <a href="{{ route('admin.stats.index') }}" class="btn-primary px-8 py-3 text-sm font-black">
        <i class="fas fa-plus mr-2"></i>Kelola Statistik
    </a>
</div>
@endif

<!-- Recent Orders & Messages -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 md:gap-8">
    <!-- Recent Orders -->
    <div class="service-card rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-red-600/10">
            <h3 class="font-bold text-gray-900">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-red-600 text-sm hover:text-gray-900 transition-colors">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr>
                    <th data-label="Order #">Order #</th>
                    <th data-label="Pelanggan">Pelanggan</th>
                    <th data-label="Layanan">Layanan</th>
                    <th data-label="Status">Status</th>
                </tr></thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    @php $badge = $order->status_badge; @endphp
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="text-red-600 hover:text-gray-900 text-xs font-mono">{{ $order->order_number }}</a></td>
                        <td class="text-gray-700 text-sm">{{ $order->customer_name }}</td>
                        <td class="text-gray-600 text-xs">{{ Str::limit($order->service->name, 25) }}</td>
                        <td><span class="badge badge-{{ $badge['color'] }}">{{ $badge['label'] }}</span></td>
                    </tr>
                    @endforeach
                    @if($recentOrders->isEmpty())
                    <tr><td colspan="4" class="text-center text-gray-500 py-6 text-sm">Belum ada pesanan</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Messages -->   
    <div class="service-card rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-red-600/10">
            <h3 class="font-bold text-gray-900">Pesan Terbaru</h3>
            <a href="{{ route('admin.contacts.index') }}" class="text-red-600 text-sm hover:text-gray-900 transition-colors">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="divide-y divide-gray-100/50 [&>a]:py-4 [&>a]:px-6 [&>a:hover]:rounded-xl [&>a:hover]:bg-gray-50/50">
            @foreach($recentMessages as $msg)
            <a href="{{ route('admin.contacts.show', $msg) }}" class="block px-6 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between gap-2 mb-1">
                    <p class="text-gray-900 text-sm font-semibold truncate flex-1">{{ Str::limit($msg->name, 18) }}</p>
                    @if(!$msg->is_read)
                        <span class="w-2 h-2 bg-red-600 rounded-full flex-shrink-0"></span>
                    @endif
                </div>
                <p class="text-gray-600 text-xs truncate mb-1">{{ Str::limit($msg->subject, 32) }}</p>
                <div class="flex items-center justify-between gap-2">
                    <p class="text-gray-500 text-xs">{{ $msg->created_at->diffForHumans() }}</p>
                    @if(!$msg->is_read)<span class="badge badge-red text-xs px-2 py-0.5">Baru</span>@endif
                </div>
            </a>
            @endforeach
            @if($recentMessages->isEmpty())
            <div class="px-6 py-6 text-center text-gray-500 text-sm">Belum ada pesan</div>
            @endif
        </div>
    </div>
</div>
@endsection