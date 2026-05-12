<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\StoreProfile;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $store = StoreProfile::first();
        $pakets = Paket::active()->latest()->get();
        return view('packages.index', compact('store', 'pakets'));
    }

    public function show($slug)
    {
        $store = StoreProfile::first();
        $paket = Paket::where('slug', $slug)->firstOrFail();
        return view('packages.show', compact('store', 'paket'));
    }
}
