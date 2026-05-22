@extends('layouts.admin')
@section('title', 'Profil Toko')
@section('page-title', 'Profil Toko')
@section('page-subtitle', 'Kelola informasi toko dengan tampilan tab yang lebih rapi')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Progress Bar --}}
    <div class="mb-8 p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-2xl border border-red-200">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-semibold text-gray-700">Progress Profil Toko</span>
            <span class="text-sm font-medium text-gray-600" id="progress-percent">0%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-gradient-to-r from-red-500 to-red-600 h-2 rounded-full transition-all duration-300" style="width: 0%" id="progress-bar"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.store.update') }}" enctype="multipart/form-data" id="store-form" class="space-y-6">
        @csrf @method('PUT')

        {{-- Tabs Navigation --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex border-b border-gray-200" id="tabs-nav">
                @php
                    $store ??= (object) [];
                    $tabs = [
                        ['id' => 'basic', 'icon' => 'fa-store', 'title' => 'Info Dasar', 'complete' => !empty(data_get($store, 'store_name'))],
                        ['id' => 'branding', 'icon' => 'fa-image', 'title' => 'Branding', 'complete' => !empty(data_get($store, 'logo'))],
                        ['id' => 'contact', 'icon' => 'fa-phone-alt', 'title' => 'Kontak', 'complete' => !empty(data_get($store, 'address'))],
                        ['id' => 'location', 'icon' => 'fa-map', 'title' => 'Lokasi', 'complete' => !empty(data_get($store, 'google_maps_link'))],
                        ['id' => 'hours', 'icon' => 'fa-clock', 'title' => 'Jam', 'complete' => !empty(data_get($store, 'open_days'))]
                    ];
                @endphp
                @foreach($tabs as $tab)
                <button type="button" data-tab="{{ $tab['id'] }}"
                        class="flex-1 py-4 px-6 text-sm font-semibold border-b-2 transition-all duration-200 hover:bg-red-50 @if($loop->first) bg-white border-red-500 text-red-700 shadow-sm @else text-gray-600 border-transparent hover:border-red-200 hover:text-red-700 @endif items-center gap-2">
                    <i class="fas {{ $tab['icon'] }} text-xs"></i>
                    {{ $tab['title'] }}
                </button>
                @endforeach
            </div>

            {{-- Tab Contents --}}
            <div class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
                {{-- Tab 1: Info Dasar --}}
                <div id="basic" class="tab-content block">
                    <div class="service-card p-8 rounded-2xl space-y-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3"><i class="fas fa-store text-red-500"></i>Informasi Dasar Toko</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Nama Toko *</label>
                                <input type="text" name="store_name" value="{{ old('store_name', data_get($store, 'store_name', '')) }}" required
                                       class="form-input w-full px-5 py-4 rounded-2xl text-lg font-semibold border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all">
                                @error('store_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Tagline / Slogan</label>
                                <input type="text" name="tagline" value="{{ old('tagline', data_get($store, 'tagline', '')) }}"
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all"
                                       placeholder="Contoh: 'Service Laptop & PC Terpercaya'">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Deskripsi Toko *</label>
                                <textarea name="description" required rows="5"
                                          class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all resize-vertical">{{ old('description', data_get($store, 'description', '')) }}</textarea>
                                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab 2: Branding --}}
                <div id="branding" class="tab-content hidden">
                    <div class="service-card p-8 rounded-2xl space-y-8">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3"><i class="fas fa-image text-red-500"></i>Logo & Gambar Hero</h3>

                        {{-- Logo Upload --}}
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <h4 class="text-lg font-bold text-gray-900 flex items-center gap-2">Logo Toko</h4>
                                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-red-300 hover:bg-red-50 transition-all cursor-pointer group"
                                     onclick="document.getElementById('logo-upload').click()">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 group-hover:text-red-500 mb-3"></i>
                                    <p class="text-lg font-semibold text-gray-700 group-hover:text-red-600">Upload Logo Baru</p>
                                    <p class="text-sm text-gray-500">JPG, PNG, WEBP (Max 2MB)</p>
                                    <input type="file" id="logo-upload" name="logo" accept="image/*" class="hidden" onchange="previewLogo(this)">
                                </div>
                                @error('logo') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            {{-- Current Logo --}}
                            @if(!empty(data_get($store, 'logo')))
                            <div class="space-y-4">
                                <h4 class="text-lg font-bold text-gray-900">Logo Saat Ini</h4>
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border-2 border-gray-200">
                                    <img src="{{ asset('storage/' . data_get($store, 'logo')) }}" alt="Logo Saat Ini"
                                         class="w-32 h-32 mx-auto object-contain rounded-xl shadow-lg bg-white p-4">
                                    <div class="text-center mt-4">
                                        <button type="button" onclick="confirmDelete('logo')"
                                                class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-all shadow-md">
                                            <i class="fas fa-trash mr-2"></i>Hapus Logo
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Hero Image --}}
                        <div class="pt-8 border-t border-gray-200">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <h4 class="text-lg font-bold text-gray-900 flex items-center gap-2"><i class="fas fa-photo-video text-red-500"></i>Gambar Hero</h4>
                                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-red-300 hover:bg-red-50 transition-all cursor-pointer group"
                                         onclick="document.getElementById('hero-upload').click()">
                                        <i class="fas fa-image text-4xl text-gray-400 group-hover:text-red-500 mb-3"></i>
                                        <p class="text-lg font-semibold text-gray-700 group-hover:text-red-600">Upload Hero Baru</p>
                                        <p class="text-sm text-gray-500">1920x1080px ideal (Max 5MB)</p>
                                        <input type="file" id="hero-upload" name="hero_image" accept="image/*" class="hidden" onchange="previewHero(this)">
                                    </div>
                                </div>

                                @if(!empty(data_get($store, 'hero_image')))
                                <div class="space-y-4">
                                    <h4 class="text-lg font-bold text-gray-900">Hero Saat Ini</h4>
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border-2 border-gray-200">
                                        <img src="{{ asset('storage/' . data_get($store, 'hero_image')) }}" alt="Hero"
                                             class="w-64 h-40 mx-auto object-cover rounded-xl shadow-lg">
                                        <div class="text-center mt-4">
                                            <button type="button" onclick="confirmDelete('hero')"
                                                    class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-all shadow-md">
                                                <i class="fas fa-trash mr-2"></i>Hapus Hero
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab 3: Kontak --}}
                <div id="contact" class="tab-content hidden">
                    <div class="service-card p-8 rounded-2xl space-y-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3"><i class="fas fa-map-marker-alt text-red-500"></i>Informasi Kontak</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Alamat Lengkap *</label>
                                <input type="text" name="address" value="{{ old('address', data_get($store, 'address', '')) }}" required
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100">
                                @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Kota *</label>
                                <input type="text" name="city" value="{{ old('city', data_get($store, 'city', '')) }}" required
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100">
                                @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Telepon *</label>
                                <input type="tel" name="phone" value="{{ old('phone', data_get($store, 'phone', '')) }}" required
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">WhatsApp</label>
                                <input type="tel" name="whatsapp" value="{{ old('whatsapp', data_get($store, 'whatsapp', '')) }}"
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Email *</label>
                                <input type="email" name="email" value="{{ old('email', data_get($store, 'email', '')) }}" required
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100">
                            </div>
                            <div class="md:col-span-2 grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Instagram</label>
                                    <input type="text" name="instagram" value="{{ old('instagram', data_get($store, 'instagram', '')) }}"
                                           class="form-input w-full px-5 py-3 rounded-xl border focus:border-red-400" placeholder="@username">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Facebook</label>
                                    <input type="text" name="facebook" value="{{ old('facebook', data_get($store, 'facebook', '')) }}"
                                           class="form-input w-full px-5 py-3 rounded-xl border focus:border-red-400" placeholder="facebook.com/username">
                                </div>
                            </div>
                        </div>

                        {{-- Live Social Preview --}}
                        <div class="p-6 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <h4 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-900">Preview Sosial Media</h4>
                            <div class="flex gap-4 justify-center">
                                @if(!empty(data_get($store, 'instagram')))
                                <a href="https://instagram.com/{{ ltrim(data_get($store, 'instagram', ''), '@') }}" target="_blank"
                                   class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white shadow-lg hover:scale-110 transition-all">
                                    <i class="fab fa-instagram text-sm"></i>
                                </a>
                                @endif
                                @if(!empty(data_get($store, 'facebook')))
                                <a href="https://facebook.com/{{ data_get($store, 'facebook', '') }}" target="_blank"
                                   class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg hover:scale-110 transition-all">
                                    <i class="fab fa-facebook-f text-sm"></i>
                                </a>
                                @endif
                                @if(!empty(data_get($store, 'whatsapp')))
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', data_get($store, 'whatsapp', '')) }}" target="_blank"
                                   class="w-14 h-14 bg-green-500 rounded-2xl flex items-center justify-center text-white shadow-lg hover:scale-110 transition-all">
                                    <i class="fab fa-whatsapp text-sm"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab 4: Lokasi --}}
                <div id="location" class="tab-content hidden">
                    <div class="service-card p-8 rounded-2xl space-y-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3"><i class="fas fa-map text-red-600"></i>Google Maps</h3>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Link Embed Maps (Peta di Website) *</label>
                                <input type="url" name="google_maps_link" value="{{ old('google_maps_link', data_get($store, 'google_maps_link', '')) }}"
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100"
                                       placeholder="https://www.google.com/maps/embed?pb=...">
                                <p class="mt-2 text-xs text-gray-500">Salin dari tab "Embed peta" di Google Maps → Share</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Link Langsung (Tombol Buka Maps)</label>
                                <input type="url" name="google_maps_direct_link" value="{{ old('google_maps_direct_link', data_get($store, 'google_maps_direct_link', '')) }}"
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100"
                                       placeholder="https://maps.app.goo.gl/...">
                                <p class="mt-2 text-xs text-gray-500">Salin link pendek dari tab "Kirim tautan" di Google Maps</p>
                            </div>
                        </div>

                        @if(!empty(data_get($store, 'google_maps_link')))
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-900">Preview Peta</h4>
                            <div class="rounded-2xl border-4 border-red-500/20 overflow-hidden shadow-2xl max-h-96">
                                <iframe src="{{ data_get($store, 'google_maps_link', '') }}" width="100%" height="400" style="border:0; border-radius: 1rem;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Tab 5: Jam Operasional --}}
                <div id="hours" class="tab-content hidden">
                    <div class="service-card p-8 rounded-2xl space-y-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3"><i class="fas fa-clock text-red-500"></i>Jam Operasional</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Hari Buka *</label>
                                <input type="text" name="open_days" value="{{ old('open_days', data_get($store, 'open_days', '')) }}" required
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100"
                                       placeholder="Senin - Sabtu">
                                @error('open_days') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Jam Buka *</label>
                                <input type="text" name="open_hours" value="{{ old('open_hours', data_get($store, 'open_hours', '')) }}" required
                                       class="form-input w-full px-5 py-4 rounded-2xl border-2 focus:border-red-500 focus:ring-4 focus:ring-red-100"
                                       placeholder="08:00 - 20:00">
                                @error('open_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div class="p-6 bg-emerald-50 border-2 border-emerald-200 rounded-2xl">
                            <h4 class="text-lg font-bold mb-4 text-emerald-800 flex items-center gap-2">Preview di Website</h4>
                            <div class="text-center">
                                <i class="fas fa-clock text-4xl text-emerald-500 mb-4"></i>
                                <p class="text-2xl font-bold text-gray-900">{{ old('open_days', data_get($store, 'open_days', 'Senin - Sabtu')) }}</p>
                                <p class="text-xl text-gray-700">{{ old('open_hours', data_get($store, 'open_hours', '08:00 - 20:00')) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Save Button --}}
        <div class="pt-6 border-t bg-white sticky bottom-0 left-0 right-0 p-6 shadow-2xl rounded-2xl border border-gray-200 z-10">
            <div class="flex gap-4 justify-end max-w-2xl mx-auto">
                <button type="button" onclick="resetForm()"
                        class="px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
                    <i class="fas fa-undo mr-2"></i>Batal
                </button>
                <button type="submit" id="save-btn"
                        class="btn-primary px-10 py-4 flex items-center gap-3 text-lg font-bold shadow-2xl hover:shadow-red-500/25 transform hover:-translate-y-1 transition-all rounded-2xl text-gray-100">
                    <i class="fas fa-save"></i> Simpan Semua Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Hidden Forms for Delete --}}
