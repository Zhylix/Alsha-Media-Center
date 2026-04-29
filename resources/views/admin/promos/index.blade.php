@extends('layouts.admin')
@section('title', 'Kelola Promo')
@section('page-title', 'Kelola Promo')
@section('page-subtitle', 'Manajemen penawaran spesial dan promo')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.promos.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        + Tambah Promo
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th>Judul Promo</th><th>Diskon/Info</th><th>Masa Berlaku</th><th>Status</th><th>Aksi</th>
            </tr></thead>
            <tbody>
                @foreach($promos as $promo)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            @if($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-red-600/10 flex items-center justify-center text-red-600"><i class="fas fa-tags"></i></div>
                            @endif
                            <div>
                                <p class="text-gray-900 font-semibold text-sm">{{ $promo->title }}</p>
                                <p class="text-gray-500 text-xs">{{ Str::limit($promo->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-red-600 font-bold text-sm">{{ $promo->discount_info ?? '-' }}</td>
                    <td class="text-gray-600 text-xs">
                        {{ $promo->start_date->format('d/m/Y') }} - {{ $promo->end_date->format('d/m/Y') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $promo->isValid ? 'green' : 'gray' }}">
                            {{ $promo->isValid ? 'Berjalan' : ($promo->is_active ? 'Terjadwal/Berakhir' : 'Nonaktif') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.promos.edit', $promo) }}" class="px-3 py-1.5 rounded-lg bg-red-600/10 text-red-600 hover:bg-red-600/20 text-xs font-medium transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}" onsubmit="return confirm('Hapus promo ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($promos->isEmpty())
                <tr><td colspan="5" class="text-center text-gray-500 py-10">Belum ada promo. <a href="{{ route('admin.promos.create') }}" class="text-red-600">Tambah sekarang</a></td></tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($promos->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">{{ $promos->links() }}</div>
    @endif
</div>
@endsection
