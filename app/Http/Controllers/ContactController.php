<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\StoreProfile;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $store = StoreProfile::first();
        return view('contact', compact('store'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:3000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Pesan Anda telah terkirim! Kami akan segera merespons.');
    }
}
