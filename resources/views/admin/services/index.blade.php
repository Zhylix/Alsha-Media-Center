@extends('layouts.admin')
@section('title', 'Kelola Layanan')
@section('page-title', 'Kelola Layanan')
@section('page-subtitle', 'CRUD - Manajemen jasa service')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.services.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        + Tambah Layanan
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th>Nama Layanan</th><th>Kategori</th><th>Harga Mulai</th><th>Status</th><th>Featured</th><th>Aksi</th>
            </tr></thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td>
                        <p class="text-white font-semibold text-sm">{{ $service->name }}</p>
                        <p class="text-slate-500 text-xs">{{ Str::limit($service->short_description, 50) }}</p>
                    </td>
                    <td>
                        <span class="badge badge-{{ $service->category === 'laptop' ? 'blue' : ($service->category === 'printer' ? 'purple' : 'green') }}">
                            {{ $service->category_label }}
                        </span>
                    </td>
                    <td class="text-blue-400 font-semibold text-sm">Rp {{ number_format($service->price_start, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $service->is_active ? 'green' : 'gray' }}">
                            {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        @if($service->is_featured)<span class="badge badge-yellow"><i class="fas fa-star text-yellow-400"></i> Ya</span>@else<span class="text-slate-600 text-xs">-</span>@endif
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}" class="px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 text-xs font-medium transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Hapus layanan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($services->isEmpty())
                <tr><td colspan="6" class="text-center text-slate-500 py-10">Belum ada layanan. <a href="{{ route('admin.services.create') }}" class="text-blue-400">Tambah sekarang</a></td></tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($services->hasPages())
    <div class="px-6 py-4 border-t border-blue-500/10">{{ $services->links() }}</div>
    @endif
</div>
@endsection
