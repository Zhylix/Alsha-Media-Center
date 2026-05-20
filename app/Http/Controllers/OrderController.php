<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Models\StoreProfile;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        // Spareparts untuk dropdown di halaman order (berdasarkan relasi service-sparepart)
        $sparepartsByServiceId = $services->mapWithKeys(function ($service) {
            $spareparts = $service->spareparts()
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->with('sparepartCategory')
                ->orderBy('sort_order')
                ->get()
                ->map(function ($sp) {
                    return [
                        'id' => $sp->id,
                        'name' => $sp->name,
                        'price' => $sp->price,
                        'sparepart_category' => $sp->sparepartCategory,
                        'part_type' => $sp->sparepartCategory->part_type ?? null,
                    ];
                })
                ->values();

            return [$service->id => $spareparts];
        });

        return view('order', compact('services', 'servicesByCategory', 'store', 'sparepartsByServiceId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'service_id' => 'required|exists:services,id',
            'selected_sparepart_id' => 'nullable|integer|exists:spareparts,id',
            'device_description' => 'required|string|max:1000',
            'problem_description' => 'required|string|max:2000',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        // Hitung harga dasar (hanya harga jasa)
        $servicePrice = (float) ($service->price_jasa ?? $service->price_start ?? 0);
        $sparepartPrice = 0.0;

        // Sparepart opsional (harus termasuk sparepart yang sudah diset untuk service ini)
        $selectedSparepartId = $validated['selected_sparepart_id'] ?? null;
        if ($selectedSparepartId) {
            $sparepart = $service->spareparts()
                ->where('spareparts.is_active', true)
                ->where('spareparts.stock', '>', 0)
                ->where('spareparts.id', $selectedSparepartId)
                ->first();

            if ($sparepart) {
                $sparepartPrice = (float) ($sparepart->price ?? 0);
            }
        }

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
            'service_price' => $servicePrice,
            'sparepart_price' => $sparepartPrice,
            'shipment_price' => 0,
            'total_price' => $servicePrice + $sparepartPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

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
     * Notify admin about new order via WhatsApp.
     * (Email notifications intentionally disabled)
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

        // Email disabled intentionally.
        if ($primaryAdmin && $primaryAdmin->email) {
            Log::info('notifyAdmins: email disabled', ['admin_email' => $primaryAdmin->email]);
        }
    }

    /**
     * Notify customer about order status changes.
     * Email notifications disabled.
     */
    private function notifyCustomer(Order $order, ?string $forcedStatus = null, bool $hasPricingInput = false): void
    {
        $status = $forcedStatus ?? $order->status;

        $statusMessages = [
            'pending' => 'Pesanan Anda sedang menunggu konfirmasi.',
            'diterima' => 'Selamat! Pesanan Anda telah kami terima dan akan segera diproses.',
            'ditolak' => 'Mohon maaf, pesanan Anda tidak dapat kami proses.',
            'confirmed' => 'Pesanan Anda telah dikonfirmasi dan sedang dalam proses perbaikan.',
            'in_progress' => 'Perbaikan perangkat Anda sedang berlangsung.',
            'completed' => 'Perbaikan selesai! Anda dapat mengambil perangkat.',
            'cancelled' => 'Pesanan Anda telah dibatalkan.',
        ];

        $statusLabel = $order->status_badge['label'] ?? ucfirst($status);
        $message = $statusMessages[$status] ?? 'Status pesanan Anda telah diperbarui.';

        $whatsappMessage = "🔧 *Status Pesanan AMC - {$order->order_number}*\n\n";
        $whatsappMessage .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $whatsappMessage .= "Halo *{$order->customer_name}*!\n\n";
        $whatsappMessage .= "📋 *Status:* {$statusLabel}\n";
        $whatsappMessage .= "📝 *Info:* {$message}\n";
        if ($order->notes) {
            $whatsappMessage .= "\n📌 *Catatan:* {$order->notes}\n";
        }
        $whatsappMessage .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $whatsappMessage .= "Terima kasih telah mempercayakan layanan kami!\n\n";
        $whatsappMessage .= "_Cek status pesanan di: https://alshamedia.my.id/pesanan/tracking_";

        // Send WhatsApp notification
        if ($order->customer_phone) {
            $this->sendWhatsAppMessage($order->customer_phone, $whatsappMessage);
        }

        // Email disabled intentionally.
    }
}

