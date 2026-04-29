<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Authentication' }} | Alsha Media Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans antialiased">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-md px-4 py-12">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-red-600 flex items-center justify-center text-white text-2xl shadow-xl transition-transform group-hover:scale-110">
                    <i class="fas fa-wrench"></i>
                </div>
                <div class="text-left">
                    <span class="text-xl font-black text-red-600">Alsha</span>
                    <span class="text-xl font-black text-gray-900"> Media</span>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Service Center</p>
                </div>
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-2xl border border-gray-100">
            {{ $slot }}
        </div>

        <div class="text-center mt-8">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Alsha Media Center. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
