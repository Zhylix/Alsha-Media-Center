<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\StoreProfile;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $store = StoreProfile::first();
        $spareparts = Sparepart::available()->latest()->paginate(12);
        $title = 'Sparepart Laptop, Printer & PC';
        return view('spareparts.index', compact('store', 'spareparts', 'title'));
    }

    public function category($category)
    {
        $store = StoreProfile::first();
        $spareparts = Sparepart::available()
            ->where('category', $category)
            ->latest()
            ->paginate(12);
        
        $categoryNames = [
            'laptop' => 'Sparepart Laptop',
            'printer' => 'Sparepart Printer',
            'pc' => 'Sparepart PC / Desktop'
        ];

        $title = $categoryNames[$category] ?? 'Sparepart';
        return view('spareparts.index', compact('store', 'spareparts', 'title', 'category'));
    }

    public function show($slug)
    {
        $store = StoreProfile::first();
        $sparepart = Sparepart::where('slug', $slug)->firstOrFail();
        return view('spareparts.show', compact('store', 'sparepart'));
    }
}
