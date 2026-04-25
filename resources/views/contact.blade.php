@extends('layouts.app')
@section('title', 'Kontak Kami')
@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 right-1/3 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Kontak</span>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 mt-3 mb-4">Hubungi <span class="text-gradient">Kami</span></h1>
        <p class="text-gray-600 text-lg max-w-xl mx-auto">Ada pertanyaan atau butuh bantuan? Kami siap membantu Anda!</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div data-animate>
                <h2 class="text-2xl font-black text-gray-900 mb-6">Kirim <span class="text-gradient">Pesan</span></h2>
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Nama Lengkap *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Nama Anda">
                            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="08xx-xxxx-xxxx">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="email@example.com">
                        @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Subjek *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Pertanyaan tentang...">
                        @error('subject')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Pesan *</label>
                        <textarea name="message" required rows="5" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none" placeholder="Tuliskan pesan Anda di sini...">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary w-full py-4 rounded-2xl text-white font-bold">
                        <i class="fas fa-envelope-open-text"></i> Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Info + Map -->
            <div class="space-y-6" data-animate>
                @if($store)
                <div class="service-card p-6 rounded-2xl">
                    <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-map-marker-alt text-red-500"></i> Informasi Kontak</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="text-xl mt-0.5"><i class="fas fa-map-marker-alt text-red-500"></i></span>
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Alamat</p>
                                <p class="text-gray-900 text-sm">{{ $store->address }}, {{ $store->city }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-xl mt-0.5"><i class="fas fa-phone-alt text-red-600"></i></span>
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Telepon</p>
                                <a href="tel:{{ $store->phone }}" class="text-red-600 text-sm hover:text-gray-900 transition-colors">{{ $store->phone }}</a>
                            </div>
                        </div>
                        @if($store->whatsapp)
                        <div class="flex items-start gap-3">
                            <span class="text-xl mt-0.5"><i class="fas fa-comments text-red-600"></i></span>
                            <div>
                                <p class="text-gray-600 text-sm font-medium">WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}" class="text-red-600 text-sm hover:text-gray-900 transition-colors">{{ $store->whatsapp }}</a>
                            </div>
                        </div>
                        @endif
                        <div class="flex items-start gap-3">
                            <span class="text-xl mt-0.5"><i class="fas fa-envelope text-red-600"></i></span>
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Email</p>
                                <a href="mailto:{{ $store->email }}" class="text-red-600 text-sm hover:text-gray-900 transition-colors">{{ $store->email }}</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-xl mt-0.5"><i class="fas fa-clock"></i></span>
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Jam Buka</p>
                                <p class="text-gray-900 text-sm">{{ $store->open_days }}</p>
                                <p class="text-red-600 text-sm font-semibold">{{ $store->open_hours }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div id="map" class="rounded-2xl shadow-2xl border border-red-600/10" style="height:300px;"></div>

                <a href="https://wa.me/{{ preg_replace('/\D/','',optional($store)->whatsapp ?? '6281234567890') }}?text=Halo%20Alsha%20Media%20Center!" target="_blank" class="flex items-center gap-4 service-card p-5 rounded-2xl hover:border-red-600/30 transition-all">
                    <div class="text-4xl"><i class="fas fa-comments text-red-600"></i></div>
                    <div>
                        <p class="font-bold text-gray-900">Chat via WhatsApp</p>
                        <p class="text-gray-600 text-sm">Respon cepat, biasanya balas dalam menit</p>
                    </div>
                    <svg class="w-5 h-5 text-red-600 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const map = L.map('map').setView([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution:'© OpenStreetMap'}).addTo(map);
    const icon = L.divIcon({ html: `<div style="background:linear-gradient(135deg,#dc2626,#991b1b);width:36px;height:36px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 15px rgba(220,38,38,0.5);border:3px solid white;display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:16px;"><i class="fas fa-wrench text-white"></i></span></div>`, className:'', iconSize:[36,36], iconAnchor:[18,36] });
    L.marker([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], {icon}).addTo(map).bindPopup('<strong><i class="fas fa-wrench text-red-600"></i> Alsha Media Center</strong>').openPopup();
</script>
@endpush
