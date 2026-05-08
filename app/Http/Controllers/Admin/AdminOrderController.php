<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Traits\WhatsAppBot;

class AdminOrderController extends Controller
{
    use WhatsAppBot;

    public function index(Request $request)
    {
        $query = Order::with('service');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
        $order->load('service');
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('admin.orders.show', compact('order', 'services'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,diterima,ditolak,confirmed,in_progress,completed,cancelled',

            'service_id' => 'nullable|exists:services,id',
            'service_price' => 'nullable|numeric|min:0',
            'service_discount_percent' => 'nullable|numeric|min:0|max:100',
            'shipment_price' => 'nullable|numeric|min:0',
            'shipment_discount_percent' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Jika admin hanya update status (tanpa input harga/diskon), jangan ubah service_price/shipment_price.
        $hasPricingInput = array_key_exists('service_price', $data) || array_key_exists('shipment_price', $data)
            || array_key_exists('service_discount_percent', $data) || array_key_exists('shipment_discount_percent', $data);

        if ($hasPricingInput) {
            // Hitung ulang total dengan diskon jika ada
            $servicePrice = isset($data['service_price']) && $data['service_price'] !== '' ? (float) $data['service_price'] : (float) $order->service_price;
            $serviceDiscountPercent = isset($data['service_discount_percent']) && $data['service_discount_percent'] !== '' ? (float) $data['service_discount_percent'] : 0;
            $serviceDiscountPercent = min(100, max(0, $serviceDiscountPercent));
            $serviceAfter = $servicePrice - ($servicePrice * $serviceDiscountPercent / 100);

            $shipmentPrice = isset($data['shipment_price']) && $data['shipment_price'] !== '' ? (float) $data['shipment_price'] : (float) $order->shipment_price;
            $shipmentDiscountPercent = isset($data['shipment_discount_percent']) && $data['shipment_discount_percent'] !== '' ? (float) $data['shipment_discount_percent'] : 0;
            $shipmentDiscountPercent = min(100, max(0, $shipmentDiscountPercent));
            $shipmentAfter = $shipmentPrice - ($shipmentPrice * $shipmentDiscountPercent / 100);

            $data['service_price'] = $serviceAfter;
            $data['shipment_price'] = $shipmentAfter;
            $data['total_price'] = $serviceAfter + $shipmentAfter;
        }



        // Update timestamps based on status
        $previousStatus = $order->status;
        if ($data['status'] === 'diterima' && !$order->confirmed_at) {
            $data['confirmed_at'] = now();
        }
        if (in_array($data['status'], ['confirmed', 'in_progress']) && !$order->confirmed_at) {
            $data['confirmed_at'] = $data['confirmed_at'] ?? now();
        }
        if ($data['status'] === 'completed' && !$order->completed_at) {
            $data['completed_at'] = now();
        }


        // Hitung ulang total dengan diskon jika ada
        $servicePrice = isset($data['service_price']) && $data['service_price'] !== '' ? (float) $data['service_price'] : (float) $order->service_price;
        $serviceDiscountPercent = isset($data['service_discount_percent']) && $data['service_discount_percent'] !== '' ? (float) $data['service_discount_percent'] : 0;
        $serviceDiscountPercent = min(100, max(0, $serviceDiscountPercent));
        $serviceAfter = $servicePrice - ($servicePrice * $serviceDiscountPercent / 100);

        $shipmentPrice = isset($data['shipment_price']) && $data['shipment_price'] !== '' ? (float) $data['shipment_price'] : (float) $order->shipment_price;
        $shipmentDiscountPercent = isset($data['shipment_discount_percent']) && $data['shipment_discount_percent'] !== '' ? (float) $data['shipment_discount_percent'] : 0;
        $shipmentDiscountPercent = min(100, max(0, $shipmentDiscountPercent));
        $shipmentAfter = $shipmentPrice - ($shipmentPrice * $shipmentDiscountPercent / 100);

        $data['service_price'] = $serviceAfter;
        $data['shipment_price'] = $shipmentAfter;
        $data['total_price'] = $serviceAfter + $shipmentAfter;

        $order->update(array_filter($data));

        // Send notification to customer only when status actually changes
        if (array_key_exists('status', $data) && ($data['status'] ?? null) !== null && ($data['status'] ?? null) !== $previousStatus) {
            $this->notifyCustomer($order, $data['status'] ?? null, $hasPricingInput ? true : false);
        }



        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Accept (Terima) an order
     */
    public function accept(Request $request, Order $order)
    {
        $data = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'service_price' => 'nullable|numeric|min:0',
            'service_discount_percent' => 'nullable|numeric|min:0|max:100',
            'shipment_price' => 'nullable|numeric|min:0',
            'shipment_discount_percent' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Store previous status untuk check apakah benar-benar berubah
        $previousStatus = $order->status;

        $updateData = [
            'status' => 'diterima',
            'confirmed_at' => now(),
        ];

        if (!empty($data['service_id'])) {
            $updateData['service_id'] = $data['service_id'];
        }

        // Hitung ulang harga jika admin mengubah service_price dan/atau diskonnya
        $hasServicePricingInput = array_key_exists('service_price', $data)
            || array_key_exists('service_discount_percent', $data);

        if ($hasServicePricingInput) {
            $servicePrice = isset($data['service_price']) && $data['service_price'] !== '' ? (float) $data['service_price'] : (float) $order->service_price;
            $serviceDiscountPercent = isset($data['service_discount_percent']) && $data['service_discount_percent'] !== '' ? (float) $data['service_discount_percent'] : 0;
            $serviceDiscountPercent = min(100, max(0, $serviceDiscountPercent));

            $serviceAfter = $servicePrice - ($servicePrice * $serviceDiscountPercent / 100);

            $updateData['service_price'] = $serviceAfter;
        }

        $hasShipmentPricingInput = array_key_exists('shipment_price', $data)
            || array_key_exists('shipment_discount_percent', $data);

        if ($hasShipmentPricingInput) {
            $shipmentPrice = isset($data['shipment_price']) && $data['shipment_price'] !== '' ? (float) $data['shipment_price'] : (float) $order->shipment_price;
            $shipmentDiscountPercent = isset($data['shipment_discount_percent']) && $data['shipment_discount_percent'] !== '' ? (float) $data['shipment_discount_percent'] : 0;
            $shipmentDiscountPercent = min(100, max(0, $shipmentDiscountPercent));

            $shipmentAfter = $shipmentPrice - ($shipmentPrice * $shipmentDiscountPercent / 100);

            $updateData['shipment_price'] = $shipmentAfter;
        }

        // Selalu update total_price mengikuti service_price/shipment_price terbaru
        $newServicePrice = array_key_exists('service_price', $updateData) ? (float) $updateData['service_price'] : (float) $order->service_price;
        $newShipmentPrice = array_key_exists('shipment_price', $updateData) ? (float) $updateData['shipment_price'] : (float) $order->shipment_price;
        $updateData['total_price'] = $newServicePrice + $newShipmentPrice;

        // simpan diskon persen (opsional) ke order jika kolomnya ada di database
        if (array_key_exists('service_discount_percent', $data)) {
            $updateData['service_discount_percent'] = $data['service_discount_percent'];
        }
        if (array_key_exists('shipment_discount_percent', $data)) {
            $updateData['shipment_discount_percent'] = $data['shipment_discount_percent'];
        }

        if (!empty($data['notes'])) {
            $updateData['notes'] = $data['notes'];
        }

        $order->update(array_filter($updateData));

        // Notify customer only when status actually changes
        if ($previousStatus !== 'diterima') {
            $this->notifyCustomer($order, 'diterima', true);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah diterima! Pelanggan akan mendapat notifikasi.');
    }

    /**
     * Reject (Tolak) an order
     */
    public function reject(Request $request, Order $order)
    {
        $data = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status' => 'ditolak',
            'notes' => $data['notes'] ?? 'Maaf, pesanan Anda tidak dapat kami proses pada saat ini.',
        ]);

        // Notify customer (guard supaya tidak dobel)
        $this->notifyCustomer($order, 'ditolak', false);


        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah ditolak! Pelanggan akan mendapat notifikasi.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.orders.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'service_id' => 'required|exists:services,id',
            'service_price' => 'required|numeric|min:0',
            'service_discount_percent' => 'nullable|numeric|min:0|max:100',
            'shipment_price' => 'nullable|numeric|min:0',
            'shipment_discount_percent' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $servicePrice = (float) $data['service_price'];
        $serviceDiscountPercent = isset($data['service_discount_percent']) && $data['service_discount_percent'] !== '' ? (float) $data['service_discount_percent'] : 0;
        $serviceDiscountPercent = min(100, max(0, $serviceDiscountPercent));
        $serviceAfter = $servicePrice - ($servicePrice * $serviceDiscountPercent / 100);

        $shipmentPrice = isset($data['shipment_price']) && $data['shipment_price'] !== '' ? (float) $data['shipment_price'] : 0;
        $shipmentDiscountPercent = isset($data['shipment_discount_percent']) && $data['shipment_discount_percent'] !== '' ? (float) $data['shipment_discount_percent'] : 0;
        $shipmentDiscountPercent = min(100, max(0, $shipmentDiscountPercent));
        $shipmentAfter = $shipmentPrice - ($shipmentPrice * $shipmentDiscountPercent / 100);

        $data['order_number'] = 'AMC-' . date('Ymd') . '-' . strtoupper(uniqid());
        $data['status'] = 'pending';

        // simpan harga setelah diskon sebagai service_price/shipment_price agar total konsisten
        $data['service_price'] = $serviceAfter;
        $data['shipment_price'] = $shipmentAfter;
        $data['total_price'] = $serviceAfter + $shipmentAfter;

        $order = Order::create($data);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Pesanan baru berhasil dibuat!');
    }

    public function edit(Order $order)
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('admin.orders.show', compact('order', 'services'));
    }

    /**
     * Notify customer about order status changes
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

        // Send Email notification
        if ($order->customer_email) {
            $this->sendEmailNotification($order);
        }
    }

    private function sendEmailNotification(Order $order): void
    {

        try {
            $statusLabel = $order->status_badge['label'] ?? ucfirst($order->status);
            $notes = $order->notes ? "<p><strong>Catatan:</strong><br>{$order->notes}</p>" : '';
            
            $html = '<html><body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">';
            $html .= '<div style="background: #C8000A; padding: 20px; text-align: center;">';
            $html .= '<h1 style="color: white; margin: 0;">Alsha Media Center</h1>';
            $html .= '</div><div style="padding: 30px; background: #f9f9f9;">';
            $html .= '<h2>Status Pesanan: ' . $order->order_number . '</h2>';
            $html .= '<p>Halo <strong>' . $order->customer_name . '</strong>,</p>';
            $html .= '<p>Status pesanan Anda saat ini: <strong>' . $statusLabel . '</strong></p>';
            $html .= '<div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0;">';
            $html .= '<p><strong>Nomor Pesanan:</strong> ' . $order->order_number . '</p>';
            $html .= '<p><strong>Layanan:</strong> ' . ($order->service->name ?? '-') . '</p>';
            $html .= '<p><strong>Total Harga:</strong> Rp ' . number_format($order->total_price, 0, ',', '.') . '</p>';
            $html .= '</div>' . $notes;
            $html .= '<p style="margin-top: 30px;">';
            $html .= '<a href="https://alshamedia.my.id/pesanan/tracking" style="background: #C8000A; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">Lacak Pesanan</a>';
            $html .= '</p></div></body></html>';
            
            \Mail::send([], [], function ($message) use ($order, $statusLabel, $html) {
                $message->to($order->customer_email)
                    ->subject("Status Pesanan AMC {$order->order_number} - {$statusLabel}")
                    ->html($html);
            });
        } catch (\Exception $e) {
            \Log::error('Email notification failed: ' . $e->getMessage());
        }
    }
}
