@extends('layouts.admin')
@section('title','Kelola Pengiriman')
@section('page-title','Kelola Pengiriman')
@section('content')
<div class="flex justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.shipments.create') }}" class="btn-primary px-5 py-3 rounded-xl text-white font-semibold text-sm">+ Tambah</a>
</div>
<div class="service-card rounded-2xl overflow-hidden">
    <table class="admin-table w-full">
        <thead><tr><th>Nama</th><th>Provider</th><th>Harga</th><th>Est. Hari</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($shipments as $s)
            <tr>
                <td class="text-white font-medium text-sm">{{ $s->name }}</td>
                <td class="text-slate-400 text-sm">{{ $s->provider }}</td>
                <td class="text-blue-400 font-semibold text-sm">{{ $s->price == 0 ? 'Gratis' : 'Rp '.number_format($s->price,0,',','.') }}</td>
                <td class="text-slate-300 text-sm">{{ $s->estimated_days }} hari</td>
                <td><span class="badge badge-{{ $s->is_active ? 'green' : 'gray' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="flex gap-2">
                    <a href="{{ route('admin.shipments.edit', $s) }}" class="px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-400 text-xs">Edit</a>
                    <form method="POST" action="{{ route('admin.shipments.destroy', $s) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 text-xs">Hapus</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
