@extends('layouts.app')
@section('title', 'Tracking Servis')
@section('content')
<section class="bg-hero min-h-screen flex items-center justify-center py-20 px-4">
    <div class="max-w-lg w-full" data-animate>
        <div class="text-center mb-10">
            <div class="w-20 h-20 mx-auto rounded-2xl gradient-anim flex items-center justify-center text-white text-3xl mb-6 shadow-lg">
                <i class="fas fa-search-location"></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 mb-3">Tracking Servis</h1>
            <p class="text-gray-600">Masukkan kode servis Anda untuk melihat status perbaikan terkini.</p>
        </div>

        @if(session('success'))
            <div class="toast-msg mb-6">
                <div class="flex items-center gap-3 px-5 py-4 bg-gradient-to-r from-green-600 to-green-700 rounded-2xl text-white shadow-2xl">
                    <span class="text-2xl"><i class="fas fa-check"></i></span>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast-msg mb-6">
                <div class="flex items-center gap-3 px-5 py-4 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl text-white shadow-2xl">
                    <span class="text-2xl"><i class="fas fa-times"></i></span>
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="service-card p-8 rounded-2xl">
            <form method="POST" action="{{ route('tracking.search') }}" class="space-y-5" data-turbo="false">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Kode Servis</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-barcode text-gray-400"></i>
                        </div>
                        <input type="text" name="code" value="{{ old('code') }}" required
                               class="form-input w-full pl-11 pr-4 py-4 rounded-xl text-sm font-mono uppercase"
                               placeholder="AMC-20260428-001"
                               style="text-transform: uppercase;">
                    </div>
                    @error('code')
                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>
                <button type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-semibold text-sm">
                    <i class="fas fa-search mr-2"></i> Cek Status
                </button>
            </form>
        </div>

        {{-- Quick Info --}}
        <div class="mt-8 grid grid-cols-3 gap-4">
            <div class="text-center p-4 rounded-xl bg-white border border-gray-200">
                <div class="text-2xl mb-2"><i class="fas fa-tools text-red-500"></i></div>
                <p class="text-xs text-gray-600 font-medium">PC / Komputer</p>
            </div>
            <div class="text-center p-4 rounded-xl bg-white border border-gray-200">
                <div class="text-2xl mb-2"><i class="fas fa-laptop text-red-500"></i></div>
                <p class="text-xs text-gray-600 font-medium">Laptop</p>
            </div>
            <div class="text-center p-4 rounded-xl bg-white border border-gray-200">
                <div class="text-2xl mb-2"><i class="fas fa-print text-red-500"></i></div>
                <p class="text-xs text-gray-600 font-medium">Printer</p>
            </div>
        </div>
    </div>
</section>
@endsection

