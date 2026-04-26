<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Models\StoreProfile;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $store    = StoreProfile::first();
        $service  = null;
        $services = Service::where('is_active', true)->orderBy('category')->get();

        if ($request->has('service')) {
            $service = Service::where('slug', $request->service)->first();
        }

        return view('order', compact('store', 'service', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'        => 'required|string|max:255',
            'customer_email'       => 'required|email|max:255',
            'customer_phone'       => 'required|string|max:20',
            'customer_address'     => 'nullable|string|max:500',
            'service_id'           => 'required|exists:services,id',
            'device_description'   => 'required|string|max:1000',
            'problem_description'  => 'required|string|max:2000',
            'notes'                => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $order = Order::create([
            'order_number'        => 'TFP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'customer_name'       => $validated['customer_name'],
            'customer_email'      => $validated['customer_email'],
            'customer_phone'      => $validated['customer_phone'],
            'customer_address'    => $validated['customer_address'] ?? null,
            'service_id'          => $validated['service_id'],
            'device_description'  => $validated['device_description'],
            'problem_description' => $validated['problem_description'],
            'service_price'       => $service->price_start,
            'total_price'         => $service->price_start,
            'notes'               => $validated['notes'] ?? null,
            'status'              => 'pending',
            'payment_status'      => 'unpaid',
        ]);

        return redirect()->route('order.success', $order->order_number);
    }

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
