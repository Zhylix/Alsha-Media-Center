@extends('layouts.admin')
@section('title', 'Tambah Servis Baru')
@section('page-title', 'Tambah Servis Baru')
@section('page-subtitle', 'Input data pelanggan dan perangkat yang akan diservis')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.service-tickets.store') }}" class="space-y-6" id="serviceForm">
        @csrf
        <div class="service-card p-8 rounded-2xl space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama Pelanggan *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                           class="form-input w-full px-4 py-3 rounded-xl text-sm"
                           placeholder="Contoh: Budi Santoso">
                    @error('customer_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nomor WhatsApp *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="form-input w-full px-4 py-3 rounded-xl text-sm"
                           placeholder="Contoh: 08123456789 atau 628123456789">
                    <p class="text-xs text-gray-400 mt-1">Format: 08xx atau 628xx. Akan otomatis dikirim ke WhatsApp pelanggan.</p>
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Perangkat *</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="device_type" value="pc" class="peer sr-only" {{ old('device_type') === 'pc' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-4 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                <div class="text-2xl mb-1"><i class="fas fa-desktop text-gray-500 peer-checked:text-red-600"></i></div>
                                <span class="text-sm font-medium text-gray-700 peer-checked:text-red-700">PC / Komputer</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="device_type" value="laptop" class="peer sr-only" {{ old('device_type') === 'laptop' ? 'checked' : '' }}>
                            <div class="text-center px-4 py-4 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                <div class="text-2xl mb-1"><i class="fas fa-laptop text-gray-500 peer-checked:text-red-600"></i></div>
                                <span class="text-sm font-medium text-gray-700 peer-checked:text-red-700">Laptop</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="device_type" value="printer" class="peer sr-only" {{ old('device_type') === 'printer' ? 'checked' : '' }}>
                            <div class="text-center px-4 py-4 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                <div class="text-2xl mb-1"><i class="fas fa-print text-gray-500 peer-checked:text-red-600"></i></div>
                                <span class="text-sm font-medium text-gray-700 peer-checked:text-red-700">Printer</span>
                            </div>
                        </label>
                    </div>
                    @error('device_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Keluhan / Kerusakan *</label>
                    <textarea name="problem" required rows="4"
                              class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none"
                              placeholder="Deskripsikan keluhan atau kerusakan perangkat...">{{ old('problem') }}</textarea>
                    @error('problem')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.service-tickets.index') }}"
               class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">
                <i class="fab fa-whatsapp mr-1"></i> Simpan & Kirim WA
            </button>
        </div>
    </form>
</div>
@endsection

