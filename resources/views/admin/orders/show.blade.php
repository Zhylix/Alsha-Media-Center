@extends('layouts.admin')
@section('title','Detail Pesanan')
@section('page-title','Detail Pesanan')
@section('page-subtitle', $order->order_number)

@section('content')
<div class="max-w-4xl grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Info -->
    <div class="lg:col-span-2 space-y-5">
        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-clipboard-list text-red-600"></i> Informasi Pesanan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">No. Pesanan</span><span class="text-red-600 font-mono font-bold">{{ $order->order_number }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Layanan</span><span class="text-gray-900">{{ $order->service->name ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Perangkat</span><span class="text-gray-900">{{ $order->device_description }}</span></div>
                <div class="border-t border-red-600/10 pt-3 flex justify-between font-black text-base"><span class="text-gray-900">Total</span><span class="text-gradient" id="detail-total-price">Rp {{ number_format($order->total_price,0,',','.') }}</span></div>
            </div>
        </div>

        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-3"><i class="fas fa-file-alt"></i> Deskripsi Kerusakan</h3>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $order->problem_description }}</p>
        </div>

        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-user text-red-600"></i> Data Pelanggan</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Nama</span><span class="text-gray-900">{{ $order->customer_name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Email</span><span class="text-gray-900">{{ $order->customer_email }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">Telepon</span><span class="text-gray-900">{{ $order->customer_phone }}</span></div>
                @if($order->customer_address)
                <div class="flex justify-between"><span class="text-gray-600">Alamat</span><span class="text-gray-900">{{ $order->customer_address }}</span></div>
                @endif
            </div>
        </div>

        @if($order->created_at)
        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-3"><i class="fas fa-calendar-alt"></i> Riwayat</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Dibuat</span><span class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                @if($order->confirmed_at)
                <div class="flex justify-between"><span class="text-gray-600">Dikonfirmasi</span><span class="text-gray-900">{{ $order->confirmed_at->format('d/m/Y H:i') }}</span></div>
                @endif
                @if($order->completed_at)
                <div class="flex justify-between"><span class="text-gray-600">Selesai</span><span class="text-gray-900">{{ $order->completed_at->format('d/m/Y H:i') }}</span></div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Actions & Status Update -->
    <div class="space-y-5">
        <!-- Current Status -->
        <div class="service-card p-6 rounded-2xl">
            @php $sb=$order->status_badge; @endphp
            <div class="mb-4">
                <span class="badge badge-{{ $sb['color'] }} text-sm">{{ $sb['label'] }}</span>
            </div>
            
            <!-- Quick Actions for Pending Orders -->
            @if(in_array($order->status, ['pending']))
            <div class="flex flex-col gap-3 mb-4">
                <form method="POST" action="{{ route('admin.orders.accept', $order) }}">
                    {{-- Catatan: diskon ini hanya untuk preview real-time di halaman detail. Penyimpanan harga/diskon belum di-handle di backend. --}}

                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Layanan</label>
                            <input type="text" value="{{ $order->service->name ?? '-' }}" disabled class="form-input w-full px-3 py-2.5 rounded-xl text-sm" />
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga Service</label>
                            <input type="number" value="{{ $order->service_price }}" disabled class="form-input w-full px-3 py-2.5 rounded-xl text-sm" id="detail-service-price" />
                        </div>

                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Diskon Service % (real-time)</label>
                            <input type="number" value="{{ $order->service_discount_percent ?? 0 }}" class="form-input w-full px-3 py-2.5 rounded-xl text-sm" id="detail-service-discount-percent" min="0" max="100" step="1" inputmode="numeric" />
                            <p class="text-[11px] text-gray-500 mt-1">Masukkan angka persen diskon (contoh: 10).</p>
                        </div>


                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga Pengiriman</label>
                            <input type="number" value="{{ $order->shipment_price ?? 0 }}" disabled class="form-input w-full px-3 py-2.5 rounded-xl text-sm" id="detail-shipment-price" />
                        </div>

                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Diskon Pengiriman % (real-time)</label>
                            <input type="number" value="{{ $order->shipment_discount_percent ?? 0 }}" class="form-input w-full px-3 py-2.5 rounded-xl text-sm" id="detail-shipment-discount-percent" min="0" max="100" step="1" inputmode="numeric" />
                            <p class="text-[11px] text-gray-500 mt-1">Kosongkan/0 jika tidak ada diskon.</p>
                        </div>


                        <button type="submit" class="btn-primary w-full py-3 rounded-xl text-white text-sm font-semibold">
                            <i class="fas fa-check"></i> Terima Pesanan
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('admin.orders.reject', $order) }}">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Alasan Penolakan (Opsional)</label>
                            <textarea name="notes" rows="2" class="form-input w-full px-3 py-2.5 rounded-xl text-sm resize-none" 
                                      placeholder="Alasan penolakan..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 rounded-xl bg-red-100 text-red-600 border border-red-200 hover:bg-red-200 text-sm font-semibold transition-colors">
                            <i class="fas fa-times"></i> Tolak Pesanan
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>


        <!-- Update Status Manual -->
        <div class="service-card p-6 rounded-2xl">
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Update Status Manual</label>
                    <select name="status" class="form-input w-full px-3 py-2.5 rounded-xl text-sm">
                        @foreach(['pending'=>'Menunggu','diterima'=>'Diterima','ditolak'=>'Ditolak','in_progress'=>'Diproses','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ $order->status===$val?'selected':'' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Catatan Admin</label>
                    <textarea name="notes" rows="3" class="form-input w-full px-3 py-2.5 rounded-xl text-sm resize-none">{{ $order->notes }}</textarea>
                </div>
                <button type="submit" class="btn-primary w-full py-3 rounded-xl text-white text-sm font-semibold">Update Status</button>
            </form>
        </div>

        

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const servicePriceEl = document.getElementById('detail-service-price');
            const shipmentPriceEl = document.getElementById('detail-shipment-price');
            const serviceDiscountEl = document.getElementById('detail-service-discount-percent');
            const shipmentDiscountEl = document.getElementById('detail-shipment-discount-percent');
            const totalEl = document.getElementById('detail-total-price');

            if (!servicePriceEl || !shipmentPriceEl || !serviceDiscountEl || !shipmentDiscountEl || !totalEl) return;

            function toNumber(input) {
                const n = parseFloat(input.value);
                return Number.isFinite(n) ? n : 0;
            }

            function calcAfter(price, percent) {
                const p = Math.min(100, Math.max(0, percent));
                return price - (price * p / 100);
            }

            function updateTotal() {
                const serviceAfter = calcAfter(toNumber(servicePriceEl), toNumber(serviceDiscountEl));
                const shipmentAfter = calcAfter(toNumber(shipmentPriceEl), toNumber(shipmentDiscountEl));
                const total = serviceAfter + shipmentAfter;
                totalEl.textContent = `Rp ${Math.round(total).toLocaleString('id-ID')}`;
            }

            [serviceDiscountEl, shipmentDiscountEl].forEach(el => {
                el.addEventListener('input', updateTotal);
            });

            updateTotal();
        });
        </script>

        <!-- Navigation -->
        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.orders.index') }}" class="btn-outline text-center py-3 rounded-xl text-red-600 text-sm font-semibold">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full py-3 rounded-xl bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 text-sm font-semibold transition-colors">
                    <i class="fas fa-trash-alt text-red-400"></i> Hapus Pesanan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
