<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Models\StoreProfile;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendOrderNotificationsJob;
use App\Jobs\SendOrderWhatsAppJob;
use App\Traits\WhatsAppBot;



class OrderController extends Controller
{
    use WhatsAppBot;

    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $store = StoreProfile::first();

        // Group services by category
        $servicesByCategory = $services->groupBy('category');

        return view('order', compact('services', 'servicesByCategory', 'store'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'service_id' => 'required|exists:services,id',
            'device_description' => 'required|string|max:1000',
            'problem_description' => 'required|string|max:2000',
        ]);
        $service = Service::findOrFail($validated['service_id']);

        // Create order with generated order number
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'] ?? null,
            'service_id' => $validated['service_id'],
            'device_description' => $validated['device_description'],
            'problem_description' => $validated['problem_description'],
            'service_price' => $service->price_start,
            'sparepart_price' => 0,
            'shipment_price' => 0,
            'total_price' => $service->price_start,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // Email tetap async via queue.
        SendOrderNotificationsJob::dispatch($order->id, $service->id);

        // Kirim WhatsApp admin via queue supaya tidak menghambat request user.
        SendOrderWhatsAppJob::dispatch($order->id, (int) $service->id);





        return redirect()->route('order.success', ['orderNumber' => $order->order_number])
            ->with('success', 'Pesanan Anda telah berhasil dibuat!');
    }

    public function success($orderNumber)
    {
        $store = StoreProfile::first();
        $order = Order::where('order_number', $orderNumber)->with('service')->firstOrFail();

        return view('order-success', compact('store', 'order'));
    }

    public function tracking(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $orderNumber = strtoupper(trim($request->input('order_number')));
        $order = Order::where('order_number', $orderNumber)->with('service')->first();

        if (!$order) {
            return redirect()->route('order.tracking')
                ->with('error', 'Nomor pesanan tidak ditemukan. Periksa kembali nomor yang Anda masukkan.');
        }

        return view('order-track', compact('order'));
    }

    public function trackingIndex()
    {
        $store = StoreProfile::first();
        return view('order-track', compact('store'));
    }

    /**
     * Notify admin about new order via WhatsApp and Email
     * Notifies the designated primary admin (first active superadmin or first active admin)
     */
    public function notifyAdmins(Order $order, Service $service): void
    {
        $primaryAdmin = Admin::getPrimaryAdmin();
        $store = StoreProfile::first();

        $message = "🔔 *Pesanan BaruAMC!*\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━\n";
        $message .= "📋 *Nomor Pesanan:* {$order->order_number}\n";
        $message .= "👤 *Pelanggan:* {$order->customer_name}\n";
        $message .= "📞 *Telepon:* {$order->customer_phone}\n";
        $message .= "📧 *Email:* {$order->customer_email}\n";
        $message .= "🛠️ *Layanan:* {$service->name}\n";
        $message .= "💻 *Device:* {$order->device_description}\n";
        $message .= "⚠️ *Masalah:* {$order->problem_description}\n";
        $message .= "💰 *Estimasi Harga:* Rp " . number_format($order->total_price, 0, ',', '.') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━\n";
        $message .= "📅 *Tanggal:* " . $order->created_at->format('d/m/Y H:i') . "\n\n";
        $message .= "_Silakan login ke admin untuk mengonfirmasi pesanan._";

        $admins = Admin::active()->get(['id', 'name', 'whatsapp', 'email']);
        foreach ($admins as $admin) {
            if ($admin->whatsapp) {
                $this->sendWhatsAppMessage($admin->whatsapp, $message);
            }
        }

        if ($store && $store->whatsapp) {
            $this->sendWhatsAppMessage($store->whatsapp, $message);
        }

        if ($primaryAdmin && $primaryAdmin->email) {
            $this->sendEmailNotification($primaryAdmin->email, $order, $service);
        }
    }

    /**
     * Send email notification to admin
     */
    private function sendEmailNotification(string $email, Order $order, Service $service): void
    {
        try {
            Mail::raw(
                "Pesanan BaruAMC!\n\n" .
                "Nomor Pesanan: {$order->order_number}\n" .
                "Pelanggan: {$order->customer_name}\n" .
                "Telepon: {$order->customer_phone}\n" .
                "Email: {$order->customer_email}\n" .
                "Layanan: {$service->name}\n" .
                "Device: {$order->device_description}\n" .
                "Masalah: {$order->problem_description}\n" .
                "Estimasi Harga: Rp " . number_format($order->total_price, 0, ',', '.') . "\n" .
                "Tanggal: {$order->created_at}\n",
                function ($message) use ($email, $order) {
                    $message->to($email)
                        ->subject("Pesanan BaruAMC: {$order->order_number}");
                }
            );
        } catch (\Exception $e) {
            Log::error('Email notification failed: ' . $e->getMessage());
        }
    }
}

