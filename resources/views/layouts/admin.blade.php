<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Alsha Media Center Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* =============================================
           ALSHA MEDIA CENTER — ADMIN DESIGN SYSTEM
           Palette: Merah (#DC2626) + Putih + Netral
        ============================================= */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --red:       #DC2626;
            --red-50:    #FFF5F5;
            --red-100:   #FEE2E2;
            --red-200:   #FECACA;
            --red-300:   #FCA5A5;
            --red-700:   #B91C1C;
            --red-800:   #991B1B;
            --red-900:   #7F1D1D;
            --white:     #FFFFFF;
            --gray-50:   #F9FAFB;
            --gray-100:  #F3F4F6;
            --gray-200:  #E5E7EB;
            --gray-300:  #D1D5DB;
            --gray-400:  #9CA3AF;
            --gray-500:  #6B7280;
            --gray-600:  #4B5563;
            --gray-700:  #374151;
            --gray-900:  #111827;
            --sidebar-w: 220px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F4F4F5;
            color: var(--gray-900);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        /* ── SIDEBAR ──────────────────────────────── */
        .admin-sidebar {
            width: var(--sidebar-w);
            background: var(--gray-900);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 50;
            transition: transform 0.15s ease;
        }

        .sidebar-logo {
            padding: 20px 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-logo a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .logo-icon {
            width: 36px; height: 36px;
            background: var(--red);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 15px;
            flex-shrink: 0;
        }
        .logo-text {
            font-size: 12.5px; font-weight: 800;
            color: #fff; line-height: 1.2;
        }
        .logo-sub {
            font-size: 10px;
            color: rgba(255,255,255,0.35);
            font-weight: 500; margin-top: 1px;
        }

        .sidebar-admin {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex; align-items: center; gap: 10px;
        }
        .admin-avatar {
            width: 34px; height: 34px;
            background: var(--red);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 13px;
            flex-shrink: 0;
        }
        .admin-name { font-size: 12px; font-weight: 700; color: #fff; }
        .admin-role { font-size: 10px; color: rgba(255,255,255,0.35); }

        .sidebar-nav { flex: 1; padding: 14px 10px; overflow-y: auto; }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 3px; }

        .nav-section-label {
            font-size: 9px; font-weight: 700;
            color: rgba(255,255,255,0.22);
            letter-spacing: .12em; text-transform: uppercase;
            padding: 0 8px; margin: 12px 0 4px;
            display: block;
        }

        .admin-nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: 8px;
            color: rgba(255,255,255,0.5);
            font-size: 12.5px; font-weight: 600;
            text-decoration: none;
            transition: all .15s;
            margin-bottom: 1px;
        }
        .admin-nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.85);
        }
        .admin-nav-item.active {
            background: var(--red);
            color: #fff;
        }
        .admin-nav-item i { width: 16px; text-align: center; font-size: 13px; opacity: .75; }
        .admin-nav-item.active i { opacity: 1; }

        .nav-badge {
            margin-left: auto;
            background: var(--red);
            color: #fff;
            font-size: 9px; font-weight: 800;
            padding: 2px 6px; border-radius: 20px;
            min-width: 18px; text-align: center;
        }
        .admin-nav-item.active .nav-badge { background: rgba(255,255,255,0.2); }

        .sidebar-footer {
            padding: 12px 10px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        /* ── SIDEBAR OVERLAY (mobile) ─────────────── */
        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 40;
            opacity: 0; pointer-events: none;
            transition: opacity .15s;
        }
        .sidebar-overlay.sidebar-overlay-open {
            opacity: 1; pointer-events: all;
        }

        /* ── HAMBURGER ────────────────────────────── */
        .hamburger {
            display: flex; flex-direction: column;
            gap: 5px; cursor: pointer; padding: 4px;
        }
        .hamburger span {
            display: block; width: 22px; height: 2px;
            background: var(--gray-700);
            border-radius: 2px;
            transition: all .2s;
        }
        .hamburger.hamburger-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.hamburger-open span:nth-child(2) { opacity: 0; }
        .hamburger.hamburger-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ── MAIN AREA ────────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1; display: flex; flex-direction: column;
            min-height: 100vh;
            transition: margin .15s;
        }

        /* ── TOPBAR ───────────────────────────────── */
        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            padding: 0 28px;
            height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 30;
        }
        .topbar-title { font-size: 17px; font-weight: 800; color: var(--gray-900); }
        .topbar-sub { font-size: 11px; color: var(--gray-500); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-date {
            font-size: 11px; color: var(--gray-500);
            background: var(--gray-100);
            padding: 5px 11px; border-radius: 20px; font-weight: 600;
        }
        .topbar-notif {
            width: 34px; height: 34px;
            background: var(--red-100);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--red); font-size: 14px;
            cursor: pointer; position: relative;
        }
        .notif-dot {
            position: absolute; top: 7px; right: 7px;
            width: 6px; height: 6px;
            background: var(--red); border-radius: 50%;
            border: 1.5px solid #fff;
        }

        /* ── FLASH ALERTS ─────────────────────────── */
        .alert {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 18px; border-radius: 12px;
            margin-bottom: 18px; font-size: 13px; font-weight: 600;
        }
        .alert-success {
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            color: var(--gray-700);
        }
        .alert-error {
            background: var(--red-100);
            border: 1px solid var(--red-200);
            color: var(--red-800);
        }
        .alert i { margin-top: 1px; font-size: 15px; flex-shrink: 0; }

        /* ── LOGOUT BUTTON ────────────────────────── */
        .btn-logout {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 8px 10px; border-radius: 8px;
            background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,0.35);
            font-size: 12px; font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .15s;
        }
        .btn-logout:hover { background: rgba(220,38,38,0.15); color: #F87171; }

        /* ── CONTENT PADDING ──────────────────────── */
        .admin-content { padding: 24px 28px; flex: 1; }

        /* ──────────────────────────────────────────────
           DASHBOARD SPECIFIC COMPONENTS
        ────────────────────────────────────────────── */

        /* Revenue Banner */
        .revenue-banner {
            background: var(--gray-900);
            border-radius: 14px;
            padding: 22px 24px;
            margin-bottom: 20px;
            display: flex; align-items: center; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .revenue-banner::after {
            content: '';
            position: absolute; right: -30px; top: -30px;
            width: 140px; height: 140px;
            background: rgba(220,38,38,0.12); border-radius: 50%;
        }
        .revenue-banner::before {
            content: '';
            position: absolute; right: 40px; bottom: -55px;
            width: 110px; height: 110px;
            background: rgba(220,38,38,0.07); border-radius: 50%;
        }
        .rev-eyebrow {
            font-size: 10px; font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase; letter-spacing: .1em;
            margin-bottom: 6px;
        }
        .rev-amount {
            font-size: 30px; font-weight: 800;
            color: #fff; letter-spacing: -.03em; line-height: 1;
        }
        .rev-sub { font-size: 11px; color: rgba(255,255,255,0.35); margin-top: 6px; }
        .rev-right { display: flex; gap: 24px; position: relative; z-index: 1; }
        .rev-divider { width: 1px; background: rgba(255,255,255,0.08); }
        .rev-mini-label { font-size: 10px; color: rgba(255,255,255,0.35); margin-bottom: 4px; font-weight: 600; }
        .rev-mini-val { font-size: 18px; font-weight: 800; color: #fff; }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }
        @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px)  { .stats-grid { grid-template-columns: 1fr; } }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            border: 1px solid var(--gray-200);
            position: relative; overflow: hidden;
            transition: box-shadow .15s;
        }
        .stat-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,0.06); }
        .stat-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: var(--gray-200);
        }
        .stat-card.accent-red::before { background: var(--red); }
        .stat-card.accent-dark::before { background: var(--gray-900); }

        .stat-top {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 14px;
        }
        .stat-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--red-100); color: var(--red);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
        }

        /* Badges — only red/white/gray */
        .badge {
            display: inline-flex;
            padding: 3px 9px; border-radius: 20px;
            font-size: 10px; font-weight: 700;
            letter-spacing: .04em; text-transform: uppercase;
        }
        .badge-gray    { background: var(--gray-100); color: var(--gray-500); }
        .badge-red     { background: var(--red-100);  color: var(--red-800); }
        .badge-dark    { background: var(--gray-900); color: #fff; }
        .badge-warn    { background: #FEF3C7;          color: #92400E; }

        /* Status badges for order table */
        .status-badge {
            display: inline-flex;
            padding: 3px 10px; border-radius: 20px;
            font-size: 10px; font-weight: 700; letter-spacing: .03em;
        }
        .status-pending    { background: #FEF3C7;         color: #92400E; }
        .status-confirmed  { background: var(--red-100);  color: var(--red-800); }
        .status-processing { background: var(--gray-100); color: var(--gray-700); }
        .status-completed  { background: var(--gray-900); color: #fff; }
        .status-cancelled  { background: var(--red-100);  color: var(--red-900); }

        .stat-val {
            font-size: 28px; font-weight: 800;
            color: var(--gray-900); line-height: 1;
            letter-spacing: -.02em;
        }
        .stat-val.small { font-size: 18px; }
        .stat-label { font-size: 11.5px; color: var(--gray-500); margin-top: 4px; font-weight: 500; }
        .stat-trend { display: flex; align-items: center; gap: 4px; margin-top: 10px; font-size: 11px; font-weight: 600; }
        .trend-up   { color: #059669; }
        .trend-warn { color: #D97706; }
        .trend-red  { color: var(--red); }

        /* Quick Actions */
        .quick-grid {
            display: grid; grid-template-columns: repeat(4,1fr);
            gap: 10px; margin-bottom: 20px;
        }
        @media (max-width: 900px) { .quick-grid { grid-template-columns: repeat(2,1fr); } }

        .quick-btn {
            background: #fff; border: 1px solid var(--gray-200);
            border-radius: 12px; padding: 14px 10px;
            display: flex; flex-direction: column;
            align-items: center; gap: 7px;
            cursor: pointer; text-decoration: none;
            transition: all .15s;
        }
        .quick-btn:hover { border-color: var(--red-300); background: var(--red-50); }
        .quick-btn:hover .quick-icon { background: var(--red); color: #fff; }
        .quick-btn:hover .quick-label { color: var(--red); }
        .quick-icon {
            width: 36px; height: 36px; background: var(--gray-100);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: var(--gray-600);
            transition: all .15s;
        }
        .quick-label { font-size: 11px; font-weight: 700; color: var(--gray-600); text-align: center; }

        /* Section headers */
        .section-header {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 12px;
        }
        .section-title { font-size: 14px; font-weight: 800; color: var(--gray-900); }
        .section-link {
            font-size: 11.5px; font-weight: 700; color: var(--red);
            text-decoration: none; display: flex; align-items: center; gap: 5px;
        }
        .section-link:hover { color: var(--red-800); }

        /* Bottom Grid */
        .bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media (max-width: 1024px) { .bottom-grid { grid-template-columns: 1fr; } }

        .card-wrap {
            background: #fff; border-radius: 14px;
            border: 1px solid var(--gray-200); overflow: hidden;
        }
        .card-head {
            padding: 14px 18px; border-bottom: 1px solid var(--gray-100);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-head-title { font-size: 13px; font-weight: 800; color: var(--gray-900); }

        /* Table */
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table thead tr { background: var(--gray-50); }
        .admin-table th {
            padding: 8px 14px; text-align: left;
            font-size: 10px; font-weight: 700;
            color: var(--gray-400); text-transform: uppercase;
            letter-spacing: .07em; white-space: nowrap;
        }
        .admin-table td {
            padding: 10px 14px; font-size: 12.5px;
            color: var(--gray-700); border-top: 1px solid var(--gray-100);
        }
        .admin-table tr:hover td { background: var(--gray-50); }

        .order-number {
            color: var(--red);
            font-family: 'DM Mono', monospace;
            font-size: 11px; font-weight: 500; text-decoration: none;
        }
        .order-number:hover { color: var(--red-800); }

        /* Messages List */
        .msg-item {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 12px 18px; border-top: 1px solid var(--gray-100);
            cursor: pointer; transition: background .12s; text-decoration: none;
        }
        .msg-item:hover { background: var(--red-50); }
        .msg-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--red-100); color: var(--red);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 11px; flex-shrink: 0;
        }
        .msg-avatar.muted { background: var(--gray-100); color: var(--gray-500); }
        .msg-body { flex: 1; min-width: 0; }
        .msg-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2px; }
        .msg-name { font-size: 12.5px; font-weight: 700; color: var(--gray-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px; }
        .msg-time { font-size: 10px; color: var(--gray-400); flex-shrink: 0; }
        .msg-subject { font-size: 11.5px; color: var(--gray-500); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .msg-unread-dot { width: 7px; height: 7px; background: var(--red); border-radius: 50%; margin-top: 5px; flex-shrink: 0; }
        .new-pill {
            display: inline-block; background: var(--red); color: #fff;
            font-size: 9px; font-weight: 700;
            padding: 1px 6px; border-radius: 20px;
            margin-left: 5px; vertical-align: middle;
        }

        /* Empty state */
        .empty-state {
            padding: 40px 20px; text-align: center; color: var(--gray-400);
            font-size: 13px;
        }
        .empty-state i { font-size: 28px; margin-bottom: 8px; display: block; }

        /* Responsive */
        @media (max-width: 1024px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.translate-x-0 { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .admin-content { padding: 18px; }
            .revenue-banner { flex-direction: column; gap: 16px; }
            .rev-right { width: 100%; justify-content: space-between; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside id="sidebar" class="admin-sidebar">
        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}">
                @php $globalStore = \App\Models\StoreProfile::first(); @endphp
                @if($globalStore && $globalStore->logo)
                    <img src="{{ asset('storage/' . $globalStore->logo) }}" alt="Logo" style="width:36px;height:36px;object-fit:contain;border-radius:10px;background:#fff;padding:4px;flex-shrink:0;">
                @else
                    <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                @endif
                <div>
                    <div class="logo-text">Alsha Media Center</div>
                    <div class="logo-sub">Admin Panel</div>
                </div>
            </a>
        </div>

        <!-- Admin Info -->
        <div class="sidebar-admin">
            <div class="admin-avatar">
                {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
            </div>
            <div>
                <div class="admin-name">{{ session('admin_name', 'Administrator') }}</div>
                <div class="admin-role">{{ session('admin_role') == 'superadmin' ? 'Super Admin' : 'Admin' }}</div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <span class="nav-section-label">Menu Utama</span>

            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Dashboard
            </a>

            <span class="nav-section-label">Manajemen</span>

            <a href="{{ route('admin.services.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.services.*') && !request()->routeIs('admin.service-tickets.*') ? 'active' : '' }}">
                <i class="fas fa-tools"></i> Layanan / Jasa
            </a>

            <a href="{{ route('admin.service-tickets.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.service-tickets.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Servis Masuk
                @php $pendingTicketCount = \App\Models\ServiceTicket::where('status','pending')->count(); @endphp
                @if($pendingTicketCount > 0)
                    <span class="nav-badge">{{ $pendingTicketCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.spareparts.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.spareparts.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Sparepart
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Pesanan
                @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.promos.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Promo
            </a>

            <a href="{{ route('admin.testimonials.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Testimonial
            </a>

            <a href="{{ route('admin.stats.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Statistik
            </a>

            <span class="nav-section-label">Lainnya</span>

            <a href="{{ route('admin.contacts.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text"></i> Pesan Masuk
                @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                @if($unreadCount > 0)
                    <span class="nav-badge">{{ $unreadCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.store.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.store.*') ? 'active' : '' }}">
                <i class="fas fa-store"></i> Profil Toko
            </a>

            @if(session('admin_role') == 'superadmin')
            <a href="{{ route('admin.admins.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Kelola Admin
            </a>
            @endif

            <a href="{{ route('home') }}" target="_blank" class="admin-nav-item">
                <i class="fas fa-globe"></i> Lihat Website
            </a>
        </nav>

        <!-- Logout -->
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div style="display:flex;align-items:center;gap:16px;">
                <div id="hamburger" class="hamburger" style="display:none;">
                    <span></span><span></span><span></span>
                </div>
                <div>
                    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                    <div class="topbar-sub">@yield('page-subtitle', 'Selamat datang di panel admin Alsha Media Center')</div>
                </div>
            </div>
            <div class="topbar-right">
                <span class="topbar-date">
                    <i class="fas fa-calendar-alt" style="margin-right:5px;color:var(--red)"></i>
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
                @php $totalUnread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                <a href="{{ route('admin.contacts.index') }}" class="topbar-notif" style="text-decoration:none;">
                    <i class="fas fa-bell"></i>
                    @if($totalUnread > 0)<div class="notif-dot"></div>@endif
                </a>
            </div>
        </header>

        <!-- Content -->
        <main class="admin-content">

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-times-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle" style="margin-top:1px;flex-shrink:0;"></i>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:2px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar  = document.getElementById('sidebar');
        const overlay  = document.getElementById('sidebar-overlay');
        const hamburger = document.getElementById('hamburger');

        function isMobile() { return window.innerWidth < 1025; }

        // Show hamburger on mobile
        function toggleHamburgerVisibility() {
            hamburger.style.display = isMobile() ? 'flex' : 'none';
        }
        toggleHamburgerVisibility();
        window.addEventListener('resize', toggleHamburgerVisibility);

        function openSidebar() {
            sidebar.classList.add('translate-x-0');
            overlay.classList.add('sidebar-overlay-open');
            hamburger.classList.add('hamburger-open');
        }
        function closeSidebar() {
            sidebar.classList.remove('translate-x-0');
            overlay.classList.remove('sidebar-overlay-open');
            hamburger.classList.remove('hamburger-open');
        }

        hamburger.addEventListener('click', function () {
            sidebar.classList.contains('translate-x-0') ? closeSidebar() : openSidebar();
        });
        overlay.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeSidebar();
        });
    });
    </script>

    @stack('scripts')
</body>
</html>