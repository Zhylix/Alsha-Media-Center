@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data dan aktivitas terbaru')

@section('content')

{{-- ============================================================
     REVENUE BANNER — tampil hanya jika ada data revenue
============================================================ --}}
@if(isset($operational_stats['total_revenue']) && $operational_stats['total_revenue'] > 0)
<div class="revenue-banner">
    <div>
        <div class="rev-eyebrow">
            <i class="fas fa-coins" style="margin-right:5px;color:var(--red-300)"></i>Total Pendapatan
        </div>
        <div class="rev-amount">
            Rp {{ number_format($operational_stats['total_revenue'], 0, ',', '.') }}
        </div>
        <div class="rev-sub">Akumulasi seluruh pesanan selesai</div>
    </div>
    <div class="rev-right">
        @if(isset($operational_stats['total_orders']) && $operational_stats['total_orders'] > 0)
        <div>
            <div class="rev-mini-label">Total Order</div>
            <div class="rev-mini-val">{{ $operational_stats['total_orders'] }}</div>
        </div>
        <div class="rev-divider"></div>
        @endif
        @if(isset($operational_stats['completed_orders']) && $operational_stats['completed_orders'] > 0)
        <div>
            <div class="rev-mini-label">Selesai</div>
            <div class="rev-mini-val">{{ $operational_stats['completed_orders'] }}</div>
        </div>
        <div class="rev-divider"></div>
        @endif
        @if(isset($operational_stats['pending_orders']) && $operational_stats['pending_orders'] > 0)
        <div>
            <div class="rev-mini-label">Pending</div>
            <div class="rev-mini-val" style="color:var(--red-300);">{{ $operational_stats['pending_orders'] }}</div>
        </div>
        @endif
    </div>
</div>
@endif

{{-- ============================================================
     STATS CARDS
============================================================ --}}
@if($stats_items->isNotEmpty() || array_sum($operational_stats) > 0)
<div class="stats-grid">

    {{-- Custom stats dari model Stat --}}
    @foreach($stats_items as $stat)
    <div class="stat-card accent-red">
        <div class="stat-top">
            <div class="stat-icon">
                <i class="{{ $stat->icon }}"></i>
            </div>
            <span class="badge badge-gray">Custom</span>
        </div>
        <div class="stat-val">{{ $stat->value }}</div>
        <div class="stat-label">{{ $stat->label }}</div>
    </div>
    @endforeach

    {{-- Total Pesanan --}}
    @if(isset($operational_stats['total_orders']) && $operational_stats['total_orders'] > 0)
    <div class="stat-card accent-red">
        <div class="stat-top">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <span class="badge badge-gray">Total</span>
        </div>
        <div class="stat-val">{{ $operational_stats['total_orders'] }}</div>
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-trend trend-up">
            <i class="fas fa-arrow-up"></i>&nbsp;Semua waktu
        </div>
    </div>
    @endif

    {{-- Pesanan Pending --}}
    @if(isset($operational_stats['pending_orders']) && $operational_stats['pending_orders'] > 0)
    <div class="stat-card accent-red">
        <div class="stat-top">
            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
            <span class="badge badge-warn">Pending</span>
        </div>
        <div class="stat-val">{{ $operational_stats['pending_orders'] }}</div>
        <div class="stat-label">Pesanan Menunggu</div>
        <div class="stat-trend trend-warn">
            <i class="fas fa-exclamation-circle"></i>&nbsp;Butuh tindakan
        </div>
    </div>
    @endif

    {{-- Pesanan Selesai --}}
    @if(isset($operational_stats['completed_orders']) && $operational_stats['completed_orders'] > 0)
    <div class="stat-card accent-dark">
        <div class="stat-top">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <span class="badge badge-dark">Selesai</span>
        </div>
        <div class="stat-val">{{ $operational_stats['completed_orders'] }}</div>
        <div class="stat-label">Pesanan Selesai</div>
        @if(isset($operational_stats['total_orders']) && $operational_stats['total_orders'] > 0)
        @php
            $successRate = round(($operational_stats['completed_orders'] / $operational_stats['total_orders']) * 100, 1);
        @endphp
        <div class="stat-trend trend-up">
            <i class="fas fa-arrow-up"></i>&nbsp;{{ $successRate }}% tingkat sukses
        </div>
        @endif
    </div>
    @endif

    {{-- Layanan Aktif --}}
    @if(isset($operational_stats['total_services']) && $operational_stats['total_services'] > 0)
    <div class="stat-card accent-red">
        <div class="stat-top">
            <div class="stat-icon"><i class="fas fa-tools"></i></div>
            <span class="badge badge-dark">Aktif</span>
        </div>
        <div class="stat-val">{{ $operational_stats['total_services'] }}</div>
        <div class="stat-label">Layanan Aktif</div>
        <div class="stat-trend trend-up">
            <i class="fas fa-circle" style="font-size:6px;"></i>&nbsp;Tersedia untuk pelanggan
        </div>
    </div>
    @endif

    {{-- Pesan Belum Dibaca --}}
    @if(isset($operational_stats['unread_messages']) && $operational_stats['unread_messages'] > 0)
    <div class="stat-card accent-red">
        <div class="stat-top">
            <div class="stat-icon"><i class="fas fa-envelope-open-text"></i></div>
            <span class="badge badge-red">Baru</span>
        </div>
        <div class="stat-val">{{ $operational_stats['unread_messages'] }}</div>
        <div class="stat-label">Pesan Belum Dibaca</div>
        <div class="stat-trend trend-red">
            <i class="fas fa-circle" style="font-size:6px;"></i>&nbsp;Perlu dibalas
        </div>
    </div>
    @endif

