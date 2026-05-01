@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin Baru')
@section('page-subtitle', 'Buat akun administrator baru')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.admins.store') }}" class="space-y-6">
        @csrf
        
        <div class="service-card p-6 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-5">Informasi Admin</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Nama lengkap admin">
                    @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Username</label>
                    <input type="text" name="username" required value="{{ old('username') }}"
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Username untuk login">
                    @error('username')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Password min. 6 karakter">
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="Konfirmasi password">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="email@example.com">
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                        class="form-input w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="0812xxxxxxx">
                    @error('whatsapp')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Role</label>
                    <select name="role" required class="form-input w-full px-4 py-3 rounded-xl text-sm">
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Biasa)</option>
                        <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    </select>
                    @error('role')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm text-gray-600">Aktifkan akun sekarang</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-6 py-3 rounded-xl font-medium">
                <i class="fas fa-save mr-2"></i> Simpan Admin
            </button>
            <a href="{{ route('admin.admins.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
