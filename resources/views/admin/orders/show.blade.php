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
                <div class="border-t border-red-600/10 pt-3 flex justify-between font-black text-base"><span class="text-gray-900">Total</span><span class="text-gradient">Rp {{ number_format($order->total_price,0,',','.') }}</span></div>
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
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Layanan</label>
                            <select name="service_id" class="form-input w-full px-3 py-2.5 rounded-xl text-sm">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($services ?? [] as $service)
                                <option value="{{ $service->id }}" {{ $order->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga Service</label>
                            <input type="number" name="service_price" value="{{ $order->service_price }}" 
                                   class="form-input w-full px-3 py-2.5 rounded-xl text-sm" placeholder="0" id="service-price-input">
                        </div>

                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Diskon Service % (opsional)</label>
                            <input type="number" name="service_discount_percent" value="{{ old('service_discount_percent', $order->service_discount_percent ?? 0) }}"
                                   min="0" max="100" step="1" class="form-input w-full px-3 py-2.5 rounded-xl text-sm" placeholder="0" id="service-discount-percent-input">
                        </div>

                        <div class="mt-2 text-sm">
                            <p class="text-gray-600">Harga Asli: <span class="font-semibold text-gray-900 line-through" id="service-original-price">Rp {{ number_format((float)($order->service_price ?? 0),0,',','.') }}</span></p>
                            <p class="text-gray-600">Harga Setelah Diskon: <span class="font-black text-[#C8000A]" id="service-discounted-price">Rp {{ number_format((float)($order->service_price ?? 0),0,',','.') }}</span></p>
                            <p class="text-xs text-gray-500 mt-1">Diskon: <span class="font-semibold" id="service-discount-percent-label">{{ (float)($order->service_discount_percent ?? 0) }}%</span></p>
                        </div>

                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga Pengiriman</label>
                            <input type="number" name="shipment_price" value="{{ $order->shipment_price ?? 0 }}"
                                   min="0" step="1000" class="form-input w-full px-3 py-2.5 rounded-xl text-sm" placeholder="0" id="shipment-price-input">
                        </div>

                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Diskon Pengiriman % (opsional)</label>
                            <input type="number" name="shipment_discount_percent" value="{{ old('shipment_discount_percent', $order->shipment_discount_percent ?? 0) }}"
                                   min="0" max="100" step="1" class="form-input w-full px-3 py-2.5 rounded-xl text-sm" placeholder="0" id="shipment-discount-percent-input">
                        </div>

                        <div class="mt-2 text-sm">
                            <p class="text-gray-600">Harga Asli: <span class="font-semibold text-gray-900 line-through" id="shipment-original-price">Rp {{ number_format((float)($order->shipment_price ?? 0),0,',','.') }}</span></p>
                            <p class="text-gray-600">Harga Setelah Diskon: <span class="font-black text-[#C8000A]" id="shipment-discounted-price">Rp {{ number_format((float)($order->shipment_price ?? 0),0,',','.') }}</span></p>
                            <p class="text-xs text-gray-500 mt-1">Diskon: <span class="font-semibold" id="shipment-discount-percent-label">{{ (float)($order->shipment_discount_percent ?? 0) }}%</span></p>
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
                        @foreach(['pending'=>'Menunggu','diterima'=>'Diterima','ditolak'=>'Ditolak','confirmed'=>'Dikonfirmasi','in_progress'=>'Diproses','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $val=>$lbl)
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
