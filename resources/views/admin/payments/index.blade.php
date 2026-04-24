@extends('layouts.admin')
@section('title','Kelola Pembayaran')
@section('page-title','Kelola Metode Pembayaran')
@section('content')
<div class="flex justify-between mb-6"><div></div><a href="{{ route('admin.payments.create') }}" class="btn-primary px-5 py-3 rounded-xl text-white font-semibold text-sm">+ Tambah</a></div>
<div class="service-card rounded-2xl overflow-hidden">
<table class="admin-table w-full">
<thead><tr><th>Nama</th><th>Tipe</th><th>Provider</th><th>Nomor Akun</th><th>Status</th><th>Aksi</th></tr></thead>
<tbody>
@foreach($methods as $m)
<tr>
<td class="text-white font-medium text-sm">{{ $m->name }}</td>
<td><span class="badge badge-{{ $m->type==='bank_transfer'?'blue':($m->type==='e_wallet'?'purple':'green') }}">{{ $m->type_label }}</span></td>
<td class="text-slate-400 text-sm">{{ $m->provider }}</td>
<td class="text-slate-300 text-sm font-mono">{{ $m->account_number ?? '-' }}</td>
<td><span class="badge badge-{{ $m->is_active?'green':'gray' }}">{{ $m->is_active?'Aktif':'Nonaktif' }}</span></td>
<td class="flex gap-2">
<a href="{{ route('admin.payments.edit', $m) }}" class="px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-400 text-xs">Edit</a>
<form method="POST" action="{{ route('admin.payments.destroy', $m) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 text-xs">Hapus</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection
