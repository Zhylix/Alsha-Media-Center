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
        $hpServices       = Service::where('category', 'hp')->where('is_active', true)->take(3)->get();
        $testimonials     = Testimonial::where('is_active', true)->latest()->take(6)->get();

        // Hero card data - real from CRUD
        $heroLaptop   = Service::where('category', 'laptop')->where('is_active', true)->first();
        $heroPrinter  = Service::where('category', 'printer')->where('is_active', true)->first();
        $heroHp       = Service::where('category', 'hp')->where('is_active', true)->first();

        $stats = [
            'services'    => Service::where('is_active', true)->count(),
            'orders'      => \App\Models\Order::count(),
            'experience'  => 10,
            'customers'   => max(\App\Models\Order::count() + 500, 500),
        ];

        return view('home', compact('store', 'featuredServices', 'laptopServices', 'printerServices', 'hpServices', 'testimonials', 'stats',
            'heroLaptop', 'heroPrinter', 'heroHp'));

    }
}
