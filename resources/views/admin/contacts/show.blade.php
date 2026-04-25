@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan Kontak')
@section('page-subtitle', 'Dari: ' . $contact->name)

@section('content')
<div class="max-w-3xl grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Message -->
    <div class="lg:col-span-2 space-y-5">
        <div class="service-card p-6 rounded-2xl">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">{{ $contact->subject }}</h3>
                    <p class="text-gray-500 text-xs mt-1">{{ $contact->created_at->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }}</p>
                </div>
                @if(!$contact->is_read)
                    <span class="badge badge-red">Baru</span>
                @else
                    <span class="badge badge-gray">Sudah Dibaca</span>
                @endif
            </div>
            <div class="bg-gray-50 rounded-xl p-5 border border-red-600/10">
                <p class="text-gray-700 text-sm leading-relaxed">{{ $contact->message }}</p>
            </div>

        <!-- Reply Section -->
        @if($contact->reply)
        <div class="service-card p-6 rounded-2xl border-red-600/20">
            <h3 class="font-bold text-red-600 mb-3 flex items-center gap-2"><i class="fas fa-reply text-red-600"></i> Balasan Admin</h3>
            <p class="text-gray-700 text-sm">{{ $contact->reply }}</p>
            <p class="text-gray-500 text-xs mt-2">Dibalas pada: {{ $contact->replied_at?->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') ?? '-' }}</p>
        </div>
        @endif
    </div>

    <!-- Sender Info -->
    <div class="space-y-5">
        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-user text-red-600"></i> Pengirim</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-500 text-xs">Nama</p>
                    <p class="text-gray-900 font-medium">{{ $contact->name }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Email</p>
                    <a href="mailto:{{ $contact->email }}" class="text-red-600 hover:text-gray-900 transition-colors">{{ $contact->email }}</a>
                </div>
                @if($contact->phone)
                <div>
                    <p class="text-gray-500 text-xs">Telepon</p>
                    <a href="tel:{{ $contact->phone }}" class="text-red-600 hover:text-gray-900 transition-colors">{{ $contact->phone }}</a>
                </div>
                @endif
            </div>

        <div class="flex flex-col gap-3">
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" target="_blank" class="btn-primary text-center py-3 rounded-xl text-white text-sm font-semibold"><i class="fas fa-envelope text-red-600"></i> Balas via Email</a>
            @if($contact->phone)
            <a href="https://wa.me/{{ preg_replace('/\D/','',$contact->phone) }}" target="_blank" class="btn-outline text-center py-3 rounded-xl text-red-600 text-sm font-semibold"><i class="fas fa-comments text-red-600"></i> Balas via WA</a>
            @endif
            <a href="{{ route('admin.contacts.index') }}" class="btn-outline text-center py-3 rounded-xl text-red-600 text-sm font-semibold"><i class="fas fa-arrow-left"></i> Kembali</a>
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full py-3 rounded-xl bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 text-sm font-semibold transition-colors"><i class="fas fa-trash-alt text-red-400"></i> Hapus Pesan</button>
            </form>
        </div>
</div>
@endsection
