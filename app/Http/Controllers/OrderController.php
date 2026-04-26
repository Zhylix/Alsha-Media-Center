<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Models\StoreProfile;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success($orderNumber)
    {
        $store = StoreProfile::first();
        $order = Order::where('order_number', $orderNumber)->with('service')->firstOrFail();
        return view('order-success', compact('store', 'order'));
    }

    public function track(Request $request)
    {
        $store = StoreProfile::first();
        $order = null;
        if ($request->has('order_number')) {
            $order = Order::where('order_number', $request->order_number)->with('service')->first();
        }
        return view('order-track', compact('store', 'order'));
    }
}
