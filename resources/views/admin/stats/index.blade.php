@extends('layouts.admin')
@section('title', 'Kelola Stats')
@section('page-title', 'Kelola Stats')
@section('page-subtitle', 'CRUD - Manajemen statistik hero section')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.stats.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        + Tambah Stat
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Label</th>
                    <th>Nilai</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats as $stat)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <span class="text-2xl text-red-600"><i class="{{ $stat->icon }}"></i></span>
                            <p class="text-gray-600 text-xs font-mono">{{ $stat->icon }}</p>
                        </div>
                    </td>
                    <td>
                        <p class="text-gray-900 font-semibold text-sm">{{ $stat->label }}</p>
                    </td>
                    <td>
                        <p class="text-gray-900 font-bold text-lg">{{ $stat->value }}</p>
                    </td>
                    <td>
                        <span class="badge badge-gray">{{ $stat->sort_order }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $stat->is_active ? 'red' : 'gray' }}">
                            {{ $stat->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.stats.edit', $stat) }}" class="px-3 py-1.5 rounded-lg bg-red-600/10 text-red-600 hover:bg-red-600/20 text-xs font-medium transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.stats.destroy', $stat) }}" onsubmit="return confirm('Hapus stat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-gray-500/10 text-gray-500 hover:bg-gray-500/20 text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($stats->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-10">
                        Belum ada stat. <a href="{{ route('admin.stats.create') }}" class="text-red-600">Tambah sekarang</a>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($stats->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">{{ $stats->links() }}</div>
    @endif
</div>
@endsection
