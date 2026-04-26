@extends('layouts.admin')
@section('title', 'Profil Toko')
@section('page-title', 'Profil Toko')
@section('page-subtitle', 'Kelola informasi toko, lokasi peta, dan jam operasional')

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.store.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2"><i class="fas fa-store"></i> Informasi Dasar</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama Toko *</label>
                    <input type="text" name="store_name" value="{{ old('store_name', $store->store_name ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $store->tagline ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Slogan toko Anda">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Toko *</label>
                    <textarea name="description" required rows="4" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none">{{ old('description', $store->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2"><i class="fas fa-image"></i> Branding & Logo</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-start">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Upload Logo Baru</label>
                    <input type="file" name="logo" accept="image/*" class="form-input w-full px-4 py-3 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-500/10 file:text-red-500 hover:file:bg-red-500/20">
                    <p class="text-gray-500 text-xs mt-2">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                </div>
                <div>
                    @if($store && $store->logo)
                    <label class="block text-sm font-medium text-gray-600 mb-2">Logo Saat Ini</label>
                    <div class="flex items-center gap-4">
                        <div class="bg-white p-2 rounded-xl">
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo" class="h-16 object-contain">
                        </div>
                        <button type="button" onclick="if(confirm('Yakin ingin menghapus logo?')) document.getElementById('delete-logo-form').submit();" class="text-red-500 hover:text-red-400 text-sm font-medium px-4 py-2 bg-red-500/10 rounded-lg">
                            <i class="fas fa-trash"></i> Hapus Logo
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2"><i class="fas fa-map-marker-alt text-red-500"></i> Lokasi & Kontak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Alamat Lengkap *</label>
                    <input type="text" name="address" value="{{ old('address', $store->address ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Kota *</label>
                    <input type="text" name="city" value="{{ old('city', $store->city ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">No. Telepon *</label>
                    <input type="text" name="phone" value="{{ old('phone', $store->phone ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $store->whatsapp ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="08xx-xxxx-xxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $store->email ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $store->instagram ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="@username">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Facebook</label>
                    <input type="text" name="facebook" value="{{ old('facebook', $store->facebook ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
            </div>
        </div>

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2"><i class="fas fa-map text-red-600"></i> Link Google Maps</h3>
            <div class="grid grid-cols-1 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Link Google Maps Embed (untuk Peta di Website)</label>
                    <input type="url" name="google_maps_link" value="{{ old('google_maps_link', $store->google_maps_link ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="https://www.google.com/maps/embed?pb=...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Link Google Maps Langsung (untuk Tombol "Buka di Google Maps")</label>
                    <input type="url" name="google_maps_direct_link" value="{{ old('google_maps_direct_link', $store->google_maps_direct_link ?? '') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="https://maps.app.goo.gl/... atau https://www.google.com/maps/search/?api=1&query=...">
                </div>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800">
                <p class="font-semibold mb-1"><i class="fas fa-lightbulb text-yellow-600"></i> Cara mendapatkan Link Google Maps:</p>
                <ol class="list-decimal list-inside space-y-1 text-xs text-yellow-700">
                    <li>Buka <strong>Google Maps</strong> di browser</li>
                    <li>Cari lokasi toko Anda</li>
                    <li>Klik tombol <strong>Share / Bagikan</strong></li>
                    <li>Untuk <strong>Embed</strong>: Pilih tab <strong>Embed a map / Sematkan peta</strong>, salin URL dari kode iframe (bagian <code>src="..."</code>)</li>
                    <li>Untuk <strong>Tombol</strong>: Pilih tab <strong>Send a link / Kirim tautan</strong>, salin link pendek yang muncul</li>
                    <li>Tempel URL tersebut di kolom di atas</li>
                </ol>
            </div>
            @if($store && $store->google_maps_link)
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Preview Peta</label>
                <div class="rounded-xl border border-red-500/20 overflow-hidden">
                    <iframe src="{{ $store->google_maps_link }}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            @endif
        </div>

        <div class="service-card p-8 rounded-2xl space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2"><i class="fas fa-clock"></i> Jam Operasional</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Hari Buka *</label>
                    <input type="text" name="open_days" value="{{ old('open_days', $store->open_days ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Senin - Sabtu">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jam Buka *</label>
                    <input type="text" name="open_hours" value="{{ old('open_hours', $store->open_hours ?? '') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="08:00 - 20:00">
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary flex-1 py-4 rounded-2xl text-white font-bold"><i class="fas fa-save text-white"></i> Simpan Perubahan</button>
        </div>
    </form>

    <form id="delete-logo-form" action="{{ route('admin.store.logo.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

