<?php

namespace App\Http\Controllers;

use App\Models\StoreProfile;

class AboutController extends Controller
{
    public function index()
    {
        $store = StoreProfile::first();
        return view('about', compact('store'));
    }
}
