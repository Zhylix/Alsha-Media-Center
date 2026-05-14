@extends('layouts.admin')
@section('title', 'Tambah Paket')
@section('page-title', 'Tambah Paket')
@section('page-subtitle', 'Buat penawaran spesial baru')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.pakets.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="service-card p-8 rounded-2xl space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Judul Paket *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: Paket Ramadhan Berkah">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Info Diskon / Badge (Opsional)</label>
                    <input type="text" name="discount_info" value="{{ old('discount_info') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: Diskon 20% atau Gratis Ongkir">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Harga Paket *</label>
                    <input type="number" name="price" step="1" min="0" value="{{ old('price', 0) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: 150000">
                    <p class="text-gray-500 text-[10px] mt-1 italic">* Format angka Rupiah (tanpa desimal)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Urutan Tampilan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="0">
                    <p class="text-gray-500 text-[10px] mt-1 italic">* Angka kecil tampil lebih dulu (0 = paling atas)</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Paket *</label>
                    <textarea name="description" required rows="5" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none" placeholder="Jelaskan detail paket Anda...">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Gambar Paket (Opsional)</label>
                    <input type="file" name="image" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                    <p class="text-gray-500 text-[10px] mt-1 italic">* Rekomendasi ukuran 16:9 (e.g. 1280x720px), Maks. 2MB</p>
                </div>
                <div class="flex items-center gap-6 pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm">Aktifkan Paket</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.pakets.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">Simpan Paket</button>
        </div>
    </form>
</div>
@endsection
