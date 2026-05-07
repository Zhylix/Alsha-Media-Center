@extends('layouts.admin')
@section('title', 'Buat Pesanan Baru')
@section('page-title', 'Pesanan Baru')
@section('page-subtitle', 'Input data pesanan pelanggan')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.orders.store') }}" class="space-y-6">
        @csrf
        
        {{-- Customer Info --}}
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-user"></i> Data Pelanggan</h3>
            <div class="grid-2">
                <div>
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="customer_name" required class="form-input" placeholder="Nama pelanggan">
                </div>
                <div>
                    <label class="form-label">No. WhatsApp/HP *</label>
                    <input type="tel" name="customer_phone" required class="form-input" placeholder="08123456789">
                </div>
            </div>
            <div>
                <label class="form-label">Email (opsional)</label>
                <input type="email" name="customer_email" class="form-input" placeholder="email@contoh.com">
            </div>
        </div>

        {{-- Service Selection --}}
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-tools"></i> Layanan *</h3>
            <div class="grid-2">
                <div>
                    <label class="form-label">Pilih Layanan</label>
                    <select name="service_id" required class="form-input">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Harga Layanan *</label>
                    <input type="number" name="service_price" required min="0" step="1000" class="form-input" placeholder="0" id="service-price-input">
                </div>
                <div>
                    <label class="form-label">Diskon Layanan % (opsional)</label>
                    <input type="number" name="service_discount_percent" min="0" max="100" step="1" class="form-input" placeholder="0" id="service-discount-percent-input" inputmode="numeric">
                    <p class="text-xs text-gray-500 mt-1">Masukkan angka persen diskon (contoh: 10 = 10%).</p>
                </div>
            </div>
        </div>

        {{-- Pricing --}}
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-coins"></i> Harga & Pengiriman</h3>
            <div class="grid-2">
                <div>
                    <label class="form-label">Biaya Pengiriman</label>
                    <input type="number" name="shipment_price" min="0" step="1000" class="form-input" placeholder="0" id="shipment-price-input">
                </div>
                <div>
                    <label class="form-label">Diskon Pengiriman % (opsional)</label>
                    <input type="number" name="shipment_discount_percent" min="0" max="100" step="1" class="form-input" placeholder="0" id="shipment-discount-percent-input">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan/isi 0 jika tidak ada diskon.</p>
                </div>
                <div id="total-price-display" class="text-2xl font-bold text-red-600 mt-1">
                    Total: Rp 0
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-sticky-note"></i> Catatan</h3>
            <textarea name="notes" rows="4" class="form-input" placeholder="Catatan tambahan untuk pesanan ini..."></textarea>
        </div>

        <div class="flex gap-4 pt-4">
            <a href="{{ route('admin.orders.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">
                <i class="fas fa-save"></i> Simpan Pesanan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const servicePrice = document.querySelector('input[name="service_price"]');
    const serviceDiscountPercent = document.querySelector('input[name="service_discount_percent"]');
    const shipmentPrice = document.querySelector('input[name="shipment_price"]');
    const shipmentDiscountPercent = document.querySelector('input[name="shipment_discount_percent"]');
    const totalDisplay = document.getElementById('total-price-display');

    function discounted(amount, percent) {
        const p = parseFloat(percent.value) || 0;
        const a = parseFloat(amount.value) || 0;
        const safeP = Math.min(100, Math.max(0, p));
        return a - (a * safeP / 100);
    }

    function updateTotal() {
        const serviceAfter = discounted(servicePrice, serviceDiscountPercent);
        const shipmentAfter = discounted(shipmentPrice, shipmentDiscountPercent);
        const total = serviceAfter + shipmentAfter;
        totalDisplay.textContent = `Total: Rp ${Math.round(total).toLocaleString('id-ID')}`;
    }

    [servicePrice, serviceDiscountPercent, shipmentPrice, shipmentDiscountPercent].forEach(el => {
        if (el) el.addEventListener('input', updateTotal);
    });

    updateTotal();
});
</script>
@endsection

