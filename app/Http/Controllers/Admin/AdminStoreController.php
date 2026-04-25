<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminStoreController extends Controller
{
    public function index()
    {
        $store = StoreProfile::first();
        return view('admin.store.index', compact('store'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'store_name'  => 'required|string|max:255',
            'tagline'     => 'nullable|string|max:500',
            'description' => 'required|string',
            'address'     => 'required|string|max:500',
            'city'        => 'required|string|max:100',
            'phone'       => 'required|string|max:20',
            'whatsapp'    => 'nullable|string|max:20',
            'email'       => 'required|email|max:255',
            'instagram'   => 'nullable|string|max:100',
            'facebook'    => 'nullable|string|max:100',
            'youtube'     => 'nullable|string|max:100',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'open_hours'  => 'required|string|max:50',
            'open_days'   => 'required|string|max:100',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $store = StoreProfile::first();
        
        if ($request->hasFile('logo')) {
            if ($store && $store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($store) {
            $store->update($data);
        } else {
            StoreProfile::create($data);
        }

        return redirect()->route('admin.store.index')->with('success', 'Profil toko berhasil diperbarui!');
    }

    public function deleteLogo()
    {
        $store = StoreProfile::first();
        if ($store && $store->logo) {
            Storage::disk('public')->delete($store->logo);
            $store->update(['logo' => null]);
            return redirect()->route('admin.store.index')->with('success', 'Logo berhasil dihapus!');
        }
        return redirect()->route('admin.store.index')->with('error', 'Tidak ada logo untuk dihapus.');
    }
}
