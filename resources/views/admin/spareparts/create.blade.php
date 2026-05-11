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

        {{-- Step 1: Kategori Service --}}
        <div id="step1" class="space-y-3">
            <div>

                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                    Kategori Service <span class="text-[#C8000A]">*</span>
                </label>
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

            <button type="button" id="toStep2" class="btn-primary px-6 py-3 rounded-xl text-white font-bold">
                Lanjut
            </button>

            {{-- Step 2: Jenis Sparepart di bawah Kategori (tetap tampil sebagai langkah 2) --}}
            <div class="hidden" id="jenisPreview" aria-hidden="true"></div>
        </div>

        {{-- Step 2: Jenis Sparepart (final submit) --}}
            <div id="step2" class="space-y-3 hidden">
                <div class="rounded-xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-700 font-semibold">
                    Jenis Sparepart
            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                Jenis Sparepart <span class="text-[#C8000A]">*</span>
            </label>

            <select name="part_type" id="partTypeSelect" required class="form-input px-4 py-3.5 rounded-xl text-sm w-full">
                <option value="">-- Pilih jenis --</option>
                @if(old('service_category'))
                    @foreach($partTypesByService->get(old('service_category'), collect())->pluck('part_type')->unique()->values() as $pt)
                        <option value="{{ $pt }}" {{ old('part_type') === $pt ? 'selected' : '' }}>{{ $pt }}</option>
                    @endforeach
                @endif
                <option value="__new__">+ Tambah jenis baru...</option>
            </select>
            @error('part_type')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror

            {{-- Input untuk jenis sparepart baru --}}
            <div id="newPartTypeContainer" class="hidden">
                <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                    Jenis Sparepart Baru <span class="text-[#C8000A]">*</span>
                </label>
                <input type="text" name="new_part_type" id="newPartTypeInput" 
                       class="form-input px-4 py-3.5 rounded-xl text-sm w-full" 
                       placeholder="Contoh: SSD NVMe, RAM DDR5, dll.">
                @error('new_part_type')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            {{-- hidden untuk menyimpan kombinasi service + part_type --}}
            <input type="hidden" name="sparepart_category_id" id="sparepartCategoryId" value="" required>
            @error('sparepart_category_id')<p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>@enderror

            <p class="text-[11px] text-gray-500 mt-1">Sparepart dipilih berdasarkan kombinasi service + jenis.</p>

            <div class="flex items-center gap-3">
                <button type="button" id="backToStep1" class="btn-outline px-6 py-3 rounded-xl text-red-600 font-bold">
                    Kembali
                </button>
            </div>
        </div>


        <div class="flex items-center gap-3">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ filter_var(old('is_active'), FILTER_VALIDATE_BOOL) ? 'checked' : '' }} class="h-5 w-5">
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
        const newPartTypeContainer = document.getElementById('newPartTypeContainer');
        const newPartTypeInput = document.getElementById('newPartTypeInput');

        function setHiddenSpareCategoryId(){
            const sc = serviceSel.value;
            const pt = partSel.value;
            
            if (pt === '__new__') {
                // Jika memilih tambah jenis baru, kosongkan sparepart_category_id
                spareCatIdEl.value = '';
                newPartTypeContainer.classList.remove('hidden');
                newPartTypeInput.required = true;
                newPartTypeInput.focus();
            } else {
                // Jika memilih jenis yang sudah ada
                const match = categories.find(c => c.service_category === sc && c.part_type === pt);
                spareCatIdEl.value = match ? match.id : '';
                newPartTypeContainer.classList.add('hidden');
                newPartTypeInput.required = false;
                newPartTypeInput.value = '';
            }
        }

        function refreshPartTypes(){
            const sc = serviceSel.value;
            const pts = [...new Set(categories.filter(c => c.service_category === sc).map(c => c.part_type))];

            partSel.innerHTML = '<option value="">-- Pilih jenis --</option>' +
                pts.map(pt => `<option value="${pt}">${pt}</option>`).join('') +
                '<option value="__new__">+ Tambah jenis baru...</option>';

            spareCatIdEl.value = '';
            newPartTypeContainer.classList.add('hidden');
            newPartTypeInput.required = false;
            newPartTypeInput.value = '';
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
        const oldService = @json(old('service_category'));
        const oldPart = @json(old('part_type'));
        const oldNewPart = @json(old('new_part_type'));
        
        if(oldService){
            serviceSel.value = oldService;
            refreshPartTypes();
        }
        
        if(oldNewPart){
            // Jika ada new_part_type dari old data, set ke __new__ dan tampilkan input
            partSel.value = '__new__';
            newPartTypeInput.value = oldNewPart;
            newPartTypeContainer.classList.remove('hidden');
            newPartTypeInput.required = true;
        } else if(oldPart){
            partSel.value = oldPart;
        }
        
        // jika sparepart_category_id sudah terisi (mis. submit gagal lalu balikan)
        if(spareCatIdEl && spareCatIdEl.value && !oldNewPart){
            const match = categories.find(c => c.id == spareCatIdEl.value);
            if(match){
                serviceSel.value = match.service_category;
                refreshPartTypes();
                partSel.value = match.part_type;
            }
        }
        setHiddenSpareCategoryId();

        // jika step 2 sudah valid terpilih, tampilkan step 2
        const step1El = document.getElementById('step1');
        const step2El = document.getElementById('step2');
        if(step1El && step2El){
            if(serviceSel.value && (partSel.value || (partSel.value === '__new__' && newPartTypeInput.value.trim()))){
                step1El.classList.add('hidden');
                step2El.classList.remove('hidden');
            }
        }

        // step navigation
        const toStep2Btn = document.getElementById('toStep2');
        const backToStep1Btn = document.getElementById('backToStep1');

        if(toStep2Btn){
            toStep2Btn.addEventListener('click', function(){
                if(!serviceSel.value){
                    serviceSel.reportValidity && serviceSel.reportValidity();
                    return;
                }
                // isi part type list berdasarkan kategori
                refreshPartTypes();
                // pindah step
                if(step1El && step2El){
                    step1El.classList.add('hidden');
                    step2El.classList.remove('hidden');
                }
                // reset hidden id
                spareCatIdEl.value = '';
                // focus ke part type select
                partSel.focus();
            });
        }

        if(backToStep1Btn){
            backToStep1Btn.addEventListener('click', function(){
                if(step1El && step2El){
                    step2El.classList.add('hidden');
                    step1El.classList.remove('hidden');
                }
                // saat kembali ke step 1, reset jenis
                partSel.value = '';
                spareCatIdEl.value = '';
            });
        }

        // Form submit validation
        const form = document.querySelector('form');
        if(form){
            form.addEventListener('submit', function(e){
                if(partSel.value === '__new__'){
                    if(!newPartTypeInput.value.trim()){
                        e.preventDefault();
                        newPartTypeInput.reportValidity && newPartTypeInput.reportValidity();
                        newPartTypeInput.focus();
                        return false;
                    }
                }
            });
        }

    })();
</script>
@endpush
@endsection

