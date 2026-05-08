<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Service;
use App\Models\StoreProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\WhatsAppBot;

class SendOrderNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WhatsAppBot;

    public function __construct(
        public readonly int $orderId,
        public readonly int $serviceId
    ) {}

    public function handle(): void
    {
        $order = Order::with('service')->findOrFail($this->orderId);
        $service = Service::findOrFail($this->serviceId);

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

        if ($primaryAdmin?->whatsapp) {
            $this->sendWhatsAppMessage($primaryAdmin->whatsapp, $message);
        }

        if ($store?->whatsapp) {
            $this->sendWhatsAppMessage($store->whatsapp, $message);
        }

        if ($primaryAdmin?->email) {
            $this->sendEmailNotification($primaryAdmin->email, $order, $service);
        }
    }

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
        } catch (\Throwable $e) {
            Log::error('Email notification failed: ' . $e->getMessage());
        }
    }
}

