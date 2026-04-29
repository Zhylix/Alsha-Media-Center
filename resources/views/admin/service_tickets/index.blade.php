@extends('layouts.admin')
@section('title', 'Data Servis')
@section('page-title', 'Data Servis Masuk')
@section('page-subtitle', 'Tracking & manajemen servis PC, Laptop, Printer')

@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
    <form method="GET" action="{{ route('admin.service-tickets.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari kode / nama / no.hp" class="form-input px-4 py-2.5 rounded-xl text-sm w-full sm:w-64">
        <select name="status" class="form-input px-4 py-2.5 rounded-xl text-sm w-full sm:w-44">
            <option value="">-- Semua Status --</option>
            @foreach($statuses as $key => $label)
                <option value="{{ $key }}" {{ ($filters['status'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-semibold"><i class="fas fa-search"></i> Cari</button>
        @if(!empty($filters['search']) || !empty($filters['status']))
            <a href="{{ route('admin.service-tickets.index') }}" class="btn-outline px-4 py-2.5 rounded-xl text-red-600 text-sm font-semibold text-center"><i class="fas fa-times"></i> Reset</a>
        @endif
    </form>
    <a href="{{ route('admin.service-tickets.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        <i class="fas fa-plus"></i> Input Servis
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Kode Servis</th>
                    <th>Nama Pelanggan</th>
                    <th>Perangkat</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td>
                        <p class="font-mono font-bold text-red-600 text-sm">{{ $ticket->service_code }}</p>
                        <p class="text-gray-400 text-xs">{{ Str::limit($ticket->phone, 20) }}</p>
                    </td>
                    <td>
                        <p class="text-gray-900 font-semibold text-sm">{{ $ticket->customer_name }}</p>
                        <p class="text-gray-500 text-xs">{{ Str::limit($ticket->problem ?? '', 40) }}</p>
                    </td>
                    <td>
                        <span class="badge badge-{{ $ticket->device_type === 'pc' ? 'blue' : ($ticket->device_type === 'laptop' ? 'purple' : 'green') }}">
                            {{ $ticket->device_type_label }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $ticket->status_color }}">
                            {{ $ticket->status_label }}
                        </span>
                    </td>
                    <td class="text-gray-600 text-sm whitespace-nowrap">
                        {{ $ticket->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.service-tickets.edit', $ticket) }}" class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-xs font-medium transition-colors">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.service-tickets.destroy', $ticket) }}" onsubmit="return confirm('Hapus servis {{ $ticket->service_code }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-10">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-inbox text-3xl text-gray-300"></i>
                            <p>Belum ada data servis.</p>
                            <a href="{{ route('admin.service-tickets.create') }}" class="text-red-600 font-medium">Input servis baru</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tickets->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
