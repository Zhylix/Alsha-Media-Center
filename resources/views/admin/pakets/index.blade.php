@extends('layouts.admin')
@section('title', 'Kelola Paket')
@section('page-title', 'Kelola Paket')
@section('page-subtitle', 'Manajemen penawaran spesial dan paket')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.pakets.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        + Tambah Paket
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th>Judul Paket</th><th>Diskon/Info</th><th>Harga</th><th>Status</th><th>Urutan</th><th>Aksi</th>
            </tr></thead>

            <tbody>
                @foreach($pakets as $paket)
                <tr>
                    <td>

                        <div class="flex items-center gap-3">
                            @if($paket->image)
                            <img src="{{ asset('storage/' . $paket->image) }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-red-600/10 flex items-center justify-center text-red-600"><i class="fas fa-tags"></i></div>
                            @endif
                            <div>
                                <p class="text-gray-900 font-semibold text-sm">{{ $paket->title }}</p>
                                <p class="text-gray-500 text-xs">{{ Str::limit($paket->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-red-600 font-bold text-sm">{{ $paket->discount_info ?? '-' }}</td>
                    <td class="text-gray-600 text-xs">
                        Rp {{ number_format((int)($paket->price ?? 0), 0, ',', '.') }}
                    </td>

                    <td>
                        <span class="badge badge-{{ $paket->isValid ? 'green' : 'gray' }}">
                            {{ $paket->isValid ? 'Berjalan' : ($paket->is_active ? 'Terjadwal/Berakhir' : 'Nonaktif') }}
                        </span>
                    </td>
                    <td class="text-center text-gray-600 font-semibold">{{ $paket->sort_order }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.pakets.edit', $paket) }}" class="px-3 py-1.5 rounded-lg bg-red-600/10 text-red-600 hover:bg-red-600/20 text-xs font-medium transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.pakets.destroy', $paket) }}" onsubmit="return confirm('Hapus paket ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($pakets->isEmpty())
                <tr><td colspan="5" class="text-center text-gray-500 py-10">Belum ada paket. <a href="{{ route('admin.pakets.create') }}" class="text-red-600">Tambah sekarang</a></td></tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($pakets->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">{{ $pakets->links() }}</div>
    @endif
</div>
@endsection
