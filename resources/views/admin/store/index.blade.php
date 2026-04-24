@extends('layouts.admin')
@section('title', 'Profil Toko')
@section('page-title', 'Profil Toko')
@section('page-subtitle', 'Kelola informasi toko, lokasi peta, dan jam operasional')

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.store.update') }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-white flex items-center gap-2"><i class="fas fa-store"></i> Informasi Dasar</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-2">Nama Toko *</label>
                    <input type="text" name="store_name" value="{{ old('store_name', $store->store_name ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-2">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $store->tagline ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Slogan toko Anda">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-2">Deskripsi Toko *</label>
                    <textarea name="description" required rows="4" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none">{{ old('description', $store->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-white flex items-center gap-2"><i class="fas fa-map-marker-alt text-red-500"></i> Lokasi & Kontak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-2">Alamat Lengkap *</label>
                    <input type="text" name="address" value="{{ old('address', $store->address ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Kota *</label>
                    <input type="text" name="city" value="{{ old('city', $store->city ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">No. Telepon *</label>
                    <input type="text" name="phone" value="{{ old('phone', $store->phone ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $store->whatsapp ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="08xx-xxxx-xxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $store->email ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $store->instagram ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="@username">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Facebook</label>
                    <input type="text" name="facebook" value="{{ old('facebook', $store->facebook ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
            </div>
        </div>

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-white flex items-center gap-2"><i class="fas fa-map text-emerald-400"></i> Koordinat Peta</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Latitude *</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude', $store->latitude ?? -6.9147) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Longitude *</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude', $store->longitude ?? 107.6098) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
            </div>
            <p class="text-slate-500 text-xs"><i class="fas fa-lightbulb"></i> Tip: Buka Google Maps → klik kanan lokasi → pilih koordinat untuk mendapatkan lat/long yang akurat.</p>
            <div id="adminMap" class="rounded-xl border border-blue-500/10" style="height:300px;"></div>
        </div>

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-white flex items-center gap-2"><i class="fas fa-clock"></i> Jam Operasional</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Hari Buka *</label>
                    <input type="text" name="open_days" value="{{ old('open_days', $store->open_days ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Senin - Sabtu">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Jam Buka *</label>
                    <input type="text" name="open_hours" value="{{ old('open_hours', $store->open_hours ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="08:00 - 20:00">
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary flex-1 py-4 rounded-2xl text-white font-bold"><i class="fas fa-save text-blue-400"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const lat = {{ $store->latitude ?? -6.9147 }};
    const lng = {{ $store->longitude ?? 107.6098 }};
    const map = L.map('adminMap').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

    const icon = L.divIcon({
        html: `<div style="background:linear-gradient(135deg,#3b82f6,#8b5cf6);width:36px;height:36px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 15px rgba(59,130,246,0.5);border:3px solid white;display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:16px;"><i class="fas fa-wrench text-orange-400"></i></span></div>`,
        className: '', iconSize: [36,36], iconAnchor: [18,36]
    });

    const marker = L.marker([lat, lng], { icon, draggable: true }).addTo(map)
        .bindPopup('<strong><i class="fas fa-wrench text-orange-400"></i> Alsha Media Center</strong><br>Geser pin untuk mengubah lokasi').openPopup();

    marker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        document.querySelector('input[name="latitude"]').value = pos.lat.toFixed(7);
        document.querySelector('input[name="longitude"]').value = pos.lng.toFixed(7);
    });

    document.querySelector('input[name="latitude"]').addEventListener('change', function() {
        const newLat = parseFloat(this.value);
        const newLng = parseFloat(document.querySelector('input[name="longitude"]').value);
        marker.setLatLng([newLat, newLng]);
        map.setView([newLat, newLng], 16);
    });
    document.querySelector('input[name="longitude"]').addEventListener('change', function() {
        const newLat = parseFloat(document.querySelector('input[name="latitude"]').value);
        const newLng = parseFloat(this.value);
        marker.setLatLng([newLat, newLng]);
        map.setView([newLat, newLng], 16);
    });
</script>
@endpush

