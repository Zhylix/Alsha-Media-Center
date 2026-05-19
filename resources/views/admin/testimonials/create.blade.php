@extends('layouts.admin')
@section('title', 'Tambah Testimonial')
@section('page-title', 'Tambah Testimonial')
@section('page-subtitle', 'Form penambahan testimoni pelanggan')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.testimonials.store') }}" class="space-y-6">
        @csrf
        <div class="service-card p-8 rounded-2xl space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama Pelanggan *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: Budi Santoso">
                    @error('customer_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Layanan *</label>
                    <select name="service_type" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                        <option value="">-- Pilih --</option>
                        <option value="laptop" {{ old('service_type') === 'laptop' ? 'selected' : '' }}>Service Laptop</option>
                        <option value="printer" {{ old('service_type') === 'printer' ? 'selected' : '' }}>Service Printer</option>
                        <option value="pc" {{ old('service_type') === 'pc' ? 'selected' : '' }}>Service PC</option>
                        <option value="software" {{ old('service_type') === 'software' ? 'selected' : '' }}>Installasi Software</option>
                    </select>
                    @error('service_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Rating *</label>
                    <select name="rating" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                        <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 - Sangat Puas</option>
                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Puas</option>
                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Cukup</option>
                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Kurang</option>
                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Sangat Kurang</option>
                    </select>
                    @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Komentar *</label>
                    <textarea name="comment" required rows="4" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none" placeholder="Tuliskan testimoni pelanggan...">{{ old('comment') }}</textarea>
                    @error('comment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-6 pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" class="w-4 h-4 rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm">Tampilkan di website</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.testimonials.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">Simpan Testimonial</button>
        </div>
    </form>
</div>
@endsection

