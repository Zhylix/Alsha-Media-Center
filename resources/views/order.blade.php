@extends('layouts.app')
@section('title', 'Buat Pesanan Service')
@section('content')
<section class="relative py-24 bg-hero overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Pemesanan</span>
        <h1 class="text-4xl font-black text-gray-900 mt-3 mb-4">Buat <span class="text-gradient">Pesanan Service</span></h1>
        <p class="text-gray-600">Isi form di bawah ini dengan lengkap untuk memproses pesanan Anda.</p>
    </div>
</section>

<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('order.store') }}" class="space-y-8">
            @csrf

            <!-- Customer Info -->
            <div class="service-card p-8 rounded-2xl" data-animate>
                <h2 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-2"><i class="fas fa-user text-red-600"></i> <span>Informasi Pelanggan</span></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Nama Lengkap *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Nama lengkap Anda">
                        @error('customer_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">No. Telepon / WA *</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="08xx-xxxx-xxxx">
                        @error('customer_phone')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Email *</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="email@example.com">
                        @error('customer_email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Alamat Lengkap</label>
                        <input type="text" name="customer_address" value="{{ old('customer_address') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Jl. ... (untuk antar jemput)">
                    </div>
                </div>
            </div>

            <!-- Service Selection -->
            <div class="service-card p-8 rounded-2xl" data-animate>
                <h2 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-2"><i class="fas fa-wrench text-red-600"></i> <span>Pilih Layanan</span></h2>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Layanan *</label>
                    <select name="service_id" id="serviceSelect" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services->groupBy('category') as $cat => $catServices)
                        <optgroup label="{{ $cat === 'laptop' ? 'Laptop' : ($cat === 'printer' ? 'Printer' : 'HP') }}">
                            @foreach($catServices as $svc)
                            <option value="{{ $svc->id }}" data-price="{{ $svc->price_start }}" {{ (old('service_id') == $svc->id || ($service && $service->id == $svc->id)) ? 'selected' : '' }}>
                                {{ $svc->name }} - {{ $svc->price_range }}
                            </option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                    @error('service_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Nama / Tipe Perangkat *</label>
                        <input type="text" name="device_description" value="{{ old('device_description') }}" required class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Contoh: Laptop Asus X415 / iPhone 13">
                        @error('device_description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Catatan Tambahan</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" class="form-input w-full px-4 py-3 rounded-xl text-sm" placeholder="Catatan lainnya (opsional)">
                    </div>
                </div>
                <div class="mt-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Deskripsi Kerusakan *</label>
                    <textarea name="problem_description" required rows="4" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none" placeholder="Jelaskan detail kerusakan yang dialami perangkat Anda...">{{ old('problem_description') }}</textarea>
                    @error('problem_description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Order Summary -->
            <div class="service-card p-8 rounded-2xl bg-red-600/5 border-red-600/20" data-animate>
                <h2 class="text-xl font-black text-gray-900 mb-4"><i class="fas fa-clipboard-list text-red-600"></i> Ringkasan Pesanan</h2>
                <div id="orderSummary" class="text-gray-600 text-sm">Pilih layanan dan pengiriman untuk melihat estimasi total.</div>
            </div>

            <div class="flex gap-4" data-animate>
                <a href="{{ route('services.index') }}" class="btn-outline flex-1 text-center py-4 rounded-2xl text-red-600 font-bold">← Kembali</a>
                <button type="submit" class="btn-primary flex-1 py-4 rounded-2xl text-white font-bold"><i class="fas fa-wrench text-red-600"></i> Buat Pesanan →</button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
const serviceSelect = document.getElementById('serviceSelect');
const serviceData = {
    @foreach($services as $svc)
    {{ $svc->id }}: { price: {{ $svc->price_start }}, name: '{{ addslashes($svc->name) }}' },
    @endforeach
};

function updateSummary() {
    const serviceId = serviceSelect.value;
    const summary = document.getElementById('orderSummary');

    if (!serviceId) { summary.innerHTML = '<p>Pilih layanan untuk melihat estimasi total.</p>'; return; }

    const svc = serviceData[serviceId];

    summary.innerHTML = `
        <div class="space-y-3">
            <div class="flex justify-between"><span>Layanan: ${svc.name}</span><span class="text-gray-900 font-semibold">Rp ${svc.price.toLocaleString('id-ID')}</span></div>
            <div class="border-t border-red-600/20 pt-3 flex justify-between text-lg font-black"><span class="text-gray-900">Total Estimasi</span><span class="text-gradient">Rp ${svc.price.toLocaleString('id-ID')}</span></div>
            <p class="text-xs text-gray-500">* Harga final akan dikonfirmasi setelah diagnosa perangkat</p>
        </div>
    `;
}

serviceSelect.addEventListener('change', updateSummary);
</script>
@endpush
