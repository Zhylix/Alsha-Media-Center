@extends('layouts.admin')
@section('title', 'Tambah Sparepart')
@section('page-title', 'Tambah Sparepart')
@section('page-subtitle', 'Input sparepart baru')

@section('content')
<div class="service-card p-6 rounded-2xl">
    <form method="POST" action="{{ route('admin.spareparts.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                Nama Sparepart <span class="text-[#C8000A]">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
            @error('name')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                Gambar <span class="text-[#C8000A]">*</span>
            </label>
            <input type="file" name="image" accept="image/*" required class="form-input px-4 py-2.5 rounded-xl text-sm w-full">
            @error('image')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Deskripsi <span class="text-[#C8000A]">*</span></label>
            <textarea name="description" rows="4" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full resize-none">{{ old('description') }}</textarea>
            @error('description')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Harga (Rp) <span class="text-[#C8000A]">*</span></label>
                <input type="number" name="price" value="{{ old('price') }}" step="1" min="0" required
                       class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                @error('price')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Stok <span class="text-[#C8000A]">*</span></label>
                <input type="number" name="stock" value="{{ old('stock') }}" step="1" min="0" required
                       class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                @error('stock')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        @php
            $serviceTypes = $categories->pluck('service_category')->unique()->values();
            $partTypesByService = $categories->groupBy('service_category');
        @endphp

        {{-- Display cascading selection, but store sparepart_category_id as hidden --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Kategori Service <span class="text-[#C8000A]">*</span></label>
                <select name="service_category" id="serviceCategorySelect" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                    <option value="">-- Pilih service --</option>
                    @foreach($serviceTypes as $sc)
                        <option value="{{ $sc }}" {{ old('service_category') === $sc ? 'selected' : '' }}>
                            {{ match($sc) {
                                'pc' => 'PC / Komputer',
                                'laptop' => 'Laptop',
                                'printer' => 'Printer',
                                'software' => 'Installasi Software',
                                default => ucfirst($sc),
                            } }}
                        </option>
                    @endforeach
                </select>
                @error('service_category')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Jenis Sparepart <span class="text-[#C8000A]">*</span></label>
                <select name="part_type" id="partTypeSelect" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                    <option value="">-- Pilih jenis --</option>
                    @if(old('service_category'))
                        @foreach($partTypesByService->get(old('service_category'), collect())->pluck('part_type')->unique()->values() as $pt)
                            <option value="{{ $pt }}" {{ old('part_type') === $pt ? 'selected' : '' }}>{{ $pt }}</option>
                        @endforeach
                    @endif
                </select>
                @error('part_type')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- hidden untuk menyimpan kombinasi service + part_type --}}
        <input type="hidden" name="sparepart_category_id" id="sparepartCategoryId" value="{{ old('sparepart_category_id') }}" required>
        @error('sparepart_category_id')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
        <p class="text-[11px] text-gray-500 mt-1">Sparepart dipilih berdasarkan kombinasi service + jenis.</p>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" {{ old('is_active') ? 'checked' : '' }} class="h-5 w-5">
            <label for="is_active" class="text-sm text-gray-700 font-semibold">Aktif (tampil di user)</label>
        </div>

        <div>
            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-6 py-3 rounded-xl text-white font-bold">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('admin.spareparts.index') }}" class="btn-outline px-6 py-3 rounded-xl text-red-600 font-bold">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    (function(){
        const categories = @json($categories->map(fn($c)=>[
            'id'=>$c->id,
            'service_category'=>$c->service_category,
            'part_type'=>$c->part_type
        ]));

        const serviceSel = document.getElementById('serviceCategorySelect');
        const partSel = document.getElementById('partTypeSelect');
        const spareCatIdEl = document.getElementById('sparepartCategoryId');

        function setHiddenSpareCategoryId(){
            const sc = serviceSel.value;
            const pt = partSel.value;
            const match = categories.find(c => c.service_category === sc && c.part_type === pt);
            spareCatIdEl.value = match ? match.id : '';
        }

        function refreshPartTypes(){
            const sc = serviceSel.value;
            const pts = [...new Set(categories.filter(c => c.service_category === sc).map(c => c.part_type))];

            partSel.innerHTML = '<option value="">-- Pilih jenis --</option>' +
                pts.map(pt => `<option value="${pt}">${pt}</option>`).join('');

            spareCatIdEl.value = '';
        }

        if(serviceSel){
            serviceSel.addEventListener('change', function(){
                refreshPartTypes();
            });
        }

        if(partSel){
            partSel.addEventListener('change', function(){
                setHiddenSpareCategoryId();
            });
        }

        // init from old() values
        if(serviceSel.value){
            refreshPartTypes();
            // attempt to re-set old selected part_type
            const oldPart = @json(old('part_type'));
            if(oldPart){
                partSel.value = oldPart;
            }
            setHiddenSpareCategoryId();
        }
        if(!serviceSel.value){
            // nothing
        }
        // If no service old value, but sparepart_category_id exists, derive service/part
        if((!serviceSel.value || !partSel.value) && spareCatIdEl.value){
            const match = categories.find(c => c.id == spareCatIdEl.value);
            if(match){
                serviceSel.value = match.service_category;
                refreshPartTypes();
                partSel.value = match.part_type;
                setHiddenSpareCategoryId();
            }
        }
    })();
</script>
@endpush
@endsection

