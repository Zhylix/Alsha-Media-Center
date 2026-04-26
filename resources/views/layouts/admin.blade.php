<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Alsha Media Center Admin</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'><i class="fas fa-cog"></i></text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased flex">

    <!-- Sidebar -->
    <aside id="sidebar" class="admin-sidebar fixed top-0 left-0 h-full w-64 z-50 flex flex-col transition-all duration-300 overflow-y-auto">
        <!-- Logo -->
        <div class="p-6 border-b border-red-500/20">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                @php $globalStore = \App\Models\StoreProfile::first(); @endphp
                @if($globalStore && $globalStore->logo)
                <img src="{{ asset('storage/' . $globalStore->logo) }}" alt="Logo" class="w-10 h-10 object-contain rounded-xl bg-white p-1">
                @else
                <div class="w-10 h-10 rounded-xl gradient-anim flex items-center justify-center text-xl text-gray-900"><i class="fas fa-cog"></i></div>
                @endif
                <div>
                    <p class="font-black text-gradient text-sm">Alsha Media Center</p>
                    <p class="text-xs text-gray-500">Admin Panel</p>
                </div>
            </a>
        </div>

        <!-- Admin Info -->
        <div class="px-4 py-4 border-b border-red-500/20">
            <div class="flex items-center gap-3 px-2">
                <div class="w-9 h-9 rounded-full gradient-anim flex items-center justify-center text-gray-900 text-sm font-bold">
                    {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ session('admin_name', 'Administrator') }}</p>
                    <p class="text-xs text-gray-500">Super Admin</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-4 space-y-1">
            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest px-3 mb-2">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="text-lg"><i class="fas fa-chart-bar text-gray-400"></i></span> Dashboard
            </a>

            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest px-3 mt-4 mb-2">Manajemen</p>

            <a href="{{ route('admin.services.index') }}" class="admin-nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <span class="text-lg"><i class="fas fa-tools text-red-500"></i></span> Layanan / Jasa
            </a>
            <a href="{{ route('admin.orders.index') }}" class="admin-nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span class="text-lg"><i class="fas fa-clipboard-list text-red-500"></i></span> Pesanan
                @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pendingCount > 0)
                <span class="ml-auto badge badge-red">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="admin-nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-red-600 {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <span class="text-lg"><i class="fas fa-star text-red-500"></i></span> Testimonial
            </a>

            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest px-3 mt-4 mb-2">Lainnya</p>

            <a href="{{ route('admin.contacts.index') }}" class="admin-nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <span class="text-lg"><i class="fas fa-envelope-open-text"></i></span> Pesan Masuk
                @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                @if($unreadCount > 0)
                <span class="ml-auto badge badge-red">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.store.index') }}" class="admin-nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 {{ request()->routeIs('admin.store.*') ? 'active' : '' }}">
                <span class="text-lg"><i class="fas fa-store"></i></span> Profil Toko
            </a>
            <a href="{{ route('home') }}" target="_blank" class="admin-nav-item flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900">
                <span class="text-lg"><i class="fas fa-globe"></i></span> Lihat Website
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-red-500/20">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all">
                    <span class="text-lg"><i class="fas fa-sign-out-alt"></i></span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Top Bar -->
        <header class="sticky top-0 z-40 glass border-b border-red-500/20 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-gray-500">@yield('page-subtitle', 'Selamat datang di panel admin Alsha Media Center')</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </header>

        <!-- Content Area -->
        <main class="p-6 min-h-screen">
            @if(session('success'))
            <div class="mb-6 flex items-center gap-3 px-5 py-4 bg-gray-500/10 border border-gray-500/30 rounded-2xl text-gray-600">
                <span class="text-xl"><i class="fas fa-check"></i></span>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 flex items-center gap-3 px-5 py-4 bg-red-500/10 border border-red-500/30 rounded-2xl text-red-400">
                <span class="text-xl"><i class="fas fa-times"></i></span>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
            @endif
            @if($errors->any())
            <div class="mb-6 flex items-start gap-3 px-5 py-4 bg-red-500/10 border border-red-500/30 rounded-2xl text-red-400">
                <span class="text-xl mt-0.5"><i class="fas fa-exclamation-triangle"></i></span>
                <ul class="text-sm font-medium space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
