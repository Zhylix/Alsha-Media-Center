<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\StoreProfile;

class ServiceController extends Controller
{
public function index()
    {
        $store            = StoreProfile::first();
        $laptopServices  = Service::where('category', 'laptop')->where('is_active', true)->orderBy('sort_order')->get();
        $printerServices = Service::where('category', 'printer')->where('is_active', true)->orderBy('sort_order')->get();
        $pcServices      = Service::where('category', 'pc')->where('is_active', true)->orderBy('sort_order')->get();
        $softwareServices = Service::where('category', 'software')->where('is_active', true)->orderBy('sort_order')->get();
        return view('services.index', compact('store', 'laptopServices', 'printerServices', 'pcServices', 'softwareServices'));
    }

    public function laptop()
    {
        $store    = StoreProfile::first();
        $services = Service::where('category', 'laptop')->where('is_active', true)->orderBy('sort_order')->get();
        return view('services.laptop', compact('store', 'services'));
    }

    public function printer()
    {
        $store    = StoreProfile::first();
        $services = Service::where('category', 'printer')->where('is_active', true)->orderBy('sort_order')->get();
        return view('services.printer', compact('store', 'services'));
    }

    public function pc()
    {
        $store    = StoreProfile::first();
        $services = Service::where('category', 'pc')->where('is_active', true)->orderBy('sort_order')->get();
        return view('services.pc', compact('store', 'services'));
    }

    public function software()
    {
        $store    = StoreProfile::first();
        $services = Service::where('category', 'software')->where('is_active', true)->orderBy('sort_order')->get();
        return view('services.software', compact('store', 'services'));
    }

    public function show($slug)
    {
        $store   = StoreProfile::first();
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related = Service::where('category', $service->category)->where('id', '!=', $service->id)->where('is_active', true)->take(3)->get();

        // Sparepart for this service (dipilih oleh admin)
        $spareparts = $service->spareparts()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('sparepartCategory')
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return view('services.show', compact('store', 'service', 'related', 'spareparts'));
    }

}
