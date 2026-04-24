<?php

namespace App\Http\Controllers;

use App\Models\ShipmentOption;
use App\Models\StoreProfile;

class ShipmentController extends Controller
{
    public function index()
    {
        $store    = StoreProfile::first();
        $shipments = ShipmentOption::where('is_active', true)->orderBy('price')->get();
        return view('shipment', compact('store', 'shipments'));
    }
}
