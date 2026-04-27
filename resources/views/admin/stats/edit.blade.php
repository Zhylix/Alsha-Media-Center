@extends('layouts.admin')
@section('title', 'Edit Stat')
@section('page-title', 'Edit Stat')
@section('page-subtitle', 'Ubah informasi statistik')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.stats.update', $stat) }}" class="space-y-6">
        @csrf @method('PUT')
        <div class="service-card p-8 rounded-2xl space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Icon FontAwesome *</label>
                    <input type="text" name="icon" value="{{ old('icon', $stat->icon) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: fas fa-clock">
                    <p class="text-xs text-gray-500 mt-1">Lihat dokumentasi: <a href="https://fontawesome.com" target="_blank" class="text-red-600 hover:underline">fontawesome.com</a></p>
                    @error('icon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Label *</label>
                    <input type="text" name="label" value="{{ old('label', $stat->label) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: Tahun Pengalaman">
                    @error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nilai *</label>
                    <input type="text" name="value" value="{{ old('value', $stat->value) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: 10">
                    <p class="text-xs text-gray-500 mt-1">Bisa berupa angka atau teks</p>
                    @error('value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $stat->sort_order) }}" min="0" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="0">
                    <p class="text-xs text-gray-500 mt-1">Semakin kecil, semakin ke depan</p>
                    @error('sort_order')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $stat->is_active) ? 'checked' : '' }} class="form-checkbox">
                        <span class="text-sm font-medium text-gray-600">Aktif</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.stats.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">Perbarui Stat</button>
        </div>
    </form>
</div>
@endsection
