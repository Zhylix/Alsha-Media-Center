@extends('layouts.admin')
@section('title', 'Edit Paket')
@section('page-title', 'Edit Paket')
@section('page-subtitle', 'Ubah informasi penawaran spesial')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.pakets.update', $paket) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        <div class="service-card p-8 rounded-2xl space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Judul Paket *</label>
                    <input type="text" name="title" value="{{ old('title', $paket->title) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Info Diskon / Badge (Opsional)</label>
                    <input type="text" name="discount_info" value="{{ old('discount_info', $paket->discount_info) }}" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Mulai *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date', $paket->start_date->format('Y-m-d\TH:i')) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Berakhir *</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date', $paket->end_date->format('Y-m-d\TH:i')) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Urutan Tampilan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $paket->sort_order ?? 0) }}" min="0" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="0">
                    <p class="text-gray-500 text-[10px] mt-1 italic">* Angka kecil tampil lebih dulu (0 = paling atas)</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Paket *</label>
                    <textarea name="description" required rows="5" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none">{{ old('description', $paket->description) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Gambar Paket (Opsional)</label>
                    @if($paket->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $paket->image) }}" class="w-40 h-auto rounded-xl border border-red-500/20">
                    </div>
                    @endif
                    <input type="file" name="image" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                    <p class="text-gray-500 text-[10px] mt-1 italic">* Biarkan kosong jika tidak ingin mengubah gambar. Rekomendasi 16:9, Maks. 2MB</p>
                </div>
                <div class="flex items-center gap-6 pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded" {{ $paket->is_active ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm">Aktifkan Paket</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.pakets.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">Perbarui Paket</button>
        </div>
    </form>
</div>
@endsection
