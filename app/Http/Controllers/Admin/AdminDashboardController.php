<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\ContactMessage;
use App\Models\Testimonial;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'completed_orders'=> Order::where('status', 'completed')->count(),
            'total_services'  => Service::where('is_active', true)->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_revenue'   => Order::sum('total_price'),
        ];

        $recentOrders = Order::with(['service'])->latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentMessages'));
    }
}
