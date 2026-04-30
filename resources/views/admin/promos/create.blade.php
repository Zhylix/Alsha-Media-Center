@extends('layouts.admin')
@section('title', 'Tambah Promo')
@section('page-title', 'Tambah Promo')
@section('page-subtitle', 'Buat penawaran spesial baru')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.promos.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="service-card p-8 rounded-2xl space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Judul Promo *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: Promo Ramadhan Berkah">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Info Diskon / Badge (Opsional)</label>
                    <input type="text" name="discount_info" value="{{ old('discount_info') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: Diskon 20% atau Gratis Ongkir">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Mulai *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Berakhir *</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date', now()->addDays(7)->format('Y-m-d\TH:i')) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Urutan Tampilan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="0">
                    <p class="text-gray-500 text-[10px] mt-1 italic">* Angka kecil tampil lebih dulu (0 = paling atas)</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Promo *</label>
                    <textarea name="description" required rows="5" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none" placeholder="Jelaskan detail promo Anda...">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Gambar Promo (Opsional)</label>
                    <input type="file" name="image" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                    <p class="text-gray-500 text-[10px] mt-1 italic">* Rekomendasi ukuran 16:9 (e.g. 1280x720px), Maks. 2MB</p>
                </div>
                <div class="flex items-center gap-6 pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm">Aktifkan Promo</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.promos.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">Simpan Promo</button>
        </div>
    </form>
</div>
@endsection
