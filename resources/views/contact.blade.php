@extends('layouts.app')
@section('title', 'Kontak Kami | Alsha Media Center')
@section('content')

<!-- ===================== HERO ===================== -->
<section class="relative py-36 bg-white overflow-hidden">
    <!-- Geometric accent -->
    <div class="absolute top-0 right-0 w-[40%] h-full bg-gray-50 hidden lg:block" style="clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%)"></div>
    <div class="absolute bottom-0 left-0 w-48 h-1 bg-[#C8000A]"></div>

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
        <div class="max-w-xl">
            <div class="inline-flex items-center gap-2.5 mb-6">
                <span class="block w-6 h-px bg-[#C8000A]"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Kontak</span>
            </div>
            <h1 class="text-5xl sm:text-6xl font-black text-gray-900 tracking-tight leading-tight mb-5">
                Hubungi<br><span class="text-[#C8000A]">Kami</span>
            </h1>
            <p class="text-gray-400 text-lg leading-relaxed">Ada pertanyaan atau butuh bantuan? Kami siap membantu Anda setiap saat.</p>
        </div>
    </div>
</section>

<!-- ===================== MAIN CONTENT ===================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Contact Form -->
            <div>
                <div class="inline-flex items-center gap-2.5 mb-8">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Kirim Pesan</span>
                </div>
                
                @if(session('success'))
                <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 mb-8">
                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Nama Lengkap <span class="text-[#C8000A]">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required 
                                   class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors"
                                   placeholder="Nama lengkap Anda">
                            @error('name')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" 
                                   class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors"
                                   placeholder="08xx-xxxx-xxxx">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Email <span class="text-[#C8000A]">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors"
                               placeholder="email@contoh.com">
                        @error('email')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Subjek <span class="text-[#C8000A]">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required 
                               class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors"
                               placeholder="Pertanyaan tentang...">
                        @error('subject')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Pesan <span class="text-[#C8000A]">*</span></label>
                        <textarea name="message" required rows="6" 
                                  class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors resize-none"
                                  placeholder="Tuliskan pesan atau pertanyaan Anda di sini...">{{ old('message') }}</textarea>
                        @error('message')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" 
                            class="group w-full flex items-center justify-center gap-3 px-8 py-4 bg-[#C8000A] text-white font-black text-sm uppercase tracking-widest hover:bg-[#A00008] transition-colors">
                        <i class="fas fa-paper-plane text-sm"></i>
                        Kirim Pesan
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>

            <!-- Contact Info + Map -->
            <div class="space-y-5">
                <div class="inline-flex items-center gap-2.5 mb-3">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Informasi Toko</span>
                </div>

                @if($store)
                @foreach([
                    ['icon' => 'fa-map-marker-alt', 'label' => 'Alamat Toko', 'line1' => $store->address, 'line2' => $store->city],
                    ['icon' => 'fa-clock', 'label' => 'Jam Operasional', 'line1' => $store->open_days, 'line2' => $store->open_hours, 'accent' => true],
                ] as $info)
                <div class="flex items-start gap-4 p-5 border border-gray-100 hover:border-[#C8000A]/20 transition-colors">
                    <div class="w-10 h-10 bg-[#C8000A] flex items-center justify-center flex-shrink-0">
                        <i class="fas {{ $info['icon'] }} text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.12em] text-gray-400 mb-1">{{ $info['label'] }}</p>
                        <p class="text-gray-800 text-sm font-semibold">{{ $info['line1'] }}</p>
                        <p class="text-sm {{ isset($info['accent']) ? 'text-[#C8000A] font-black' : 'text-gray-500' }}">{{ $info['line2'] }}</p>
                    </div>
                </div>
                @endforeach

                <div class="grid grid-cols-2 gap-3">
                    <a href="tel:{{ $store->phone }}" class="group flex items-start gap-3 p-4 border border-gray-100 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all">
                        <div class="w-8 h-8 bg-red-50 group-hover:bg-[#C8000A] flex items-center justify-center flex-shrink-0 transition-colors">
                            <i class="fas fa-phone-alt text-[#C8000A] group-hover:text-white text-xs transition-colors"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-gray-400 mb-1">Telepon</p>
                            <p class="text-gray-800 text-xs font-bold">{{ $store->phone }}</p>
                        </div>
                    </a>
                    <a href="mailto:{{ $store->email }}" class="group flex items-start gap-3 p-4 border border-gray-100 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all">
                        <div class="w-8 h-8 bg-red-50 group-hover:bg-[#C8000A] flex items-center justify-center flex-shrink-0 transition-colors">
                            <i class="fas fa-envelope text-[#C8000A] group-hover:text-white text-xs transition-colors"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-gray-400 mb-1">Email</p>
                            <p class="text-gray-800 text-xs font-bold">{{ $store->email }}</p>
                        </div>
                    </a>
                </div>
                @endif

                <!-- WhatsApp CTA -->
                @if($store && $store->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}?text=Halo%20Alsha%20Media%20Center!" 
                   target="_blank"
                   class="group flex items-center gap-4 p-5 bg-[#C8000A] text-white hover:bg-[#A00008] transition-colors">
                    <i class="fab fa-whatsapp text-3xl flex-shrink-0"></i>
                    <div>
                        <p class="font-black text-sm">Chat via WhatsApp</p>
                        <p class="text-white/70 text-xs">Respon cepat, biasanya balas dalam menit</p>
                    </div>
                    <i class="fas fa-arrow-right text-sm ml-auto group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif

                <!-- Map -->
                <div class="overflow-hidden border border-gray-200">
                    @if($store && $store->google_maps_link)
                    <iframe src="{{ $store->google_maps_link }}" width="100%" style="border:0; height:280px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                    <div id="map" style="height:280px;"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
@if(!($store && $store->google_maps_link))
<script>
    const map = L.map('map').setView([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution:'© OpenStreetMap'}).addTo(map);
    const icon = L.divIcon({ 
        html: `<div style="background:#C8000A;width:40px;height:40px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(200,0,10,0.4);"><i class="fas fa-wrench" style="color:white;font-size:16px;"></i></div>`, 
        className:'', iconSize:[40,40], iconAnchor:[20,40] 
    });
    L.marker([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], {icon}).addTo(map)
     .bindPopup('<strong style="color:#C8000A;">Alsha Media Center</strong>')
     .openPopup();
</script>
@endif
@endpush