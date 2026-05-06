<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\StoreProfile;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $store = StoreProfile::first();
        $promos = Promo::active()->latest()->get();
        return view('packages.index', compact('store', 'promos'));
    }

    public function show($slug)
    {
        $store = StoreProfile::first();
        $promo = Promo::where('slug', $slug)->firstOrFail();
        return view('packages.show', compact('store', 'promo'));
    }
}
