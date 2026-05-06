@extends('layouts.admin')
@section('title', 'Edit Servis')
@section('page-title', 'Edit Servis')
@section('page-subtitle', 'Kode: ' . $serviceTicket->service_code)

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.service-tickets.update', $serviceTicket) }}" class="space-y-6" id="editForm">
        @csrf
        @method('PUT')

        {{-- Service Code Display --}}
        <div class="service-card p-6 rounded-2xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-600 text-xl">
                <i class="fas fa-barcode"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Kode Servis</p>
                <p class="text-lg font-bold text-gray-900 font-mono">{{ $serviceTicket->service_code }}</p>
            </div>
            <div class="ml-auto">
                <span class="badge badge-{{ $serviceTicket->status_color }}">
                    {{ $serviceTicket->status_label }}
                </span>
            </div>
        </div>

        {{-- Status Update Section --}}
        <div class="service-card p-8 rounded-2xl space-y-5">
            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-sync-alt text-red-500"></i> Update Status Servis
            </h3>
            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-600 mb-2">Status Saat Ini *</label>
                <select name="status" required
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        onchange="checkStatusChange(this)">
                    <option value="pending" {{ old('status', $serviceTicket->status) === 'pending' ? 'selected' : '' }}>
                        ⏳ Menunggu Pengecekan
                    </option>
                    <option value="checking" {{ old('status', $serviceTicket->status) === 'checking' ? 'selected' : '' }}>
                        🔍 Sedang Dicek Teknisi
                    </option>
                    <option value="proses" {{ old('status', $serviceTicket->status) === 'proses' ? 'selected' : '' }}>
                        🔧 Sedang Diperbaiki
                    </option>
                    <option value="selesai" {{ old('status', $serviceTicket->status) === 'selesai' ? 'selected' : '' }}>
                        ✅ Sudah Selesai
                    </option>
                    <option value="diambil" {{ old('status', $serviceTicket->status) === 'diambil' ? 'selected' : '' }}>
                        🚚 Sudah Diambil
                    </option>
                </select>
                <p class="text-xs text-gray-400">
                    <i class="fas fa-info-circle"></i> Jika status diubah, sistem akan otomatis redirect ke WhatsApp untuk mengirim notifikasi ke pelanggan.
                </p>
                @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="service-card p-8 rounded-2xl space-y-5">
            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-user text-red-500"></i> Informasi Pelanggan
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama Pelanggan *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $serviceTicket->customer_name) }}" required
                           class="form-input w-full px-4 py-3 rounded-xl text-sm">
                    @error('customer_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nomor WhatsApp *</label>
                    <input type="text" name="phone" value="{{ old('phone', $serviceTicket->phone) }}" required
                           class="form-input w-full px-4 py-3 rounded-xl text-sm">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Perangkat *</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="device_type" value="pc" class="peer sr-only"
                                   {{ old('device_type', $serviceTicket->device_type) === 'pc' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-4 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                <div class="text-2xl mb-1"><i class="fas fa-desktop text-gray-500 peer-checked:text-red-600"></i></div>
                                <span class="text-sm font-medium text-gray-700 peer-checked:text-red-700">PC / Komputer</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="device_type" value="laptop" class="peer sr-only"
                                   {{ old('device_type', $serviceTicket->device_type) === 'laptop' ? 'checked' : '' }}>
                            <div class="text-center px-4 py-4 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                <div class="text-2xl mb-1"><i class="fas fa-laptop text-gray-500 peer-checked:text-red-600"></i></div>
                                <span class="text-sm font-medium text-gray-700 peer-checked:text-red-700">Laptop</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="device_type" value="printer" class="peer sr-only"
                                   {{ old('device_type', $serviceTicket->device_type) === 'printer' ? 'checked' : '' }}>
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
                              class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none">{{ old('problem', $serviceTicket->problem) }}</textarea>
                    @error('problem')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Metadata --}}
        <div class="flex items-center gap-4 text-xs text-gray-500 px-2">
            <span><i class="far fa-calendar-alt"></i> Dibuat: {{ $serviceTicket->created_at->format('d M Y H:i') }}</span>
            <span>•</span>
            <span><i class="far fa-clock"></i> Terakhir update: {{ $serviceTicket->updated_at->format('d M Y H:i') }}</span>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.service-tickets.index') }}"
               class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm" id="submitBtn">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

