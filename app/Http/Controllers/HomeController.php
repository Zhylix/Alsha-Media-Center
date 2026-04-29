<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\StoreProfile;
use App\Models\Stat;
use App\Models\Promo;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $store        = StoreProfile::first();
        $featuredServices = Service::where('is_active', true)->where('is_featured', true)->take(6)->get();
        $laptopServices   = Service::where('category', 'laptop')->where('is_active', true)->take(3)->get();
        $printerServices  = Service::where('category', 'printer')->where('is_active', true)->take(3)->get();
        $pcServices       = Service::where('category', 'pc')->where('is_active', true)->take(3)->get();
        $testimonials     = Testimonial::where('is_active', true)->latest()->take(6)->get();
        $activePromos     = Promo::active()->latest()->take(3)->get();

        // Hero card data
        $heroLaptop   = Service::where('category', 'laptop')->where('is_active', true)->first();
        $heroPrinter  = Service::where('category', 'printer')->where('is_active', true)->first();
        $heroPc       = Service::where('category', 'pc')->where('is_active', true)->first();

        // Get stats from database
        $stats_items = Stat::where('is_active', true)->orderBy('sort_order')->get();

// Get stats from database - dynamic and conditional
        $stats_items = Stat::where('is_active', true)->orderBy('sort_order')->get();

        // Keep computed stats but make available via Stat model preference
        $stats = [
            'services'    => Service::where('is_active', true)->count(),
            'experience'  => $stats_items->where('label', 'like', '%pengalam%')->first()?->value ?? 12,
            'customers'   => $stats_items->where('label', 'like', '%pelangg%')->first()?->value ?? max(Order::count() + 500, 500),
        ];

        return view('home', compact('store', 'featuredServices', 'laptopServices', 'printerServices', 'pcServices', 'testimonials', 'stats_items', 'heroLaptop', 'heroPrinter', 'heroPc', 'activePromos'));

    }
}