</div>

@else
{{-- Empty State --}}
<div style="text-align:center;padding:52px 24px;background:#fff;border:2px dashed var(--gray-200);border-radius:16px;margin-bottom:24px;">
    <i class="fas fa-chart-bar" style="font-size:48px;color:var(--gray-300);margin-bottom:16px;display:block;"></i>
    <h3 style="font-size:18px;font-weight:800;color:var(--gray-900);margin-bottom:6px;">Belum Ada Data Statistik</h3>
    <p style="color:var(--gray-500);font-size:13px;max-width:400px;margin:0 auto 20px;">
        Tambahkan statistik melalui menu Statistik atau tunggu aktivitas bisnis untuk mengisi data operasional.
    </p>
    <a href="{{ route('admin.stats.index') }}"
       style="display:inline-flex;align-items:center;gap:8px;background:var(--red);color:#fff;padding:10px 22px;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;transition:background .15s;"
       onmouseover="this.style.background='var(--red-800)'"
       onmouseout="this.style.background='var(--red)'">
        <i class="fas fa-plus"></i> Kelola Statistik
    </a>
</div>
@endif

{{-- ============================================================
     QUICK ACTIONS
============================================================ --}}
<div class="section-header">
    <div class="section-title">Aksi Cepat</div>
</div>
<div class="quick-grid">
    <a href="{{ route('admin.orders.create') }}" class="quick-btn">
        <div class="quick-icon"><i class="fas fa-plus"></i></div>
        <span class="quick-label">Tambah Pesanan</span>
    </a>
    <a href="{{ route('admin.services.create') }}" class="quick-btn">
        <div class="quick-icon"><i class="fas fa-tools"></i></div>
        <span class="quick-label">Tambah Layanan</span>
    </a>
    <a href="{{ route('admin.service-tickets.index') }}" class="quick-btn">
        <div class="quick-icon"><i class="fas fa-wrench"></i></div>
        <span class="quick-label">Servis Masuk</span>
    </a>
</div>

{{-- ============================================================
     RECENT ORDERS + RECENT MESSAGES
============================================================ --}}
<div class="section-header">
    <div class="section-title">Aktivitas Terbaru</div>
</div>

<div class="bottom-grid">

    {{-- ── Recent Orders ───────────────────────── --}}
    <div class="card-wrap">
        <div class="card-head">
            <span class="card-head-title">
                <i class="fas fa-shopping-cart" style="color:var(--red);margin-right:7px;font-size:12px;"></i>
                Pesanan Terbaru
            </span>
            <a href="{{ route('admin.orders.index') }}" class="section-link">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                @php
                    $badge = $order->status_badge;
                    $colorMap = [
                        'pending'    => 'status-pending',
                        'confirmed'  => 'status-confirmed',
                        'processing' => 'status-processing',
                        'completed'  => 'status-completed',
                        'cancelled'  => 'status-cancelled',
                    ];
                    $statusClass = $colorMap[$badge['color']] ?? 'status-processing';
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="order-number">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td style="font-size:12.5px;color:var(--gray-700);">
                        {{ $order->customer_name }}
                    </td>
                    <td style="font-size:12px;color:var(--gray-500);">
                        {{ Str::limit($order->service->name, 22) }}
                    </td>
                    <td>
                        <span class="status-badge {{ $statusClass }}">
                            {{ $badge['label'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            Belum ada pesanan
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Recent Messages ─────────────────────── --}}
    <div class="card-wrap">
        <div class="card-head">
            <span class="card-head-title">
                <i class="fas fa-envelope-open-text" style="color:var(--red);margin-right:7px;font-size:12px;"></i>
                Pesan Terbaru
            </span>
            <a href="{{ route('admin.contacts.index') }}" class="section-link">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @forelse($recentMessages as $msg)
        <a href="{{ route('admin.contacts.show', $msg) }}" class="msg-item">
            <div class="msg-avatar {{ $msg->is_read ? 'muted' : '' }}">
                {{ strtoupper(substr($msg->name, 0, 2)) }}
            </div>
            <div class="msg-body">
                <div class="msg-top">
                    <span class="msg-name">
                        {{ Str::limit($msg->name, 16) }}
                        @if(!$msg->is_read)
                            <span class="new-pill">Baru</span>
                        @endif
                    </span>
                    <span class="msg-time">{{ $msg->created_at->diffForHumans() }}</span>
                </div>
                <div class="msg-subject">{{ Str::limit($msg->subject, 38) }}</div>
            </div>
            @if(!$msg->is_read)
                <div class="msg-unread-dot"></div>
            @endif
        </a>
        @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            Belum ada pesan masuk
        </div>
        @endforelse
    </div>

</div>
@endsection