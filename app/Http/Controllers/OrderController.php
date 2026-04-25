<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ShipmentOption;
use App\Models\PaymentMethod;
use App\Models\Order;
use App\Models\StoreProfile;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $store           = StoreProfile::first();
        $service         = null;
        $services        = Service::where('is_active', true)->orderBy('category')->get();
        $shipmentOptions = ShipmentOption::where('is_active', true)->get();
        $paymentMethods  = PaymentMethod::where('is_active', true)->get();

        if ($request->has('service')) {
            $service = Service::where('slug', $request->service)->first();
        }

        return view('order', compact('store', 'service', 'services', 'shipmentOptions', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'        => 'required|string|max:255',
            'customer_email'       => 'required|email|max:255',
            'customer_phone'       => 'required|string|max:20',
            'customer_address'     => 'nullable|string|max:500',
            'service_id'           => 'required|exists:services,id',
            'shipment_option_id'   => 'nullable|exists:shipment_options,id',
            'payment_method_id'    => 'required|exists:payment_methods,id',
            'device_description'   => 'required|string|max:1000',
            'problem_description'  => 'required|string|max:2000',
            'notes'                => 'nullable|string|max:500',
        ]);

        $service        = Service::findOrFail($validated['service_id']);
        $shipmentPrice  = 0;
        if (!empty($validated['shipment_option_id'])) {
            $shipment       = ShipmentOption::findOrFail($validated['shipment_option_id']);
            $shipmentPrice  = $shipment->price;
        }

        $order = Order::create([
            'order_number'        => 'TFP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'customer_name'       => $validated['customer_name'],
            'customer_email'      => $validated['customer_email'],
            'customer_phone'      => $validated['customer_phone'],
            'customer_address'    => $validated['customer_address'] ?? null,
            'service_id'          => $validated['service_id'],
            'shipment_option_id'  => $validated['shipment_option_id'] ?? null,
            'payment_method_id'   => $validated['payment_method_id'],
            'device_description'  => $validated['device_description'],
            'problem_description' => $validated['problem_description'],
            'service_price'       => $service->price_start,
            'shipment_price'      => $shipmentPrice,
            'total_price'         => $service->price_start + $shipmentPrice,
            'notes'               => $validated['notes'] ?? null,
            'status'              => 'pending',
            'payment_status'      => 'unpaid',
        ]);

        return redirect()->route('order.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $store = StoreProfile::first();
        $order = Order::where('order_number', $orderNumber)->with(['service', 'shipmentOption', 'paymentMethod'])->firstOrFail();
        return view('order-success', compact('store', 'order'));
    }

    public function track(Request $request)
    {
        $store = StoreProfile::first();
        $order = null;
        if ($request->has('order_number')) {
            $order = Order::where('order_number', $request->order_number)->with(['service', 'shipmentOption', 'paymentMethod'])->first();
        }
        return view('order-track', compact('store', 'order'));
    }
}
