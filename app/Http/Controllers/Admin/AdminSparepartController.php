<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminSparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->paginate(15);
        return view('admin.spareparts.index', compact('spareparts'));
    }

    public function create()
    {
        return view('admin.spareparts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|in:laptop,printer,pc',
            'price'         => 'nullable|numeric|min:0',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|max:2048',
            'is_available'  => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . rand(100, 999);
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('spareparts', 'public');
        }

        Sparepart::create($data);
        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil ditambahkan!');
    }

    public function edit(Sparepart $sparepart)
    {
        return view('admin.spareparts.edit', compact('sparepart'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|in:laptop,printer,pc',
            'price'         => 'nullable|numeric|min:0',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . rand(100, 999);
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            if ($sparepart->image) {
                Storage::disk('public')->delete($sparepart->image);
            }
            $data['image'] = $request->file('image')->store('spareparts', 'public');
        }

        $sparepart->update($data);
        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil diperbarui!');
    }

    public function destroy(Sparepart $sparepart)
    {
        if ($sparepart->image) {
            Storage::disk('public')->delete($sparepart->image);
        }
        $sparepart->delete();
        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil dihapus!');
    }
}
