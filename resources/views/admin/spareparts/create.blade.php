@extends('layouts.admin')
@section('title', 'Tambah Sparepart')
@section('page-title', 'Tambah Sparepart')

@section('content')
<div class="max-w-4xl">
    <div class="service-card rounded-2xl p-6">
        <form action="{{ route('admin.spareparts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Sparepart</label>
                    <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none transition-all" placeholder="Contoh: SSD Samsung EVO 500GB" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                    <select name="category" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none transition-all" required>
                        <option value="laptop">Laptop</option>
                        <option value="printer">Printer</option>
                        <option value="pc">PC / Desktop</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="price" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none transition-all" placeholder="Contoh: 750000">
                    <p class="text-[10px] text-gray-500 mt-1">Kosongkan jika ingin menampilkan "Hubungi Kami"</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none transition-all" placeholder="Spesifikasi atau informasi detail sparepart..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Sparepart</label>
                    <input type="file" name="image" class="w-full px-4 py-2 rounded-xl border border-gray-200 outline-none transition-all text-sm">
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_available" id="is_available" value="1" checked class="w-5 h-5 rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <label for="is_available" class="text-sm font-bold text-gray-700">Tersedia / Ada Stok</label>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4 border-t border-gray-100 pt-6">
                <button type="submit" class="btn-primary px-8 py-3 rounded-xl text-white font-bold">
                    Simpan Sparepart
                </button>
                <a href="{{ route('admin.spareparts.index') }}" class="px-8 py-3 rounded-xl bg-gray-100 text-gray-600 font-bold hover:bg-gray-200 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
