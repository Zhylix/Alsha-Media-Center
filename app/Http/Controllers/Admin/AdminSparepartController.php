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
        
        $connection = $query->getModel()->getConnection();
        $hasSortOrder = $connection->getSchemaBuilder()->hasColumn('spareparts', 'sort_order');

        if ($hasSortOrder) {
            $spareparts = $query->orderBy('sort_order')->latest()->paginate(15)->withQueryString();
        } else {
            $spareparts = $query->latest()->paginate(15)->withQueryString();
        }





        $categories = SparepartCategory::where('is_active', true)->orderBy('service_category')->orderBy('part_type')->get();
        $serviceCategories = $categories->pluck('service_category')->unique()->values()->all();
        $partTypes = $categories->pluck('part_type')->unique()->values()->all();

        return view('admin.spareparts.index', [
            'spareparts' => $spareparts,
            'serviceCategories' => $serviceCategories,
            'partTypes' => $partTypes,
            'categories' => $categories,
            'filters' => $request->only(['search', 'service_category', 'part_type', 'status']),
        ]);
    }

public function create()
    {
        $categories = SparepartCategory::where('is_active', true)
            ->orderBy('service_category')
            ->orderBy('part_type')
            ->get();

        // Ambil daftar service category dari tabel services (biar PC/Printer/Software selalu muncul)
        $serviceTypes = 
            \App\Models\Service::query()
                ->whereIn('category', ['laptop', 'pc', 'printer', 'software'])
                ->select('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category')
                ->values();

        return view('admin.spareparts.create', compact('categories', 'serviceTypes'));
    }

    public function store(Request $request)
    {
        // Handle new part type creation
        if ($request->filled('new_part_type') && $request->filled('service_category')) {
            // Check if this combination already exists
            $existing = SparepartCategory::where('service_category', $request->input('service_category'))
                ->where('part_type', $request->input('new_part_type'))
                ->first();

            if (!$existing) {
                // Create new category
                $newCategory = SparepartCategory::create([
                    'service_category' => $request->input('service_category'),
                    'part_type' => $request->input('new_part_type'),
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
                $request->merge(['sparepart_category_id' => $newCategory->id]);
            } else {
                $request->merge(['sparepart_category_id' => $existing->id]);
            }
        }

 
        $serviceCategory = $request->input('service_category');
        $partType = $request->input('part_type');

        // Jika step 2 mengirim kombinasi service + part_type, turunkan ke sparepart_category_id.
        if ($request->filled(['service_category', 'part_type']) && !$request->filled('sparepart_category_id')) {
            $match = SparepartCategory::where('service_category', $serviceCategory)
                ->where('part_type', $partType)
                ->first();

            if ($match) {
                $request->merge(['sparepart_category_id' => $match->id]);
            }
        }

        // Jika data belum lengkap, coba ambil dari session (step 1).
        // (Untuk kasus: step 2 cuma kirim part_type)
        if (!$request->filled('service_category') && $request->session()->has('sparepart_step1.service_category')) {
            $request->merge([
                'service_category' => $request->session()->get('sparepart_step1.service_category'),
            ]);
        }

        if (!$request->filled('part_type') && $request->session()->has('sparepart_step1.part_type')) {
            $request->merge([
                'part_type' => $request->session()->get('sparepart_step1.part_type'),
            ]);
        }

        if ($request->filled(['service_category', 'part_type']) && !$request->filled('sparepart_category_id')) {
            $match = SparepartCategory::where('service_category', $request->input('service_category'))
                ->where('part_type', $request->input('part_type'))
                ->first();

            if ($match) {
                $request->merge(['sparepart_category_id' => $match->id]);
            }
        }


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sparepart_category_id' => 'required|exists:sparepart_categories,id',

            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'new_part_type' => 'nullable|string|max:255',
        ]);



        $path = $request->file('image')->store('spareparts', 'public');

        $validated['image'] = $path;
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // slug diperlukan karena kolom slug tidak punya default value di DB
        if (empty($validated['slug'] ?? null)) {
            $validated['slug'] = Str::slug($validated['name'] ?? $request->input('name'));
        }

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

