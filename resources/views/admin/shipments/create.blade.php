@extends('layouts.admin')
@section('title','Tambah Pengiriman')
@section('page-title','Tambah Opsi Pengiriman')
@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ route('admin.shipments.store') }}" class="service-card p-8 rounded-2xl space-y-5">
@csrf
<div class="grid grid-cols-2 gap-5">
<div class="col-span-2"><label class="block text-sm text-slate-400 mb-2">Nama *</label><input type="text" name="name" required class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('name') }}"></div>
<div><label class="block text-sm text-slate-400 mb-2">Provider *</label><input type="text" name="provider" required class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('provider') }}"></div>
<div><label class="block text-sm text-slate-400 mb-2">Harga (Rp) *</label><input type="number" name="price" required min="0" class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('price',0) }}"></div>
<div><label class="block text-sm text-slate-400 mb-2">Estimasi Hari *</label><input type="number" name="estimated_days" required min="0" class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('estimated_days',1) }}"></div>
<div class="flex items-center gap-2 pt-6"><input type="checkbox" name="is_active" checked class="w-4 h-4 rounded"><span class="text-slate-300 text-sm">Aktif</span></div>
<div class="col-span-2"><label class="block text-sm text-slate-400 mb-2">Deskripsi</label><textarea name="description" rows="3" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none">{{ old('description') }}</textarea></div>
</div>
<div class="flex gap-4"><a href="{{ route('admin.shipments.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-white text-sm">Batal</a><button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white text-sm font-semibold">Simpan</button></div>
</form>
</div>
@endsection