<form id="delete-logo-form" action="{{ route('admin.store.logo.delete') }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
<form id="delete-hero-form" action="{{ route('admin.store.hero.delete') }}" method="POST" class="hidden">@csrf @method('DELETE')</form>

@push('scripts')
<script>

function initStoreTabs() {

    let progressFields = [
        'store_name',
        'description',
        'address',
        'city',
        'phone',
        'email',
        'open_days',
        'open_hours'
    ];

    // =========================
    // TAB SWITCHING
    // =========================
    document.querySelectorAll('[data-tab]').forEach(btn => {

        // Hindari event double
        if (btn.dataset.initialized === 'true') return;

        btn.dataset.initialized = 'true';

        btn.addEventListener('click', (e) => {

            const tabId = e.currentTarget.dataset.tab;

            // Hide semua tab
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
                tab.classList.remove('block');
            });

            // Reset semua tombol
            document.querySelectorAll('#tabs-nav button').forEach(b => {

                b.classList.remove(
                    'bg-white',
                    'border-red-500',
                    'text-red-700',
                    'shadow-sm'
                );

                b.classList.add(
                    'text-gray-600',
                    'border-transparent',
                    'hover:bg-red-50'
                );

            });

            // Tampilkan tab aktif
            const selectedTab = document.getElementById(tabId);

            if (selectedTab) {
                selectedTab.classList.remove('hidden');
                selectedTab.classList.add('block');
            }

            // Aktifkan tombol
            e.currentTarget.classList.add(
                'bg-white',
                'border-red-500',
                'text-red-700',
                'shadow-sm'
            );

            e.currentTarget.classList.remove(
                'text-gray-600',
                'border-transparent'
            );

            updateProgress();

        });

    });

    // =========================
    // PROGRESS BAR
    // =========================
    function updateProgress() {

        let complete = 0;

        progressFields.forEach(field => {

            const input = document.querySelector(`[name="${field}"]`);

            if (input && input.value.trim()) {
                complete++;
            }

        });

        const percent = Math.round((complete / progressFields.length) * 100);

        const progressText = document.getElementById('progress-percent');
        const progressBar = document.getElementById('progress-bar');

        if (progressText) {
            progressText.textContent = `${percent}%`;
        }

        if (progressBar) {
            progressBar.style.width = `${percent}%`;
        }

    }

    updateProgress();

    // =========================
    // UPDATE PROGRESS SAAT INPUT
    // =========================
    progressFields.forEach(field => {

        const input = document.querySelector(`[name="${field}"]`);

        if (input && !input.dataset.progressBound) {

            input.dataset.progressBound = 'true';

            input.addEventListener('input', updateProgress);

        }

    });

    // =========================
    // FORM SUBMIT
    // =========================
    const form = document.getElementById('store-form');

    if (form && !form.dataset.initialized) {

        form.dataset.initialized = 'true';

        form.addEventListener('submit', function(e) {

            const required = document.querySelectorAll('[required]');
            let valid = true;

            required.forEach(field => {

                if (!field.value.trim()) {

                    field.classList.add(
                        'border-red-500',
                        'focus:border-red-500'
                    );

                    valid = false;

                } else {

                    field.classList.remove(
                        'border-red-500',
                        'focus:border-red-500'
                    );

                }

            });

            if (!valid) {

                e.preventDefault();

                alert('Mohon lengkapi semua field wajib (*) terlebih dahulu!');

                const firstError = document.querySelector('.border-red-500');

                if (firstError) {

                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                }

                return;

            }

            // Loading button
            const saveBtn = document.getElementById('save-btn');

            if (saveBtn) {

                saveBtn.disabled = true;

                saveBtn.innerHTML = `
                    <i class="fas fa-spinner fa-spin"></i>
                    Menyimpan...
                `;

            }

        });

    }

}

