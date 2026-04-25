@extends('layouts.admin')
@section('title','Edit Pembayaran')
@section('page-title','Edit Metode Pembayaran')
@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="service-card p-8 rounded-2xl space-y-5">
@csrf @method('PUT')
<div class="grid grid-cols-2 gap-5">
<div class="col-span-2"><label class="block text-sm text-gray-600 mb-2">Nama *</label><input type="text" name="name" required class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('name',$payment->name) }}"></div>
<div><label class="block text-sm text-gray-600 mb-2">Tipe *</label><select name="type" required class="form-input w-full px-4 py-3 rounded-xl text-sm"><option value="bank_transfer" {{ $payment->type==='bank_transfer'?'selected':'' }}>Transfer Bank</option><option value="e_wallet" {{ $payment->type==='e_wallet'?'selected':'' }}>E-Wallet</option><option value="cod" {{ $payment->type==='cod'?'selected':'' }}>COD</option></select></div>
<div><label class="block text-sm text-gray-600 mb-2">Provider *</label><input type="text" name="provider" required class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('provider',$payment->provider) }}"></div>
<div><label class="block text-sm text-gray-600 mb-2">Nomor Rekening</label><input type="text" name="account_number" class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('account_number',$payment->account_number) }}"></div>
<div><label class="block text-sm text-gray-600 mb-2">Nama Pemilik</label><input type="text" name="account_name" class="form-input w-full px-4 py-3 rounded-xl text-sm" value="{{ old('account_name',$payment->account_name) }}"></div>
<div class="col-span-2"><label class="block text-sm text-gray-600 mb-2">Instruksi</label><textarea name="instructions" rows="3" class="form-input w-full px-4 py-3 rounded-xl text-sm resize-none">{{ old('instructions',$payment->instructions) }}</textarea></div>
<div class="flex items-center gap-2"><input type="checkbox" name="is_active" class="w-4 h-4 rounded" {{ $payment->is_active?'checked':'' }}><span class="text-gray-700 text-sm">Aktif</span></div>
</div>
<div class="flex gap-4"><a href="{{ route('admin.payments.index') }}" class="btn-outline flex-1 text-center py-3 rounded-xl text-red-600 text-sm">Batal</a><button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white text-sm font-semibold">Perbarui</button></div>
</form>
</div>
@endsection
