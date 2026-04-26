@extends('layouts.admin')
@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')
@section('page-subtitle', 'Ubah informasi layanan')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        <div class="service-card p-8 rounded-2xl space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama Layanan *</label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Kategori *</label>
                    <select name="category" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                        <option value="laptop" {{ $service->category === 'laptop' ? 'selected' : '' }}><i class="fas fa-laptop text-red-600"></i> Laptop</option>
                        <option value="printer" {{ $service->category === 'printer' ? 'selected' : '' }}><i class="fas fa-print text-red-600"></i> Printer</option>
                        <option value="pc" {{ $service->category === 'pc' ? 'selected' : '' }}><i class="fas fa-desktop text-red-600"></i> PC</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Estimasi Hari *</label>
                    <input type="number" name="estimated_days" value="{{ old('estimated_days', $service->estimated_days) }}" required min="1" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Harga Mulai (Rp) *</label>
                    <input type="number" name="price_start" value="{{ old('price_start', $service->price_start) }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Harga Maksimal (Rp)</label>
                    <input type="number" name="price_end" value="{{ old('price_end', $service->price_end) }}" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Singkat</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $service->short_description) }}" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Lengkap *</label>
                    <textarea name="description" required rows="5" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none">{{ old('description', $service->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div class="flex items-center gap-6 pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" class="w-4 h-4 rounded" {{ $service->is_active ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" class="w-4 h-4 rounded" {{ $service->is_featured ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm"><i class="fas fa-star text-red-600"></i> Featured</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.services.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">Perbarui Layanan</button>
        </div>
    </form>
</div>
@endsection
