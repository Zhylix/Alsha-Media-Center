<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminPaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pakets.index', compact('pakets'));
    }

    public function create()
    {
        return view('admin.pakets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'discount_info' => 'nullable|string|max:100',
            'price'         => 'required|numeric|min:0',
            'sort_order'    => 'nullable|integer|min:0',
            'image'         => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . rand(100, 999);
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;


        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pakets', 'public');
        }

        Paket::create($data);
        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit(Paket $paket)
    {
        return view('admin.pakets.edit', compact('paket'));
    }

    public function update(Request $request, Paket $paket)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'discount_info' => 'nullable|string|max:100',
            'price'         => 'required|numeric|min:0',
            'sort_order'    => 'nullable|integer|min:0',
            'image'         => 'nullable|image|max:2048',
        ]);


        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($paket->image) {
                Storage::disk('public')->delete($paket->image);
            }
            $data['image'] = $request->file('image')->store('pakets', 'public');
        }

        $paket->update($data);
        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(Paket $paket)
    {
        if ($paket->image) {
            Storage::disk('public')->delete($paket->image);
        }

        $paket->delete();
        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil dihapus!');
    }

    public function show(Paket $paket)
    {
        return redirect()->route('admin.pakets.index');
    }
}
