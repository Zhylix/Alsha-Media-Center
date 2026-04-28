<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDesc ?? 'Alsha Media Center – Jasa service PC, laptop, dan printer terpercaya di Bangsri. Teknisi berpengalaman, spare part original, garansi resmi.' }}">
    <meta name="keywords" content="service pc bangsri, service laptop bangsri, service printer bangsri, alsha media center">
    <title>@yield('title', 'Alsha Media Center') | Jasa Service PC, Laptop & Printer</title>
    @if($store && $store->logo)
    <link rel="icon" href="{{ asset('storage/' . $store->logo) }}">
    @else
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🔧</text></svg>">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <!-- NAVBAR -->
    <nav id="navbar" class="navbar-bg fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @if($store && $store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo" class="h-10 w-auto group-hover:scale-105 transition-transform">
                    @else
                    <div class="w-10 h-10 rounded-xl gradient-anim flex items-center justify-center text-xl font-black text-gray-900 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-wrench text-white"></i>
                    </div>
                    @endif
                    <div>
                        <span class="text-lg font-black text-gradient">Alsha</span><span class="text-lg font-black text-gray-900"> Media Center</span>
                        <p class="text-[10px] text-gray-600 leading-none">Service Center Bangsri</p>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('home') ? 'active text-red-600' : '' }}">Beranda</a>
                    <a href="{{ route('about') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('about') ? 'active text-red-600' : '' }}">Tentang Kami</a>

                    <!-- Services Dropdown -->
                    <div class="relative group">
                        <button class="nav-link-item px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-all flex items-center gap-1 {{ request()->routeIs('services.*') ? 'active text-red-600' : '' }}">
                            Layanan <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute top-full left-0 mt-2 w-52 glass rounded-2xl p-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 shadow-2xl border border-red-500/20">
                            <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-gray-700 hover:text-red-600 text-sm transition-all"><i class="fas fa-tools text-red-500"></i> Semua Layanan</a>
                            <a href="{{ route('services.pc') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-gray-700 hover:text-red-600 text-sm transition-all"><i class="fas fa-desktop text-gray-500"></i> Service PC</a>
                            <a href="{{ route('services.laptop') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-gray-700 hover:text-red-600 text-sm transition-all"><i class="fas fa-laptop text-gray-500"></i> Service Laptop</a>
                            <a href="{{ route('services.printer') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-gray-700 hover:text-red-600 text-sm transition-all"><i class="fas fa-print text-gray-500"></i> Service Printer</a>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="nav-link-item px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-all {{ request()->routeIs('contact') ? 'active text-red-600' : '' }}">Kontak</a>
                </div>

                <!-- CTA + Mobile Toggle -->
                <div class="flex items-center gap-3">
                    <button id="mobileBtn" class="md:hidden p-2 rounded-xl hover:bg-gray-200 transition-colors">
                        <svg class="w-6 h-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden glass border-t border-red-500/20">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-red-600 hover:bg-gray-100 text-sm font-medium transition-all"><i class="fas fa-home text-red-500"></i> Beranda</a>
                <a href="{{ route('about') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-red-600 hover:bg-gray-100 text-sm font-medium transition-all"><i class="fas fa-building text-red-400"></i> Tentang Kami</a>
                <a href="{{ route('services.index') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-red-600 hover:bg-gray-100 text-sm font-medium transition-all"><i class="fas fa-tools text-red-500"></i> Semua Layanan</a>
                <a href="{{ route('services.pc') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-red-600 hover:bg-gray-100 text-sm font-medium transition-all pl-8"><i class="fas fa-desktop text-gray-500"></i> Service PC</a>
                <a href="{{ route('services.laptop') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-red-600 hover:bg-gray-100 text-sm font-medium transition-all pl-8"><i class="fas fa-laptop text-gray-500"></i> Service Laptop</a>
                <a href="{{ route('services.printer') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-red-600 hover:bg-gray-100 text-sm font-medium transition-all pl-8"><i class="fas fa-print text-gray-500"></i> Service Printer</a>
                <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-red-600 hover:bg-gray-100 text-sm font-medium transition-all"><i class="fas fa-phone-alt text-red-500"></i> Kontak</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="pt-16">
        @if(session('success'))
        <div class="toast-msg">
            <div class="flex items-center gap-3 px-5 py-4 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl text-white shadow-2xl">
                <span class="text-2xl"><i class="fas fa-check"></i></span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="toast-msg">
            <div class="flex items-center gap-3 px-5 py-4 bg-gradient-to-r from-gray-700 to-gray-800 rounded-2xl text-white shadow-2xl">
                <span class="text-2xl"><i class="fas fa-times"></i></span>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-50 border-t border-red-500/20 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            @if($store && $store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo" class="h-10 w-auto group-hover:scale-105 transition-transform">
                            @else
                            <div class="w-10 h-10 rounded-xl gradient-anim flex items-center justify-center text-xl font-black text-gray-900 shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-wrench text-white"></i>
                            </div>
                            @endif
                            <div>
                                <span class="text-xl font-black text-gradient">Alsha</span><span class="text-xl font-black text-gray-900"> Media Center</span>
                            </div>
                        </a>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">Solusi terpercaya untuk semua masalah elektronik Anda. Teknisi berpengalaman, spare part original, garansi resmi.</p>
                    <div class="flex items-center gap-3">
                        @if($store && $store->instagram)
                        <a href="https://instagram.com/{{ ltrim($store->instagram, '@') }}" target="_blank" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-gray-600 hover:text-red-600 hover:border-red-600/30 transition-all text-sm"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($store && $store->facebook)
                        <a href="https://facebook.com/{{ $store->facebook }}" target="_blank" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-gray-600 hover:text-red-600 hover:border-red-600/30 transition-all text-sm"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($store && $store->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}" target="_blank" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-gray-600 hover:text-red-600 transition-all text-sm"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Layanan -->
                <div>
                    <h4 class="text-gray-900 font-bold mb-5 text-sm uppercase tracking-wider">Layanan</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('services.pc') }}" class="text-gray-600 hover:text-red-600 transition-colors flex items-center gap-2"><span><i class="fas fa-desktop text-gray-500"></i></span> Service PC</a></li>
                        <li><a href="{{ route('services.laptop') }}" class="text-gray-600 hover:text-red-600 transition-colors flex items-center gap-2"><span><i class="fas fa-laptop text-gray-500"></i></span> Service Laptop</a></li>
                        <li><a href="{{ route('services.printer') }}" class="text-gray-600 hover:text-red-600 transition-colors flex items-center gap-2"><span><i class="fas fa-print text-gray-500"></i></span> Service Printer</a></li>
                    </ul>
                </div>

                <!-- Informasi -->
                <div>
                    <h4 class="text-gray-900 font-bold mb-5 text-sm uppercase tracking-wider">Informasi</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-red-600 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-600 transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-gray-900 font-bold mb-5 text-sm uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-3 text-sm">
                        @if($store)
                        <li class="flex items-start gap-3 text-gray-600"><span class="mt-0.5"><i class="fas fa-map-marker-alt text-red-500"></i></span><span>{{ $store->address }}, {{ $store->city }}</span></li>
                        <li class="flex items-center gap-3 text-gray-600"><span><i class="fas fa-phone-alt text-gray-500"></i></span><a href="tel:{{ $store->phone }}" class="hover:text-red-600 transition-colors">{{ $store->phone }}</a></li>
                        @if($store->whatsapp)
                        <li class="flex items-center gap-3 text-gray-600"><span><i class="fas fa-comments text-red-500"></i></span><a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}" class="hover:text-red-600 transition-colors">{{ $store->whatsapp }}</a></li>
                        @endif
                        <li class="flex items-center gap-3 text-gray-600"><span><i class="fas fa-envelope text-red-500"></i></span><a href="mailto:{{ $store->email }}" class="hover:text-red-600 transition-colors">{{ $store->email }}</a></li>
                        <li class="flex items-center gap-3 text-gray-600"><span><i class="fas fa-clock"></i></span><span>{{ $store->open_days }}, {{ $store->open_hours }}</span></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="section-line my-10"></div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-gray-500 text-sm">© {{ date('Y') }} Alsha Media Center. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    @if($store && $store->whatsapp)
    <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20konsultasi..." target="_blank"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-red-600 hover:bg-red-600 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all animate-pulse-glow text-2xl"
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
