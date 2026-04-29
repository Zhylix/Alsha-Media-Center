@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('page-title', 'Pesan Masuk')
@section('page-subtitle', 'Kelola pesan kontak dari pelanggan')

@section('content')
<div class="service-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Subjek</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr>
                    <td>
                        <p class="text-gray-900 font-medium text-sm">{{ $msg->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $msg->email }}</p>
                    </td>
                    <td class="text-gray-700 text-sm">{{ Str::limit($msg->subject, 40) }}</td>
                    <td class="text-gray-600 text-xs">{{ $msg->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if(!$msg->is_read)
                            <span class="badge badge-red">Baru</span>
                        @else
                            <span class="badge badge-gray">Dibaca</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.contacts.show', $msg) }}" class="px-3 py-1.5 rounded-lg bg-red-600/10 text-red-600 hover:bg-red-600/20 text-xs font-medium transition-colors">Baca</a>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $msg) }}" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 text-xs font-medium transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($messages->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-10">Belum ada pesan masuk</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
    <div class="px-6 py-4 border-t border-red-600/10">{{ $messages->links() }}</div>
    @endif
</div>
@endsection