// =========================
// LOAD NORMAL
// =========================
document.addEventListener('DOMContentLoaded', initStoreTabs);

// =========================
// LOAD TURBO
// =========================
document.addEventListener('turbo:load', initStoreTabs);

// =========================
// LIVEWIRE NAVIGATE
// =========================
document.addEventListener('livewire:navigated', initStoreTabs);

// =========================
// GLOBAL FUNCTIONS
// =========================
function resetForm() {

    location.reload();

}

function confirmDelete(type) {

    if (confirm(`Yakin ingin menghapus ${type === 'logo' ? 'logo' : 'gambar hero'}?`)) {

        document.getElementById(`delete-${type}-form`).submit();

    }

}

function previewLogo(input) {

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e) {

            let preview = document.getElementById('logo-preview-temp');

            if (!preview) {

                preview = document.createElement('img');

                preview.id = 'logo-preview-temp';

                preview.className = 'w-32 h-32 object-contain rounded-xl shadow-lg bg-white p-4 mx-auto mt-4';

                input.closest('.space-y-4').appendChild(preview);

            }

            preview.src = e.target.result;

        };

        reader.readAsDataURL(input.files[0]);

    }

}

function previewHero(input) {

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e) {

            let preview = document.getElementById('hero-preview-temp');

            if (!preview) {

                preview = document.createElement('img');

                preview.id = 'hero-preview-temp';

                preview.className = 'w-full max-w-md h-48 object-cover rounded-xl shadow-lg mx-auto mt-4';

                input.closest('.space-y-4').appendChild(preview);

            }

            preview.src = e.target.result;

        };

        reader.readAsDataURL(input.files[0]);

    }

}

</script>
@endpush
@endsection

