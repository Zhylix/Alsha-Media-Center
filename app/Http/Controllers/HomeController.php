<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\StoreProfile;

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

        // Hero card data - real from CRUD
        $heroLaptop   = Service::where('category', 'laptop')->where('is_active', true)->first();
        $heroPrinter  = Service::where('category', 'printer')->where('is_active', true)->first();
        $heroPc       = Service::where('category', 'pc')->where('is_active', true)->first();

        $stats = [
            'services'    => Service::where('is_active', true)->count(),
            'orders'      => \App\Models\Order::count(),
            'experience'  => 10,
            'customers'   => max(\App\Models\Order::count() + 500, 500),
        ];

        return view('home', compact('store', 'featuredServices', 'laptopServices', 'printerServices', 'pcServices', 'testimonials', 'stats',
            'heroLaptop', 'heroPrinter', 'heroPc'));

    }
}
