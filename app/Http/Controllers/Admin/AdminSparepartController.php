<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use App\Models\SparepartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSparepartController extends Controller
{
    public function show(Sparepart $sparepart)
    {
        return view('admin.spareparts.show', compact('sparepart'));
    }

    public function index(Request $request)

    {
        $query = Sparepart::query()->with('sparepartCategory');

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhereHas('sparepartCategory', function ($qc) use ($term) {
                      $qc->where('part_type', 'like', "%{$term}%")
                         ->orWhere('service_category', 'like', "%{$term}%");
                  });
            });
        }

        if ($request->filled('service_category')) {
            $query->whereHas('sparepartCategory', function ($qc) use ($request) {
                $qc->where('service_category', $request->input('service_category'));
            });
        }

        if ($request->filled('part_type')) {
            $query->whereHas('sparepartCategory', function ($qc) use ($request) {
                $qc->where('part_type', $request->input('part_type'));
            });
        }

        if ($request->filled('status')) {
            if (in_array($request->input('status'), ['0', '1'], true)) {
                $query->where('is_active', (int) $request->input('status'));
            }
        }

        $spareparts = $query->orderBy('sort_order')->latest()->paginate(15)->withQueryString();

        $categories = SparepartCategory::where('is_active', true)->orderBy('service_category')->orderBy('part_type')->get();
        $serviceCategories = $categories->pluck('service_category')->unique()->values()->all();
        $partTypes = $categories->pluck('part_type')->unique()->values()->all();

        return view('admin.spareparts.index', [
            'spareparts' => $spareparts,
            'serviceCategories' => $serviceCategories,
            'partTypes' => $partTypes,
            'filters' => $request->only(['search', 'service_category', 'part_type', 'status']),
        ]);
    }

    public function create()
    {
        $categories = SparepartCategory::where('is_active', true)->orderBy('service_category')->orderBy('part_type')->get();
        return view('admin.spareparts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sparepart_category_id' => 'required|exists:sparepart_categories,id',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $path = $request->file('image')->store('spareparts', 'public');

        $validated['image'] = $path;
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Sparepart::create($validated);

        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil ditambahkan!');
    }

    public function edit(Sparepart $sparepart)
    {
        $categories = SparepartCategory::where('is_active', true)->orderBy('service_category')->orderBy('part_type')->get();
        return view('admin.spareparts.edit', compact('sparepart', 'categories'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sparepart_category_id' => 'required|exists:sparepart_categories,id',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('spareparts', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $sparepart->update($validated);

        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil diperbarui!');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();
        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil dihapus!');
    }
}

