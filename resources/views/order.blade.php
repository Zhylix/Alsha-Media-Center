@extends('layouts.app')
@section('title', 'Pesanan |Alsha Media Center')
@section('content')

<!-- ===================== HERO ===================== -->
<section class="relative py-36 bg-white overflow-hidden">
    <!-- Geometric accent -->
    <div class="absolute top-0 right-0 w-[40%] h-full bg-gray-50 hidden lg:block" style="clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%)"></div>
    <div class="absolute bottom-0 left-0 w-48 h-1 bg-[#C8000A]"></div>

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
        <div class="max-w-xl">
            <div class="inline-flex items-center gap-2.5 mb-6">
                <span class="block w-6 h-px bg-[#C8000A]"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Service</span>
            </div>
            <h1 class="5xl sm:text-6xl font-black text-gray-900 tracking-tight leading-tight mb-5">
                Pesan<br><span class="text-[#C8000A]">Servis</span>
            </h1>
            <p class="text-gray-400 text-lg leading-relaxed">Pilih layanan yang Anda butuhkan dan isi formulir di bawah.</p>
        </div>
    </div>
</section>

<!-- ===================== ORDER FORM ===================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Order Form -->
            <div>
                <div class="inline-flex items-center gap-2.5 mb-8">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Formulir Pemesanan</span>
                </div>

                @if(session('success'))
                <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 mb-8">
                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                    <div>
                        <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                        <p class="text-green-600 text-xs mt-1">Catat nomor pesanan Anda: <strong>{{ session('order_number') }}</strong></p>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('order.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                            Pilih Layanan <span class="text-[#C8000A]">*</span>
                        </label>
                        <select name="service_id" id="serviceSelect" required
                                class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm">
                            <option value="">-- Pilih Layanan Service --</option>
                            @if(isset($servicesByCategory))
                                @foreach($servicesByCategory as $category => $categoryServices)
                                <optgroup label="{{ ucfirst($category) }}">
                                @foreach($categoryServices as $service)
                                    @php
                                        $jasaPrice = (float) ($service->price_jasa ?? 0);
                                        $priceStart = (float) ($service->price_start ?? 0);
                                        $priceEnd = (float) ($service->price_end ?? 0);
                                        $servicePriceForTotal = $jasaPrice > 0 ? $jasaPrice : ($priceStart > 0 ? $priceStart : 0);
                                    @endphp
                                    <option
                                        value="{{ $service->id }}"
                                        data-service-category="{{ $service->category }}"
                                        data-service-price="{{ $servicePriceForTotal }}"
                                    >
                                        {{ $service->name }}
                                        @if($jasaPrice > 0)
                                            (Rp {{ number_format($jasaPrice, 0, ',', '.') }})
                                        @elseif($priceStart > 0)
                                            (Rp {{ number_format($priceStart, 0, ',', '.') }})
                                        @else
                                            (Harga tidak tersedia)
                                        @endif


                                    </option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            @else
                                @foreach($services as $service)
                                @php
                                    $jasaPrice = (float) ($service->price_jasa ?? 0);
                                    $priceStart = (float) ($service->price_start ?? 0);
                                    $priceEnd = (float) ($service->price_end ?? 0);
                                @endphp
                                <option value="{{ $service->id }}">
                                    {{ $service->name }}
                                    @if($jasaPrice > 0)
                                        (Rp {{ number_format($jasaPrice, 0, ',', '.') }})
                                    @elseif($priceEnd > 0)
                                        (Rp {{ number_format($priceStart, 0, ',', '.') }} - Rp {{ number_format($priceEnd, 0, ',', '.') }})
                                    @else
                                        @if($priceStart > 0)
                                            (Rp {{ number_format($priceStart, 0, ',', '.') }})
                                        @else
                                            (Harga tidak tersedia)
                                        @endif
                                    @endif
                                </option>
                                @endforeach
                            @endif
                        </select>
                        @error('service_id')
                        <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sparepart (dropdown) -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                            Pilih Sparepart
                        </label>

                        <select name="selected_sparepart_id" id="sparepartSelect"
                                class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm">
                            <option value="">-- Opsional: Pilih Sparepart --</option>
                        </select>

                        <!-- Total Harga (Jasa + Sparepart) -->
                        <div class="mt-4 p-4 border border-gray-100 rounded-2xl bg-gray-50">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Harga Jasa</span>
                                <span class="text-gray-900 font-semibold" id="selectedServicePrice">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-600">Harga Sparepart</span>
                                <span class="text-gray-900 font-semibold" id="selectedSparepartPrice">Rp 0</span>
                            </div>
                            <div class="border-t border-red-600/10 pt-3 mt-3 flex justify-between text-base font-black">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gradient" id="selectedTotalPrice">Rp 0</span>
                            </div>
                        </div>

                        <input type="hidden" name="service_price" id="servicePriceInput" value="0" />
                        <input type="hidden" name="sparepart_price" id="sparepartPriceInput" value="0" />
                        <input type="hidden" name="total_price" id="totalPriceInput" value="0" />

@push('scripts')
<script>
(() => {
    const serviceSelect = document.getElementById('serviceSelect');
    const sparepartSelect = document.getElementById('sparepartSelect');

    if (!serviceSelect || !sparepartSelect) return;

    const sparepartsByServiceId = @json($sparepartsByServiceId ?? []);

    const formatRp = (value) => {
        return `Rp ${new Intl.NumberFormat('id-ID').format(Number(value || 0))}`;
    };

    const updateTotal = () => {
        const selectedService =
            serviceSelect.selectedOptions[0];

        const selectedSparepart =
            sparepartSelect.selectedOptions[0];

        const servicePrice = Number(
            selectedService?.dataset?.servicePrice || 0
        );

        const sparepartPrice = Number(
            selectedSparepart?.dataset?.price || 0
        );

        const total = servicePrice + sparepartPrice;

        document.getElementById('selectedServicePrice').textContent =
            formatRp(servicePrice);

        document.getElementById('selectedSparepartPrice').textContent =
            formatRp(sparepartPrice);

        document.getElementById('selectedTotalPrice').textContent =
            formatRp(total);

        document.getElementById('servicePriceInput').value =
            servicePrice;

        document.getElementById('sparepartPriceInput').value =
            sparepartPrice;

        document.getElementById('totalPriceInput').value =
            total;
    };

    const fillSpareparts = () => {
        sparepartSelect.innerHTML =
            '<option value="">-- Opsional: Pilih Sparepart --</option>';

        const selectedService =
            serviceSelect.selectedOptions[0];

        const serviceId =
            selectedService?.value;

        if (!serviceId) {
            updateTotal();
            return;
        }

        const spareparts =
            sparepartsByServiceId[serviceId] || [];

        spareparts.forEach((sp) => {
            const option = document.createElement('option');

            option.value = sp.id;
            option.dataset.price = sp.price || 0;

            option.textContent =
                `${sp.name} (${formatRp(sp.price)})`;

            sparepartSelect.appendChild(option);
        });

        updateTotal();
    };

    serviceSelect.addEventListener('change', fillSpareparts);
    sparepartSelect.addEventListener('change', updateTotal);

    fillSpareparts();
})();
</script>
@endpush
                        @error('selected_sparepart_id')
                            <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                        @enderror

                        <p class="text-sm text-gray-500 mt-2">
                            Jika sparepart tidak dipilih, pesanan hanya berdasarkan harga jasa.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                                Nama Lengkap <span class="text-[#C8000A]">*</span>
                            </label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                                   class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm"
                                   placeholder="Nama lengkap Anda">
                            @error('customer_name')
                            <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                                No. Telepon <span class="text-[#C8000A]">*</span>
                            </label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                                   class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm"
                                   placeholder="08xx-xxxx-xxxx">
                            @error('customer_phone')
                            <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                            Email <span class="text-[#C8000A]">*</span>
                        </label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" required
                               class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm"
                               placeholder="email@contoh.com">
                        @error('customer_email')
                        <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                            Alamat (Opsional)
                        </label>
                        <textarea name="customer_address" rows="2"
                                  class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm resize-none"
                                  placeholder="Alamat lengkap Anda (untuk pengiriman)">{{ old('customer_address') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                            Deskripsi Device/ALat <span class="text-[#C8000A]">*</span>
                        </label>
                        <input type="text" name="device_description" value="{{ old('device_description') }}" required
                               class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm"
                               placeholder="Contoh: Laptop Asus VivoBook 15, PC Gaming, Printer Canon Pixma, dll">
                        @error('device_description')
                        <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.12em] text-gray-400 mb-2">
                            Deskripsi Masalah/Kerusakan <span class="text-[#C8000A]">*</span>
                        </label>
                        <textarea name="problem_description" required rows="4"
                                  class="w-full px-4 py-3.5 border border-gray-200 bg-white text-gray-900 text-sm font-medium placeholder-gray-300 focus:outline-none focus:border-[#C8000A] transition-colors rounded-sm resize-none"
                                  placeholder="Jelaskan masalah atau kerusakan yang Anda alami...">{{ old('problem_description') }}</textarea>
                        @error('problem_description')
                        <p class="text-[#C8000A] text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="group w-full flex items-center justify-center gap-3 px-8 py-4 bg-[#C8000A] text-white font-black text-sm uppercase tracking-widest hover:bg-[#A00008] transition-colors rounded-sm">
                        <i class="fas fa-paper-plane text-sm"></i>
                        Kirim Pesanan
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>

            <!-- Info + Services List -->
            <div class="space-y-5">
                <div class="inline-flex items-center gap-2.5 mb-3">
                    <span class="block w-6 h-px bg-[#C8000A]"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-[#C8000A]">Layanan Kami</span>
                </div>

                <!-- Quick Service Info -->
                @if($store)
                @foreach([
                    ['icon' => 'fa-map-marker-alt', 'label' => 'Alamat Toko', 'line1' => $store->address, 'line2' => $store->city],
                    ['icon' => 'fa-clock', 'label' => 'Jam Operasional', 'line1' => $store->open_days, 'line2' => $store->open_hours, 'accent' => true],
                ] as $info)
                <div class="flex items-start gap-4 p-5 border border-gray-100 hover:border-[#C8000A]/20 transition-colors rounded-sm">
                    <div class="w-10 h-10 bg-[#C8000A] flex items-center justify-center flex-shrink-0 rounded-xs">
                        <i class="fas {{ $info['icon'] }} text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.12em] text-gray-400 mb-1">{{ $info['label'] }}</p>
                        <p class="text-gray-800 text-sm font-semibold">{{ $info['line1'] }}</p>
                        <p class="text-sm {{ isset($info['accent']) ? 'text-[#C8000A] font-black' : 'text-gray-500' }}">{{ $info['line2'] }}</p>
                    </div>
                </div>
                @endforeach

                <div class="grid grid-cols-2 gap-3">
                    @if($store->phone)
                    <a href="tel:{{ $store->phone }}" class="group flex items-start gap-3 p-4 border border-gray-100 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all rounded-sm">
                        <div class="w-8 h-8 bg-red-50 group-hover:bg-[#C8000A] flex items-center justify-center flex-shrink-0 transition-colors rounded-sm">
                            <i class="fas fa-phone-alt text-[#C8000A] group-hover:text-white text-xs transition-colors"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-gray-400 mb-1">Telepon</p>
                            <p class="text-gray-800 text-xs font-bold">{{ $store->phone }}</p>
                        </div>
                    </a>
                    @endif
                    @if($store->email)
                    <a href="mailto:{{ $store->email }}" class="group flex items-start gap-3 p-4 border border-gray-100 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all rounded-sm">
                        <div class="w-8 h-8 bg-red-50 group-hover:bg-[#C8000A] flex items-center justify-center flex-shrink-0 transition-colors">
                            <i class="fas fa-envelope text-[#C8000A] group-hover:text-white text-xs transition-colors"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-gray-400 mb-1">Email</p>
                            <p class="text-gray-800 text-xs font-bold">{{ $store->email }}</p>
                        </div>
                    </a>
                    @endif
                </div>
                @endif

                <!-- WhatsApp CTA -->
                @if($store && $store->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20memesan%20servis!"
                   target="_blank"
                   class="group flex items-center gap-4 p-5 bg-[#C8000A] text-white hover:bg-[#A00008] transition-colors rounded-sm">
                    <i class="fab fa-whatsapp text-3xl flex-shrink-0"></i>
                    <div>
                        <p class="font-black text-sm">Chat via WhatsApp</p>
                        <p class="text-white/70 text-xs">Respon cepat, biasanya balas dalam menit</p>
                    </div>
                    <i class="fas fa-arrow-right text-sm ml-auto group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif

                <!-- Service Categories -->
                <div class="grid grid-cols-4 gap-3 pt-4">
                    <a href="{{ route('services.pc') }}" class="group text-center p-4 border border-gray-200 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all rounded-sm">
                        <i class="fas fa-desktop text-2xl text-gray-400 group-hover:text-[#C8000A] mb-2"></i>
                        <p class="text-xs font-semibold text-gray-600 group-hover:text-[#C8000A]">PC</p>
                    </a>
                    <a href="{{ route('services.laptop') }}" class="group text-center p-4 border border-gray-200 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all rounded-sm">
                        <i class="fas fa-laptop text-2xl text-gray-400 group-hover:text-[#C8000A] mb-2"></i>
                        <p class="text-xs font-semibold text-gray-600 group-hover:text-[#C8000A]">Laptop</p>
                    </a>
                    <a href="{{ route('services.printer') }}" class="group text-center p-4 border border-gray-200 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all rounded-sm">
                        <i class="fas fa-print text-2xl text-gray-400 group-hover:text-[#C8000A] mb-2"></i>
                        <p class="text-xs font-semibold text-gray-600 group-hover:text-[#C8000A]"> Printer</p>
                    </a>
                    <a href="{{ route('services.software') }}" class="group text-center p-4 border border-gray-200 hover:border-[#C8000A]/30 hover:bg-red-50 transition-all rounded-sm">
                        <i class="fas fa-compact-disc text-2xl text-gray-400 group-hover:text-[#C8000A] mb-2"></i>
                        <p class="text-xs font-semibold text-gray-600 group-hover:text-[#C8000A]"> Software</p>
                    </a>
                </div>

                <!-- Map -->
                <div class="overflow-hidden border border-gray-200">
                    @if($store && $store->google_maps_link)
                    <iframe src="{{ $store->google_maps_link }}" width="100%" style="border:0; height:280px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                    <div id="map" style="height:280px;"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
@if(!($store && $store->google_maps_link))
<script>
    const map = L.map('map').setView([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution:'© OpenStreetMap'}).addTo(map);
    const icon = L.divIcon({
        html: `<div style="background:#C8000A;width:40px;height:40px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(200,0,10,0.4);"><i class="fas fa-wrench" style="color:white;font-size:16px;"></i></div>`,
        className:'', iconSize:[40,40], iconAnchor:[20,40]
    });
    L.marker([{{ $store->latitude ?? -6.9147 }}, {{ $store->longitude ?? 107.6098 }}], {icon}).addTo(map)
     .bindPopup('<strong style="color:#C8000A;">Alsha Media Center</strong>')
     .openPopup();
</script>
@endif
@endpush
