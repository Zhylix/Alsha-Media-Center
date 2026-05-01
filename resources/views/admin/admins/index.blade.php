@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Akun Admin')
@section('page-subtitle', 'Manajemen akun administrator')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Stats -->
    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="service-card p-5 rounded-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center text-white">
                    <i class="fas fa-users text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total Admin</p>
                    <p class="text-xl font-bold text-gray-900">{{ $admins->count() }}</p>
                </div>
            </div>
        </div>
        <div class="service-card p-5 rounded-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white">
                    <i class="fas fa-user-shield text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Superadmin</p>
                    <p class="text-xl font-bold text-gray-900">{{ $admins->where('role', 'superadmin')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="service-card p-5 rounded-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Admin</p>
                    <p class="text-xl font-bold text-gray-900">{{ $admins->where('role', 'admin')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="service-card p-5 rounded-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Aktif</p>
                    <p class="text-xl font-bold text-gray-900">{{ $admins->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin List -->
    <div class="lg:col-span-2">
        <div class="service-card rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Daftar Admin</h3>
                <a href="{{ route('admin.admins.create') }}" class="btn-primary px-4 py-2 rounded-xl text-sm font-medium">
                    <i class="fas fa-plus"></i> Tambah Admin
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold">Admin</th>
                            <th class="px-5 py-3 text-left font-semibold">Kontak</th>
                            <th class="px-5 py-3 text-left font-semibold">Role</th>
                            <th class="px-5 py-3 text-left font-semibold">Status</th>
                            <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($admins as $admin)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $admin->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $admin->username }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-sm">
                                    <p class="text-gray-900"><i class="fas fa-envelope text-gray-400 mr-1"></i> {{ $admin->email }}</p>
                                    @if($admin->whatsapp)
                                    <p class="text-gray-500"><i class="fab fa-whatsapp text-gray-400 mr-1"></i> {{ $admin->whatsapp }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                @if($admin->role === 'superadmin')
                                <span class="badge badge-yellow">
                                    <i class="fas fa-shield-alt mr-1"></i> Superadmin
                                </span>
                                @else
                                <span class="badge badge-blue">
                                    <i class="fas fa-user mr-1"></i> Admin
                                </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($admin->is_active)
                                <span class="badge badge-green">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                                @else
                                <span class="badge badge-red">
                                    <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="p-2 rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($admin->id != session('admin_id'))
                                    <form method="POST" action="{{ route('admin.admins.toggle', $admin->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="p-2 rounded-lg {{ $admin->is_active ? 'bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500/20' : 'bg-green-500/10 text-green-500 hover:bg-green-500/20' }} transition-colors" title="{{ $admin->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $admin->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}" onsubmit="return confirm('Yakin ingin menghapus admin {{ $admin->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500/20 transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-400 px-2 py-1" title="Akun Anda">(Anda)</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                                <i class="fas fa-users text-3xl mb-2"></i>
                                <p>Belum ada admin</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
