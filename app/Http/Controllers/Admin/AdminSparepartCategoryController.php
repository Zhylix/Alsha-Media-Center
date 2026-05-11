<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SparepartCategory;
use Illuminate\Http\Request;

class AdminSparepartCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_category' => 'required|string|max:255',
            'part_type' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Check if combination already exists
        $exists = SparepartCategory::where('service_category', $validated['service_category'])
            ->where('part_type', $validated['part_type'])
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Kombinasi kategori dan jenis sparepart sudah ada.'], 422);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        SparepartCategory::create($validated);

        return response()->json(['success' => 'Kategori sparepart berhasil ditambahkan!']);
    }
}