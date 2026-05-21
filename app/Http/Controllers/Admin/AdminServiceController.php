<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
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

        $data['slug'] = $this->generateUniqueSlug(Str::slug($data['name']));
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($data);

        // simpan relasi sparepart yang dipilih
        $selectedSparepartIds = $request->input('sparepart_ids', []);
        if (!is_array($selectedSparepartIds)) {
            $selectedSparepartIds = [];
        }
        $service->spareparts()->sync($selectedSparepartIds);

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

        // Pastikan slug unik untuk service lain (hindari bentrok dengan record sendiri)
        $data['slug'] = $this->generateUniqueSlug(
            Str::slug($data['name']),
            $service->id
        );

        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        // simpan relasi sparepart yang dipilih
        $selectedSparepartIds = $request->input('sparepart_ids', []);
        if (!is_array($selectedSparepartIds)) {
            $selectedSparepartIds = [];
        }
        $service->spareparts()->sync($selectedSparepartIds);

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

    /**
     * Generate slug yang unique.
     * Contoh: keyboard-langsung-pasang, keyboard-langsung-pasang-1, -2, dst.
     */
    private function generateUniqueSlug(string $baseSlug, ?int $ignoreServiceId = null): string
    {
        $baseSlug = trim($baseSlug);
        if ($baseSlug === '') {
            $baseSlug = 'service';
        }

        $query = Service::query();

        if ($ignoreServiceId !== null) {
            $query->where('id', '!=', $ignoreServiceId);
        }

        // jika slug belum dipakai, langsung pakai
        $exists = $query->clone()->where('slug', $baseSlug)->exists();
        if (!$exists) {
            return $baseSlug;
        }

        // jika sudah ada, cari slug dengan suffix incremental yang belum dipakai.
        for ($i = 1; $i < 10000; $i++) {
            $candidate = $baseSlug . '-' . $i;

            $candidateExists = $query
                ->clone()
                ->where('slug', $candidate)
                ->exists();

            if (!$candidateExists) {
                return $candidate;
            }
        }

        // fallback (secara praktis 10000 loop sudah sangat cukup)
        return $baseSlug . '-' . Str::random(6);
    }
}

