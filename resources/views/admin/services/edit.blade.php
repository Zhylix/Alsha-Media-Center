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
                        <option value="software" {{ $service->category === 'software' ? 'selected' : '' }}><i class="fas fa-compact-disc text-red-600"></i> Installasi Software</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Estimasi Hari *</label>
                    <input type="number" name="estimated_days" value="{{ old('estimated_days', $service->estimated_days) }}" required min="1" class="form-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Harga Mulai (Rp)</label>
                    <input type="text"
                        id="priceStartInput"
                        value="{{ old('price_start', $service->price_start) ? 'Rp ' . number_format(old('price_start', $service->price_start), 0, ',', '.') : '' }}"
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Rp 70.000">

                    <input type="hidden"
                        name="price_start"
                        id="priceStartValue"
                        value="{{ old('price_start', $service->price_start) }}">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Harga Maksimal (Rp)</label>
                    <input type="text"
                        id="priceEndInput"
                        value="{{ old('price_end', $service->price_end) ? 'Rp ' . number_format(old('price_end', $service->price_end), 0, ',', '.') : '' }}"
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Kosongkan jika harga tetap">

                    <input type="hidden"
                        name="price_end"
                        id="priceEndValue"
                        value="{{ old('price_end', $service->price_end) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Harga Jasa (Rp) *</label>

                    <input type="text"
                        id="servicePriceInput"
                        value="{{ old('price_jasa', $service->price_jasa) ? 'Rp ' . number_format(old('price_jasa', $service->price_jasa), 0, ',', '.') : '' }}"
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Rp 50.000">

                    <input type="hidden"
                        name="price_jasa"
                        id="servicePriceValue"
                        value="{{ old('price_jasa', $service->price_jasa) }}">
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
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded" {{ $service->is_active ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded" {{ $service->is_featured ? 'checked' : '' }}>
                        <span class="text-gray-700 text-sm"><i class="fas fa-star text-red-600"></i> Featured</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="service-card p-6 rounded-2xl bg-gray-50 border border-gray-200">
            <h3 class="text-sm font-black text-gray-900 mb-3">Sparepart untuk Layanan</h3>
            <p class="text-xs text-gray-500 mb-4">Pilih sparepart yang akan ditampilkan di halaman user untuk layanan ini.</p>

            @php
                $spareparts = \App\Models\Sparepart::query()
                    ->where('is_active', true)
                    ->where('stock', '>', 0)
                    ->with('sparepartCategory')
                    ->orderBy('sparepart_category_id')
                    ->orderBy('sort_order')
                    ->get();

                $selected = $service->spareparts()->pluck('spareparts.id')->toArray();
                $grouped = $spareparts->groupBy(fn($sp) => $sp->sparepartCategory->service_category ?? 'lainnya');
            @endphp

            <div class="space-y-3 max-h-64 overflow-auto pr-2">
                @foreach($grouped as $svcCat => $items)
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-wider text-gray-500 mb-2">{{ $svcCat }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($items as $sp)
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 bg-white hover:border-red-400 cursor-pointer">
                                    <input type="checkbox" name="sparepart_ids[]" value="{{ $sp->id }}" {{ in_array($sp->id, $selected) ? 'checked' : '' }} class="w-4 h-4">
                                    <span class="text-sm text-gray-800">{{ $sp->name }} (Rp {{ number_format($sp->price, 0, ',', '.') }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.services.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 font-semibold text-sm"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white font-semibold text-sm">Perbarui Layanan</button>
        </div>
    </form>
</div>
@push('scripts')
<script>
(function(){

    function formatRupiah(value){
        if(!value) return '';

        return 'Rp ' + Number(value).toLocaleString('id-ID');
    }

    function parseRupiah(value){
        return value.replace(/[^\d]/g, '');
    }

    function setupRupiah(inputId, hiddenId){

        const input = document.getElementById(inputId);
        const hidden = document.getElementById(hiddenId);

        if(!input || !hidden) return;

        input.addEventListener('input', function(){

            const raw = parseRupiah(input.value);

            hidden.value = raw;

            input.value = raw
                ? formatRupiah(raw)
                : '';
        });
    }

    setupRupiah('servicePriceInput', 'servicePriceValue');
    setupRupiah('priceEndInput', 'priceEndValue');
    setupRupiah('priceStartInput', 'priceStartValue');

})();
</script>
@endpush
@endsection
