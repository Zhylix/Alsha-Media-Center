@extends('layouts.admin')
@section('title', 'Edit Sparepart')
@section('page-title', 'Edit Sparepart')
@section('page-subtitle', 'Ubah data sparepart')
@section('content')
<div class="mx-auto max-w-4xl">
    <div class="service-card p-6 sm:p-8 rounded-2xl">
        <form method="POST" action="{{ route('admin.spareparts.update', $sparepart) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Nama Sparepart <span class="text-[#C8000A]">*</span></label>
                <input type="text" name="name" value="{{ old('name', $sparepart->name) }}" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                @error('name')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Gambar</label>
                @if($sparepart->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$sparepart->image) }}" alt="{{ $sparepart->name }}" class="w-28 h-28 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-input px-4 py-2.5 rounded-xl text-sm w-full">
                @error('image')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Deskripsi <span class="text-[#C8000A]">*</span></label>
                <textarea name="description" rows="4" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full resize-none">{{ old('description', $sparepart->description) }}</textarea>
                @error('description')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <!-- Harga + Stok -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Harga (Rp) <span class="text-[#C8000A]">*</span></label>

                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                        <input
                            type="text"
                            id="price_display"                            
                            value="{{ old('price', $sparepart->price) ?  number_format(old('price', $sparepart->price), 0, ',', '.') : '' }}"
                            class="form-input pl-14 pr-4 py-3.5 rounded-xl text-sm w-full"
                            placeholder="1.000.000"
                            autocomplete="off"
                            inputmode="numeric"
                        >

                        <input
                            type="hidden"
                            name="price"
                            id="price"
                            value="{{ old('price', $sparepart->price) }}"
                        >
                    </div>

                    @error('price')
                        <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Stok <span class="text-[#C8000A]">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $sparepart->stock) }}" step="1" min="0" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                    @error('stock')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Kategori Service + Jenis <span class="text-[#C8000A]">*</span></label>
                <select name="sparepart_category_id" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (string) old('sparepart_category_id', $sparepart->sparepart_category_id) === (string) $cat->id ? 'selected' : '' }}>
                            {{ $cat->serviceCategoryLabel }} + {{ $cat->part_type }}
                        </option>
                    @endforeach
                </select>
                @error('sparepart_category_id')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ filter_var(old('is_active', $sparepart->is_active), FILTER_VALIDATE_BOOL) ? 'checked' : '' }} class="h-5 w-5">
                <label for="is_active" class="text-sm text-gray-700 font-semibold">Aktif (tampil di user)</label>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $sparepart->sort_order) }}" min="0" class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl text-white font-bold w-full sm:w-auto">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
                <a href="{{ route('admin.spareparts.index') }}" class="btn-outline px-6 py-3 rounded-xl text-red-600 font-bold w-full sm:w-auto text-center">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const display = document.getElementById('price_display');
    const hidden = document.getElementById('price');

    const formatRupiah = (value) => {
        return new Intl.NumberFormat('id-ID').format(value);
    };

    const updateFormat = () => {
        let value = display.value.replace(/\D/g, '');

        hidden.value = value;

        display.value = value ? formatRupiah(value) : '';
    };

    // format value awal dari database
    if (display.value) {
        updateFormat();
    }

    display.addEventListener('input', updateFormat);
});
</script>
@endpush
@endsection
