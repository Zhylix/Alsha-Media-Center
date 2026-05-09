@extends('layouts.admin')
@section('title', 'Detail Sparepart')
@section('page-title', 'Detail Sparepart')
@section('page-subtitle', 'Informasi sparepart')

@section('content')
<div class="service-card p-6 rounded-2xl">
    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $sparepart->name }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ $sparepart->sparepartCategory->service_category ?? '-' }} + {{ $sparepart->sparepartCategory->part_type ?? '-' }}</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.spareparts.edit', $sparepart) }}" class="btn-primary px-4 py-2 rounded-xl text-white font-semibold text-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.spareparts.index') }}" class="btn-outline px-4 py-2 rounded-xl text-red-600 font-semibold text-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="md:col-span-1">
            @if($sparepart->image)
                <img src="{{ asset('storage/'.$sparepart->image) }}" alt="{{ $sparepart->name }}" class="w-full h-auto rounded-2xl border border-gray-200 object-cover">
            @else
                <div class="w-full h-40 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400">
                    <i class="fas fa-image"></i>
                </div>
            @endif
        </div>

        <div class="md:col-span-2">
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 text-sm">Harga</span>
                    <span class="text-gray-900 font-bold">Rp {{ number_format($sparepart->price, 0, ',', '.') }}</span>
                </div>

                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600 text-sm">Stok</span>
                    <span class="text-gray-900 font-bold">{{ $sparepart->stock }}</span>
                </div>

                <div class="flex items-center justify-between py-3">
                    <span class="text-gray-600 text-sm">Status</span>
                    <span class="badge badge-{{ $sparepart->is_active ? 'green' : 'gray' }}">{{ $sparepart->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                </div>

                <div class="pt-2">
                    <p class="text-gray-600 text-sm">{{ $sparepart->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

