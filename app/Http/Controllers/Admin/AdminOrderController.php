<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
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
            'notes' => 'nullable|string|max:1000',
        ]);

        // Update timestamps based on status
        if ($data['status'] === 'diterima' && !$order->confirmed_at) {
            $data['confirmed_at'] = now();
        }
        if (in_array($data['status'], ['confirmed', 'in_progress']) && !$order->confirmed_at) {
            $data['confirmed_at'] = $data['confirmed_at'] ?? now();
        }
        if ($data['status'] === 'completed' && !$order->completed_at) {
            $data['completed_at'] = now();
        }

        // Update service price if provided
        if (!empty($data['service_price'])) {
            $data['total_price'] = $data['service_price'] + $order->shipment_price;
        }

        $order->update(array_filter($data));

        // Send notification to customer
        $this->notifyCustomer($order);

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
            'notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => 'diterima',
            'confirmed_at' => now(),
        ];

        if (!empty($data['service_id'])) {
            $updateData['service_id'] = $data['service_id'];
        }
        if (!empty($data['service_price'])) {
            $updateData['service_price'] = $data['service_price'];
            $updateData['total_price'] = $data['service_price'] + $order->shipment_price;
        }
        if (!empty($data['notes'])) {
            $updateData['notes'] = $data['notes'];
        }

        $order->update(array_filter($updateData));

        // Notify customer
        $this->notifyCustomer($order);

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

        // Notify customer
        $this->notifyCustomer($order);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah ditolak! Pelanggan akan mendapat notifikasi.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function create() { return redirect()->route('admin.orders.index'); }
    public function store(Request $request) { return redirect()->route('admin.orders.index'); }
    public function edit(Order $order) { return view('admin.orders.show', compact('order')); }

    /**
     * Notify customer about order status changes
     */
    private function notifyCustomer(Order $order): void
    {
        $statusMessages = [
            'pending' => 'Pesanan Anda sedang menunggu konfirmasi.',
            'diterima' => 'Selamat! Pesanan Anda telah kami terima dan akan segera diproses.',
            'ditolak' => 'Mohon maaf, pesanan Anda tidak dapat kami proses.',
            'confirmed' => 'Pesanan Anda telah dikonfirmasi dan sedang dalam proses perbaikan.',
            'in_progress' => 'Perbaikan perangkat Anda sedang berlangsung.',
            'completed' => 'Perbaikan selesai! Anda dapat mengambil perangkat.',
            'cancelled' => 'Pesanan Anda telah dibatalkan.',
        ];

        $statusLabel = $order->status_badge['label'] ?? ucfirst($order->status);
        $message = $statusMessages[$order->status] ?? 'Status pesanan Anda telah diperbarui.';

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

    private function sendWhatsAppMessage(string $phone, string $message): void
    {
        try {
            $phone = preg_replace('/\D/', '', $phone);
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            } elseif (substr($phone, 0, 2) !== '62') {
                $phone = '62' . $phone;
            }

            $token = config('services.fonnte.token');
            
            if ($token) {
                \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => $token,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $phone,
                    'message' => $message,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
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
