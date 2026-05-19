@extends('layouts.app')
@section('title', $service->name)
@section('content')
<section class="relative py-32 bg-hero overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center gap-2 text-gray-500 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-900">Beranda</a> /
            <a href="{{ route('services.index') }}" class="hover:text-gray-900">Layanan</a> /
            <a href="{{ route('services.'.$service->category) }}" class="hover:text-gray-900">{{ $service->category_label }}</a> /
            <span class="text-red-600">{{ $service->name }}</span>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="badge badge-{{ $service->category === 'laptop' ? 'blue' : ($service->category === 'printer' ? 'purple' : 'green') }} mb-4 inline-block">{{ $service->category_label }}</span>
                <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $service->name }}</h1>
                <p class="text-gray-600 text-lg mb-6">{{ $service->short_description }}</p>
                
                {{-- Sparepart Section (dynamic) - placed under WhatsApp button as requested --}}
            
                <div class="flex items-start justify-between gap-6 flex-col lg:flex-row">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 mb-2">pilih sparepart untuk {{ $service->category_label }}</h2>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            Pilih sparepart untuk estimasi total harga.
                        </p>
                    </div>
                </div>

                <div class="mt-2 space-y-6" id="sparepartContainer" data-service-category="{{ $service->category }}" data-service-price-jasa="{{ (float) ($service->price_jasa ?? $service->price_start) }}">
                    <input type="hidden" id="servicePriceJasaValue" value="{{ (float) ($service->price_jasa ?? $service->price_start) }}">
                    @php
                        $spareparts = $spareparts ?? collect();
                        $grouped = $spareparts->groupBy(function($sp) {
                            return $sp->sparepartCategory->part_type ?? 'Lainnya';
                        });
                    @endphp

                    @if($grouped->count() === 0)
                        <div class="text-gray-500 text-sm">
                            Belum ada data sparepart untuk kategori ini. Sparepart dipilih secara single untuk estimasi total.
                        </div>
                    @else
                        @foreach($grouped as $partType => $items)
                            <div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3 mt-4">
                                    @foreach($items->sortBy('sort_order') as $spare)
                                        @php
                                            $isDisabled = false;
                                            $price = (float) ($spare->price ?? 0);
                                        @endphp

                                        <button
                                            type="button"
                                            class="sparepart-option group text-left rounded-2xl border border-gray-300 p-4 transition-all duration-200 
                                                    {{ $isDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:border-red-400 hover:shadow-sm hover:translate-y-[-1px]' }}"
                                            data-sparepart-id="{{ $spare->id }}"
                                            data-sparepart-name="{{ $spare->name }}"
                                            data-sparepart-price="{{ $price }}"
                                            data-sparepart-service-price="{{ (float) ($spare->service_price ?? $service->price_start) }}"
                                            data-service-price="{{ (float) $service->price_start }}"
                                            data-sparepart-stock="{{ $spare->stock ?? 0 }}"
                                            data-part-type="{{ $partType }}"
                                            {{ $isDisabled ? 'disabled' : '' }}
                                        >
                                            <div class="flex items-start gap-3">
                                                <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                                                    @if($spare->image)
                                                        <img src="{{ asset('storage/'.$spare->image) }}" alt="{{ $spare->name }}" class="w-full h-full object-cover rounded-xl" onerror="this.style.display='none'">
                                                    @else
                                                        <i class="fas fa-box-open text-white"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-black text-gray-900 truncate">{{ $spare->name }}</p>
                                                    <p class="text-red-600 font-bold text-sm mt-1">Rp {{ number_format($spare->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ Str::limit($spare->description ?? '', 80) }}</p>
                                            </div>
                                            <input type="hidden" name="selected_sparepart_id" value="">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    @endif
                </div>
            
                <div class="flex flex-wrap gap-4 mt-4">
                    <a href="https://wa.me/{{ preg_replace('/\D/','',optional($store)->whatsapp ?? '6281234567890') }}?text=Halo, saya ingin tanya tentang {{ $service->name }}" target="_blank" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-white font-bold"><i class="fab fa-whatsapp"></i> Tanya via WhatsApp</a>
                </div>
            </div>
            <div class="service-card p-8 rounded-2xl">
                <div class="text-6xl text-center mb-4">
                    {!! $service->category === 'laptop'
                        ? '<i class="fas fa-laptop text-red-600"></i>'
                        : ($service->category === 'printer'
                            ? '<i class="fas fa-print text-red-600"></i>'
                            : ($service->category === 'software'
                                ? '<i class="fas fa-compact-disc text-red-600"></i>'
                                : '<i class="fas fa-desktop text-red-600"></i>'
                            )
                        ) !!}
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between" data-service-price>
                        <span class="text-gray-600 text-sm">Harga Jasa</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($service->price_jasa ?? $service->price_start, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-red-600/10">
                        <span class="text-gray-600 text-sm">Harga Sparepart</span>
                        <span class="font-semibold text-gray-900" id="selectedSparepartPrice">Rp 0</span>
                    </div>
                    <div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-lg text-black font-semibold">Total Harga</span>
                            <span class="text-red-600 font-semibold text-lg" id="selectedTotalPrice">Rp {{ number_format((float) ($service->price_jasa ?? $service->price_start), 0, ',', '.') }}</span>
                        </div>
                        <span class="text-sm text-gray-500">Total dihitung realtime (jasa + sparepart).</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="service-card p-8 rounded-2xl mb-8" data-animate>
            <h2 class="text-2xl font-black text-gray-900 mb-4">Deskripsi Layanan</h2>
            <p class="text-gray-600 leading-relaxed">{{ $service->description }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10" data-animate>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-check text-red-600"></i></div>
                <p class="text-gray-900 font-semibold text-sm">Garansi 30 Hari</p>
            </div>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-cogs text-gray-600"></i></div>
                <p class="text-gray-900 font-semibold text-sm">Spare Part Original</p>
            </div>
            <div class="service-card p-5 rounded-2xl text-center">
                <div class="text-3xl mb-2"><i class="fas fa-bolt text-red-600"></i></div>
                <p class="text-gray-900 font-semibold text-sm">Teknisi Berpengalaman</p>
            </div>
        </div>

    </div>
</section>

@if($related->count() > 0)
<section class="py-24 bg-white" id="related">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-5">
                <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                    @php
                    $icons = ['laptop' => 'fa-laptop', 'printer' => 'fa-print', 'pc' => 'fa-desktop', 'software' => 'fa-compact-disc'];
                    $icon = $icons[$service->category] ?? 'fa-wrench';
                    @endphp
                    <i class="fas {{ $icon }} text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-0.5">Kategori</div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Installasi <span class="text-[#C8000A]">Terkait</span></h2>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center gap-2 text-xs font-black text-gray-400 uppercase tracking-wider">Layanan Terkait</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($related as $service)
            <div class="group relative bg-white rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 hover:-translate-y-0.5 border border-gray-300">
                <div class="absolute -right-1 -top-1 w-3 h-3 bg-[#C8000A] opacity-0 group-hover:opacity-100 transition-opacity rounded-xl scale-0 group-hover:scale-100"></div>

                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#C8000A] to-[#E0000A] flex items-center justify-center rounded-xl shadow-lg flex-shrink-0">
                        @php
                        $icons = ['laptop' => 'fa-laptop', 'printer' => 'fa-print', 'pc' => 'fa-desktop', 'software' => 'fa-compact-disc'];
                        $icon = $icons[$service->category] ?? 'fa-wrench';
                        @endphp
                        <i class="fas {{ $icon }} text-white text-xl"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-gray-900 text-base leading-tight">{{ $service->name }}</h3>

                            @if($service->is_featured)
                            <span class="flex-shrink-0 px-2.5 py-1 bg-red-100 text-[#C8000A] text-[10px] font-bold uppercase tracking-wide rounded-full">
                                Populer
                            </span>
                            @endif
                        </div>

                        <p class="text-gray-500 text-sm leading-relaxed mt-1 line-clamp-2">
                            {{ $service->short_description ?? Str::limit($service->description, 100) }}
                        </p>
                    </div>
                </div>

                <div class="h-px bg-gray-200 mb-4"></div>

                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-gray-50 rounded-xl px-4 py-2.5 shadow-sm flex-[2]">
                        <div class="flex items-center gap-2 text-gray-400 text-[10px] uppercase font-semibold">
                            <i class="fas fa-tag text-[8px] text-[#C8000A]"></i>
                            Harga
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">{{ $service->price_range }}</div>
                    </div>

                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 shadow-sm flex-1">
                        <div class="flex items-center gap-1.5 text-gray-400 text-[9px] uppercase font-semibold">
                            <i class="fas fa-clock text-[7px] text-[#C8000A]"></i>
                            Estimasi
                        </div>
                        <div class="text-gray-900 font-bold text-xs mt-0.5">{{ $service->estimated_days }} hari</div>
                    </div>
                </div>

                <a href="{{ route('services.show', $service->slug) }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 w-full
                          bg-[#C8000A] text-white text-xs font-bold uppercase tracking-wide rounded-xl
                          hover:bg-[#A00008] transition-all shadow-md hover:shadow-lg">
                    Detail
                    <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
    (function(){
        const options = document.querySelectorAll('.sparepart-option');
        const selectedSparepartPriceEl = document.getElementById('selectedSparepartPrice');
        const selectedTotalPriceEl = document.getElementById('selectedTotalPrice');

        const baseServicePrice = parseFloat(document.getElementById('servicePriceJasaValue')?.value || '0');

        const formatRp = (n) => {
            try {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n));
            } catch (e) {
                return 'Rp ' + Math.round(n);
            }
        };

        let selected = null;

        function clearSelection(){
            options.forEach(btn => {
                btn.classList.remove('border-[#C8000A]', 'bg-red-50', 'shadow-sm');
                btn.querySelector('.sparepart-check')?.classList.add('hidden');
            });
        }

        options.forEach(btn => {
            btn.addEventListener('click', function(){
                if (btn.disabled) return;

                const spareId = btn.dataset.sparepartId || '';

                // toggle: klik lagi pada card yang sudah terpilih => kembali ke mode tanpa sparepart
                if (selected && selected === spareId) {
                    clearSelection();
                    selectedSparepartPriceEl.textContent = formatRp(0);
                    selectedTotalPriceEl.textContent = formatRp(baseServicePrice);
                    selected = null;
                    return;
                }

                clearSelection();
                btn.classList.add('border-[#C8000A]', 'bg-red-50', 'shadow-sm');
                btn.querySelector('.sparepart-check')?.classList.remove('hidden');

                const sparePrice = parseFloat(btn.dataset.sparepartPrice || '0');
                const spareServicePrice = parseFloat(btn.dataset.sparepartServicePrice || 'NaN');

                // Requirements: harga jasa selalu dari services.price_jasa
                const jasaPrice = baseServicePrice;
                const total = jasaPrice + sparePrice;

                selectedSparepartPriceEl.textContent = formatRp(sparePrice);
                selectedTotalPriceEl.textContent = formatRp(total);
                selected = spareId;
            });
        });
    })();
</script>
@endpush
@endsection

