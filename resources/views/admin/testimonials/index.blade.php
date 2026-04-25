@extends('layouts.admin')
@section('title', 'Kelola Testimonial')
@section('page-title', 'Kelola Testimonial')
@section('page-subtitle', 'CRUD - Manajemen testimoni pelanggan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold text-sm">
        + Tambah Testimonial
    </a>
</div>

<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($testimonials as $t)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full gradient-anim flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($t->customer_name, 0, 1)) }}
                            </div>
                            <p class="text-gray-900 font-semibold text-sm">{{ $t->customer_name }}</p>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-gray">
                            {!! $t->service_type === 'laptop' ? '<i class="fas fa-laptop text-red-600"></i> Laptop' : ($t->service_type === 'printer' ? '<i class="fas fa-print text-red-600"></i> Printer' : '<i class="fas fa-mobile-alt text-red-600"></i> HP') !!}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1 text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= $t->rating ? '' : 'text-gray-300' }}"></i>
                            @endfor
                            <span class="text-gray-600 text-xs ml-1">({{ $t->rating }})</span>
                        </div>
                    </td>
                    <td>
                        <p class="text-gray-600 text-sm max-w-xs truncate" title="{{ $t->comment }}">{{ $t->comment }}</p>
                    </td>
                    <td>
                        <span class="badge badge-{{ $t->is_active ? 'red' : 'gray' }}">
                            {{ $t->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="px-3 py-1.5 rounded-lg bg-red-600/10 text-red-600 hover:bg-red-600/20 text-xs font-medium transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('Hapus testimonial ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-gray-500/10 text-gray-500 hover:bg-gray-500/20 text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($testimonials->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-10">
                        Belum ada testimonial. <a href="{{ route('admin.testimonials.create') }}" class="text-red-600">Tambah sekarang</a>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($testimonials->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">{{ $testimonials->links() }}</div>
    @endif
</div>
@endsection

