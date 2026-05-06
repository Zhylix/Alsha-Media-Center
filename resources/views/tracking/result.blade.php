@extends('layouts.app')
@section('title', 'Hasil Tracking - ' . $serviceTicket->service_code)
@section('content')
<section class="bg-hero min-h-screen py-20 px-4">
    <div class="max-w-2xl mx-auto" data-animate>
        {{-- Back button --}}
        <a href="{{ route('tracking.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition-colors mb-6">
            <i class="fas fa-arrow-left"></i> Kembali ke Tracking
        </a>

        {{-- Header Card --}}
        <div class="service-card p-8 rounded-2xl mb-6 text-center">
            <div class="w-16 h-16 mx-auto rounded-xl bg-red-100 flex items-center justify-center text-red-600 text-2xl mb-4">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Status Servis Anda</p>
            <h1 class="text-2xl font-black text-gray-900 font-mono mb-2">{{ $serviceTicket->service_code }}</h1>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold
                @switch($serviceTicket->status)
                    @case('pending') bg-yellow-100 text-yellow-700 border border-yellow-300 @break
                    @case('checking') bg-orange-100 text-orange-700 border border-orange-300 @break
                    @case('proses') bg-blue-100 text-blue-700 border border-blue-300 @break
                    @case('waiting_part') bg-purple-100 text-purple-700 border border-purple-300 @break
                    @case('selesai') bg-green-100 text-green-700 border border-green-300 @break
                    @case('diambil') bg-gray-100 text-gray-700 border border-gray-300 @break
                    @default bg-gray-100 text-gray-700 border border-gray-300
                @endswitch">
                @switch($serviceTicket->status)
                    @case('pending') <i class="fas fa-hourglass-start"></i> @break
                    @case('checking') <i class="fas fa-search"></i> @break
                    @case('proses') <i class="fas fa-tools"></i> @break
                    @case('waiting_part') <i class="fas fa-box-open"></i> @break
                    @case('selesai') <i class="fas fa-check-circle"></i> @break
                    @case('diambil') <i class="fas fa-flag-checkered"></i> @break
                @endswitch
                {{ $serviceTicket->status_label }}
            </span>
        </div>

        {{-- Progress Bar --}}
        <div class="service-card p-8 rounded-2xl mb-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Progres Perbaikan</span>
                <span class="text-sm font-bold text-red-600">{{ $serviceTicket->progress_percent }}%</span>
            </div>
            <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700 ease-out
                    @switch($serviceTicket->status)
                        @case('pending') bg-yellow-500 @break
                        @case('checking') bg-orange-500 @break
                        @case('proses') bg-blue-500 @break
                        @case('waiting_part') bg-purple-500 @break
                        @case('selesai') bg-green-500 @break
                        @case('diambil') bg-gray-500 @break
                        @default bg-gray-400
                    @endswitch"
                    style="width: {{ $serviceTicket->progress_percent }}%"></div>
            </div>
            <div class="flex justify-between mt-3 text-xs text-gray-400">
                <span>Input</span>
                <span>Selesai</span>
            </div>
        </div>

        {{-- Timeline Steps --}}
        <div class="service-card p-8 rounded-2xl mb-6">
            <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                <i class="fas fa-stream text-red-500"></i> Alur Proses
            </h3>
            <div class="space-y-0">
                @php
                    $steps = [
                        ['key' => 'pending', 'icon' => 'fa-hourglass-start', 'label' => 'Menunggu Pengecekan'],
                        ['key' => 'checking', 'icon' => 'fa-search', 'label' => 'Sedang Dicek Teknisi'],
                        ['key' => 'proses', 'icon' => 'fa-tools', 'label' => 'Sedang Diperbaiki'],  
                        ['key' => 'selesai', 'icon' => 'fa-check-circle', 'label' => 'Sudah Selesai'],
                        ['key' => 'diambil', 'icon' => 'fa-flag-checkered', 'label' => 'Sudah Diambil'],
                    ];
                    $currentStep = array_search($serviceTicket->status, array_column($steps, 'key'));
                @endphp
                @foreach($steps as $index => $step)
                    @php
                        $isDone = $index < $currentStep;
                        $isActive = $index === $currentStep;
                    @endphp
                    <div class="flex items-start gap-4 relative">
                        {{-- Connector line --}}
                        @if($index < count($steps) - 1)
                            <div class="absolute left-5 top-10 bottom-0 w-0.5
                                {{ $isDone ? 'bg-red-500' : 'bg-gray-200' }}"></div>
                        @endif

                        {{-- Step circle --}}
                        <div class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center text-sm flex-shrink-0 border-2
                            {{ $isActive ? 'bg-red-600 text-white border-red-600' : '' }}
                            {{ $isDone ? 'bg-red-500 text-white border-red-500' : '' }}
                            {{ !$isActive && !$isDone ? 'bg-gray-100 text-gray-400 border-gray-200' : '' }}">
                            @if($isDone)
                                <i class="fas fa-check"></i>
                            @else
                                <i class="fas {{ $step['icon'] }}"></i>
                            @endif
                        </div>

                        {{-- Step label --}}
                        <div class="pb-8 pt-1">
                            <p class="text-sm font-semibold
                                {{ $isActive ? 'text-red-600' : '' }}
                                {{ $isDone ? 'text-gray-900' : '' }}
                                {{ !$isActive && !$isDone ? 'text-gray-400' : '' }}">
                                {{ $step['label'] }}
                            </p>
                            @if($isActive)
                                <p class="text-xs text-gray-500 mt-1">Status saat ini</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Detail Card --}}
        <div class="service-card p-8 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                <i class="fas fa-info-circle text-red-500"></i> Detail Servis
            </h3>
            <div class="space-y-4">
                <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase">Nama Pelanggan</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $serviceTicket->customer_name }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                        <i class="fas {{ $serviceTicket->device_type === 'pc' ? 'fa-desktop' : ($serviceTicket->device_type === 'laptop' ? 'fa-laptop' : 'fa-print') }}"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase">Jenis Perangkat</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $serviceTicket->device_type_label }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase">Keluhan / Kerusakan</p>
                        <p class="text-sm text-gray-900 leading-relaxed">{{ $serviceTicket->problem }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase">Tanggal Masuk</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $serviceTicket->created_at->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- WhatsApp Contact --}}
        @php
            $store = \App\Models\StoreProfile::first();
        @endphp
        @if($store && $store->whatsapp)
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500 mb-3">Ada pertanyaan? Hubungi kami via WhatsApp</p>
            <a href="https://wa.me/{{ preg_replace('/\D/','',$store->whatsapp) }}?text=Halo%20Alsha%20Media%20Center,%20saya%20ingin%20menanyakan%20servis%20dengan%20kode%20{{ urlencode($serviceTicket->service_code) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold text-sm transition-all hover:scale-105">
                <i class="fab fa-whatsapp text-lg"></i> Chat WhatsApp
            </a>
        </div>
        @endif
    </div>
</section>
@endsection

