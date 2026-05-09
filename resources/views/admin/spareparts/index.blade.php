@extends('layouts.admin')

@php use Illuminate\Support\Str; @endphp
@section('title', 'Spareparts')
@section('page-title', 'Spareparts')
@section('page-subtitle', 'Manajemen Sparepart')

@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
    <form method="GET" action="{{ route('admin.spareparts.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama / deskripsi / tipe" class="form-input px-4 py-2.5 rounded-xl text-sm w-full sm:w-64">

        <select name="service_category" class="form-input px-4 py-2.5 rounded-xl text-sm w-full sm:w-44">
            <option value="">-- Semua Service --</option>
            @foreach($serviceCategories as $cat)
                <option value="{{ $cat }}" {{ ($filters['service_category'] ?? '') === $cat ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $cat)) }}
                </option>
            @endforeach
        </select>

        <select name="part_type" class="form-input px-4 py-2.5 rounded-xl text-sm w-full sm:w-44">
            <option value="">-- Semua Jenis --</option>
            @foreach($partTypes as $type)
                <option value="{{ $type }}" {{ ($filters['part_type'] ?? '') === $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>

        <select name="status" class="form-input px-4 py-2.5 rounded-xl text-sm w-full sm:w-36">
            <option value="">-- Status --</option>
            <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ ($filters['status'] ?? '') === '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button type="submit" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-semibold">
            <i class="fas fa-search"></i> Cari
        </button>

        @if(!empty($filters['search']) || !empty($filters['service_category']) || !empty($filters['part_type']) || isset($filters['status']))
            <a href="{{ route('admin.spareparts.index') }}" class="btn-outline px-4 py-2.5 rounded-xl text-red-600 text-sm font-semibold text-center">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif
    </form>

    <a href="{{ route('admin.spareparts.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        <i class="fas fa-plus"></i> Tambah Sparepart
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spareparts as $sparepart)
                    <tr>
                        <td>
                            @if($sparepart->image)
                                <img src="{{ asset('storage/'.$sparepart->image) }}" alt="{{ $sparepart->name }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-lg"></div>
                            @endif
                        </td>
                        <td>
                            <p class="font-bold text-gray-900 text-sm">{{ $sparepart->name }}</p>
                            <p class="text-gray-500 text-xs">{{ Str::limit($sparepart->description ?? '', 40) }}</p>
                        </td>
                        <td>
                            <p class="font-semibold text-xs text-gray-900">{{ $sparepart->sparepartCategory->service_category ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $sparepart->sparepartCategory->part_type ?? '-' }}</p>
                        </td>
                        <td class="text-gray-900 font-semibold">Rp {{ number_format($sparepart->price, 0, ',', '.') }}</td>
                        <td class="text-gray-900 font-semibold">{{ $sparepart->stock }}</td>
                        <td>
                            <span class="badge badge-{{ $sparepart->is_active ? 'green' : 'gray' }}">{{ $sparepart->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.spareparts.edit', $sparepart) }}" class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form method="POST" action="{{ route('admin.spareparts.destroy', $sparepart) }}" onsubmit="return confirm('Hapus {{ $sparepart->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 text-xs font-medium transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-10">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-3xl text-gray-300"></i>
                                <p>Belum ada sparepart.</p>
                                <a href="{{ route('admin.spareparts.create') }}" class="text-red-600 font-medium">Tambah sparepart</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($spareparts->hasPages())
        <div class="px-6 py-4 border-t border-red-600/10">
            {{ $spareparts->links() }}
        </div>
    @endif
</div>
@endsection

