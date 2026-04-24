<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDesc ?? 'Alsha Media Center – Jasa service laptop, printer, dan handphone terpercaya di Bandung. Teknisi berpengalaman, spare part original, garansi resmi.' }}">
    <meta name="keywords" content="service laptop bandung, service printer bandung, service hp bandung, alsha media center">
    <title>@yield('title', 'Alsha Media Center') | Jasa Service Laptop, Printer & HP</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'><i class="fas fa-wrench text-orange-400"></i></text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @stack('styles')
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">

    <!-- NAVBAR -->
    <nav id="navbar" class="navbar-bg fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl gradient-anim flex items-center justify-center text-xl font-black text-white shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-wrench text-orange-400"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-gradient">Alsha</span><span class="text-lg font-black text-white"> Media Center</span>
                        <p class="text-[10px] text-slate-400 leading-none">Service Center Bandung</p>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('home') ? 'active text-blue-400' : '' }}">Beranda</a>
                    <a href="{{ route('about') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('about') ? 'active text-blue-400' : '' }}">Tentang Kami</a>

                    <!-- Services Dropdown -->
                    <div class="relative group">
                        <button class="nav-link-item px-4 py-2 text-sm font-medium text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all flex items-center gap-1 {{ request()->routeIs('services.*') ? 'active text-blue-400' : '' }}">
                            Layanan <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full left-0 mt-2 w-52 glass rounded-2xl p-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 shadow-2xl border border-blue-500/10">
                            <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-500/10 text-slate-300 hover:text-white text-sm transition-all"><i class="fas fa-tools text-orange-400"></i> Semua Layanan</a>
                            <a href="{{ route('services.laptop') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-500/10 text-slate-300 hover:text-white text-sm transition-all"><i class="fas fa-laptop text-blue-400"></i> Service Laptop</a>
                            <a href="{{ route('services.printer') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-500/10 text-slate-300 hover:text-white text-sm transition-all"><i class="fas fa-print text-purple-400"></i> Service Printer</a>
                            <a href="{{ route('services.hp') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-500/10 text-slate-300 hover:text-white text-sm transition-all"><i class="fas fa-mobile-alt text-green-400"></i> Service HP</a>
                        </div>
                    </div>

                    <a href="{{ route('shipment') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('shipment') ? 'active text-blue-400' : '' }}">Pengiriman</a>
                    <a href="{{ route('payment') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('payment') ? 'active text-blue-400' : '' }}">Pembayaran</a>
                    <a href="{{ route('contact') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('contact') ? 'active text-blue-400' : '' }}">Kontak</a>
                </div>

                <!-- CTA + Mobile Toggle -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('order.create') }}" class="hidden sm:flex btn-primary items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Pesan Sekarang
                    </a>
                    <button id="mobileBtn" class="md:hidden p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden glass border-t border-blue-500/10">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all"><i class="fas fa-home text-blue-400"></i> Beranda</a>
                <a href="{{ route('about') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all"><i class="fas fa-building text-blue-300"></i> Tentang Kami</a>
                <a href="{{ route('services.index') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all"><i class="fas fa-tools text-orange-400"></i> Semua Layanan</a>
                <a href="{{ route('services.laptop') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all pl-8"><i class="fas fa-laptop text-blue-400"></i> Service Laptop</a>
                <a href="{{ route('services.printer') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all pl-8"><i class="fas fa-print text-purple-400"></i> Service Printer</a>
                <a href="{{ route('services.hp') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all pl-8"><i class="fas fa-mobile-alt text-green-400"></i> Service HP</a>
                <a href="{{ route('shipment') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all"><i class="fas fa-truck text-emerald-400"></i> Pengiriman</a>
                <a href="{{ route('payment') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all"><i class="fas fa-credit-card text-purple-500"></i> Pembayaran</a>
                <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 text-sm font-medium transition-all"><i class="fas fa-phone-alt text-green-400"></i> Kontak</a>
                <a href="{{ route('order.create') }}" class="block mt-2 btn-primary text-center px-4 py-3 rounded-xl text-white text-sm font-semibold">Pesan Sekarang</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="pt-16">
        @if(session('success'))
        <div class="toast-msg">
            <div class="flex items-center gap-3 px-5 py-4 bg-gradient-to-r from-emerald-600 to-green-500 rounded-2xl text-white shadow-2xl">
                <span class="text-2xl"><i class="fas fa-check"></i></span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="toast-msg">
            <div class="flex items-center gap-3 px-5 py-4 bg-gradient-to-r from-red-600 to-rose-500 rounded-2xl text-white shadow-2xl">
                <span class="text-2xl"><i class="fas fa-times"></i></span>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-950 border-t border-blue-500/10 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl gradient-anim flex items-center justify-center text-xl text-white"><i class="fas fa-wrench text-orange-400"></i></div>
                        <div>
                            <span class="text-xl font-black text-gradient">Alsha</span><span class="text-xl font-black text-white"> Media Center</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Solusi terpercaya untuk semua masalah elektronik Anda. Teknisi berpengalaman, spare part original, garansi resmi.</p>
                    <div class="flex items-center gap-3">
                        @if($store && $store->instagram)
                        <a href="https://instagram.com/{{ ltrim($store->instagram, '@') }}" target="_blank" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-pink-400 hover:border-pink-400/30 transition-all text-sm"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($store && $store->facebook)
                        <a href="https://facebook.com/{{ $store->facebook }}" target="_blank" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-blue-400 hover:border-blue-400/30 transition-all text-sm"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($store && $store->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}" target="_blank" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-slate-400 hover:text-green-400 transition-all text-sm"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Layanan -->
                <div>
                    <h4 class="text-white font-bold mb-5 text-sm uppercase tracking-wider">Layanan</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('services.laptop') }}" class="text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-2"><span><i class="fas fa-laptop text-blue-400"></i></span> Service Laptop</a></li>
                        <li><a href="{{ route('services.printer') }}" class="text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-2"><span><i class="fas fa-print text-purple-400"></i></span> Service Printer</a></li>
                        <li><a href="{{ route('services.hp') }}" class="text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-2"><span><i class="fas fa-mobile-alt text-green-400"></i></span> Service HP</a></li>
                        <li><a href="{{ route('order.create') }}" class="text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-2"><span><i class="fas fa-clipboard-list text-yellow-400"></i></span> Buat Pesanan</a></li>
                        <li><a href="{{ route('order.track') }}" class="text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-2"><span><i class="fas fa-search"></i></span> Lacak Pesanan</a></li>
                    </ul>
                </div>

                <!-- Informasi -->
                <div>
                    <h4 class="text-white font-bold mb-5 text-sm uppercase tracking-wider">Informasi</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('about') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('shipment') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Info Pengiriman</a></li>
                        <li><a href="{{ route('payment') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Metode Pembayaran</a></li>
                        <li><a href="{{ route('contact') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-bold mb-5 text-sm uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-3 text-sm">
                        @if($store)
                        <li class="flex items-start gap-3 text-slate-400"><span class="mt-0.5"><i class="fas fa-map-marker-alt text-red-500"></i></span><span>{{ $store->address }}, {{ $store->city }}</span></li>
                        <li class="flex items-center gap-3 text-slate-400"><span><i class="fas fa-phone-alt text-green-400"></i></span><a href="tel:{{ $store->phone }}" class="hover:text-blue-400 transition-colors">{{ $store->phone }}</a></li>
                        @if($store->whatsapp)
                        <li class="flex items-center gap-3 text-slate-400"><span><i class="fas fa-comments text-green-500"></i></span><a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}" class="hover:text-green-400 transition-colors">{{ $store->whatsapp }}</a></li>
                        @endif
                        <li class="flex items-center gap-3 text-slate-400"><span><i class="fas fa-envelope text-blue-400"></i></span><a href="mailto:{{ $store->email }}" class="hover:text-blue-400 transition-colors">{{ $store->email }}</a></li>
                        <li class="flex items-center gap-3 text-slate-400"><span><i class="fas fa-clock"></i></span><span>{{ $store->open_days }}, {{ $store->open_hours }}</span></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="section-line my-10"></div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} Alsha Media Center. Semua hak dilindungi.</p>
                <p class="text-slate-600 text-xs">Dibuat dengan <i class="fas fa-heart text-red-500"></i> untuk pelanggan setia kami</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    @if($store && $store->whatsapp)
    <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20konsultasi..." target="_blank"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-400 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all animate-pulse-glow text-2xl"
       title="Chat WhatsApp">
        <i class="fab fa-whatsapp text-white"></i>
    </a>
    @endif

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @stack('scripts')

    <script>
        // Mobile menu toggle
        document.getElementById('mobileBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) nav.classList.add('navbar-scrolled');
            else nav.classList.remove('navbar-scrolled');
        });

        // Auto-dismiss toast
        setTimeout(() => {
            document.querySelectorAll('.toast-msg').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateX(100%)';
                el.style.transition = 'all 0.4s ease';
                setTimeout(() => el.remove(), 400);
            });
        }, 4000);

        // Scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-animate]').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.7s ease';
            observer.observe(el);
        });

        // Counter animation
        function animateCounter(el, target) {
            let current = 0;
            const step = target / 60;
            const timer = setInterval(() => {
                current += step;
                if (current >= target) { current = target; clearInterval(timer); }
                el.textContent = Math.floor(current).toLocaleString('id-ID');
            }, 30);
        }

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target, parseInt(entry.target.dataset.counter));
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));
    </script>
</body>
</html>
