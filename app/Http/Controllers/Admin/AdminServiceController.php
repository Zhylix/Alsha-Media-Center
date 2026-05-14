<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('category')->orderBy('sort_order')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'category'           => 'required|in:laptop,printer,pc,software',
            'description'        => 'required|string',
            'short_description'  => 'nullable|string|max:300',
            'price_start'        => 'required|numeric|min:0',
            'price_end'          => 'nullable|numeric|min:0',
            'price_jasa'         => 'required|numeric|min:0',
            'estimated_days'     => 'required|integer|min:1',
            'is_active'          => 'boolean',
            'is_featured'        => 'boolean',
            'sort_order'         => 'integer|min:0',
            'image'              => 'nullable|image|max:2048',
        ]);

        $data['slug']        = Str::slug($data['name']);
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'category'           => 'required|in:laptop,printer,pc,software',
            'description'        => 'required|string',
            'short_description'  => 'nullable|string|max:300',
            'price_start'        => 'required|numeric|min:0',
            'price_end'          => 'nullable|numeric|min:0',
            'price_jasa'         => 'required|numeric|min:0',
            'estimated_days'     => 'required|integer|min:1',
            'sort_order'         => 'integer|min:0',
            'image'              => 'nullable|image|max:2048',
        ]);

        $data['slug']        = Str::slug($data['name']);
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus!');
    }

    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }
}
