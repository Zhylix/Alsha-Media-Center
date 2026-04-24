<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['service', 'shipmentOption', 'paymentMethod']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['service', 'shipmentOption', 'paymentMethod']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status'         => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'notes'          => 'nullable|string|max:1000',
        ]);

        if ($data['status'] === 'confirmed' && !$order->confirmed_at) {
            $data['confirmed_at'] = now();
        }
        if ($data['status'] === 'completed' && !$order->completed_at) {
            $data['completed_at'] = now();
        }

        $order->update($data);
        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function create() { return redirect()->route('admin.orders.index'); }
    public function store(Request $request) { return redirect()->route('admin.orders.index'); }
    public function edit(Order $order) { return view('admin.orders.show', compact('order')); }
}
