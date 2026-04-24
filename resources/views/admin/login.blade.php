<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Alsha Media Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-hero min-h-screen flex items-center justify-center">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto rounded-2xl gradient-anim flex items-center justify-center text-3xl mb-4 shadow-2xl"><i class="fas fa-cog text-white"></i></div>
            <h1 class="text-2xl font-black text-white">Admin <span class="text-gradient">Alsha Media Center</span></h1>
            <p class="text-slate-500 text-sm mt-1">Panel Administrasi — Akses Terbatas</p>
        </div>

        <div class="service-card p-8 rounded-2xl">
            @if(session('error'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">
                <span><i class="fas fa-exclamation-triangle"></i></span> {{ session('error') }}
            </div>
            @endif
            @if(session('success'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">
                <span><i class="fas fa-check"></i></span> {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Admin">
                    @error('username')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="••••••••">
                </div>
                <button type="submit" class="btn-primary w-full py-4 rounded-2xl text-white font-bold">
                    <i class="fas fa-user-lock"></i> Masuk ke Admin
                </button>
            </form>
        </div>

        <p class="text-center text-slate-600 text-xs mt-6">
            <a href="{{ route('home') }}" class="hover:text-slate-400 transition-colors"><i class="fas fa-arrow-left"></i> Kembali ke Website</a>
        </p>
    </div>
</body>
</html>
