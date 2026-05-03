@extends('layouts.admin')
@section('title', 'Kelola Sparepart')
@section('page-title', 'Kelola Sparepart')
@section('page-subtitle', 'Manajemen stok dan kategori sparepart laptop, printer, dan PC')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex gap-2">
        <a href="{{ route('admin.spareparts.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('category') ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-200' }}">Semua</a>
        <a href="{{ route('admin.spareparts.index', ['category' => 'laptop']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('category') == 'laptop' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-200' }}">Laptop</a>
        <a href="{{ route('admin.spareparts.index', ['category' => 'printer']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('category') == 'printer' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-200' }}">Printer</a>
        <a href="{{ route('admin.spareparts.index', ['category' => 'pc']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('category') == 'pc' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-200' }}">PC</a>
    </div>
    <a href="{{ route('admin.spareparts.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        + Tambah Sparepart
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th>Sparepart</th><th>Kategori</th><th>Harga</th><th>Status Stok</th><th>Aksi</th>
            </tr></thead>
            <tbody>
                @foreach($spareparts as $item)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-red-600/10 flex items-center justify-center text-red-600"><i class="fas fa-box"></i></div>
                            @endif
                            <div>
                                <p class="text-gray-900 font-semibold text-sm">{{ $item->name }}</p>
                                <p class="text-gray-500 text-xs line-clamp-2">{{ $item->description ?: 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-light uppercase text-[10px]">{{ $item->category }}</span>
                    </td>
                    <td class="text-gray-900 font-bold text-sm">
                        {{ $item->price ? 'Rp ' . number_format($item->price, 0, ',', '.') : 'Hubungi Kami' }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $item->is_available ? 'green' : 'red' }}">
                            {{ $item->is_available ? 'Tersedia' : 'Habis' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.spareparts.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-red-600/10 text-red-600 hover:bg-red-600/20 text-xs font-medium transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.spareparts.destroy', $item) }}" onsubmit="return confirm('Hapus sparepart ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($spareparts->isEmpty())
                <tr><td colspan="5" class="text-center text-gray-500 py-10">Belum ada sparepart. <a href="{{ route('admin.spareparts.create') }}" class="text-red-600">Tambah sekarang</a></td></tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($spareparts->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">{{ $spareparts->links() }}</div>
    @endif
</div>
@endsection
