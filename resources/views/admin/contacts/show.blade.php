@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan Kontak')
@section('page-subtitle', 'Dari: ' . $contact->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Message & Reply -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Main Message -->
        <div class="service-card p-6 rounded-2xl">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-xl">{{ $contact->subject }}</h3>
                    <p class="text-gray-500 text-xs mt-1">
                        <i class="far fa-calendar-alt mr-1"></i> 
                        {{ $contact->created_at->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }}
                    </p>
                </div>
                <div>
                    @if(!$contact->is_read)
                        <span class="badge badge-red">Baru</span>
                    @else
                        <span class="badge badge-gray">Sudah Dibaca</span>
                    @endif
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</p>
            </div>
        </div>

        <!-- Reply Section -->
        @if($contact->reply)
        <div class="service-card p-6 rounded-2xl border-red-600/20 bg-red-50/30">
            <h3 class="font-bold text-red-600 mb-4 flex items-center gap-2">
                <i class="fas fa-reply"></i> Balasan Admin
            </h3>
            <div class="bg-white rounded-xl p-5 border border-red-100 shadow-sm">
                <p class="text-gray-700 text-sm leading-relaxed">{{ $contact->reply }}</p>
            </div>
            <p class="text-gray-500 text-xs mt-3 italic">
                Dibalas pada: {{ $contact->replied_at?->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') ?? '-' }}
            </p>
        </div>
        @endif
    </div>

    <!-- Sender Info & Actions -->
    <div class="space-y-6">
        <!-- Sender Card -->
        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-5 pb-3 border-b border-gray-100">
                <i class="fas fa-user-circle text-red-600 mr-2"></i> Informasi Pengirim
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-1">Nama Lengkap</p>
                    <p class="text-gray-900 font-semibold">{{ $contact->name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-1">Alamat Email</p>
                    <a href="mailto:{{ $contact->email }}" class="text-red-600 hover:text-red-700 transition-colors font-medium break-all">{{ $contact->email }}</a>
                </div>
                @if($contact->phone)
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-1">Nomor Telepon</p>
                    <a href="tel:{{ $contact->phone }}" class="text-red-600 hover:text-red-700 transition-colors font-medium">{{ $contact->phone }}</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Card -->
        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-5 pb-3 border-b border-gray-100">
                <i class="fas fa-cog text-red-600 mr-2"></i> Tindakan
            </h3>
            <div class="flex flex-col gap-3">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" target="_blank" class="btn-primary flex items-center justify-center gap-2 py-3 rounded-xl text-white text-sm font-bold">
                    <i class="fas fa-paper-plane"></i> Balas via Email
                </a>
                @if($contact->phone)
                <a href="https://wa.me/{{ preg_replace('/\D/','',$contact->phone) }}" target="_blank" class="btn-outline flex items-center justify-center gap-2 py-3 rounded-xl text-red-600 text-sm font-bold">
                    <i class="fab fa-whatsapp text-lg"></i> Balas via WhatsApp
                </a>
                @endif
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm font-bold transition-all">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                
                <div class="pt-2">
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-red-50 text-red-500 border border-red-100 hover:bg-red-100 text-sm font-bold transition-all">
                            <i class="fas fa-trash-alt"></i> Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
