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

    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(10);
    }

    public function handle(): void
    {$admins = Admin::active()->get();

Log::info('Admin data:', $admins->toArray());
        try {
            $order = Order::with('service')->find($this->orderId);
            if (!$order) {
                Log::warning('SendOrderNotificationsJob: order not found', [
                    'order_id' => $this->orderId,
                    'service_id' => $this->serviceId,
                ]);
                return;
            }

            $service = $order->service ?? Service::find($this->serviceId);
            if (!$service) {
                Log::warning('SendOrderNotificationsJob: service not found', [
                    'order_id' => $this->orderId,
                    'service_id' => $this->serviceId,
                ]);
                return;
            }

            // Job ini difokuskan untuk EMAIL agar tidak dobel WhatsApp.
            $admins = Admin::active()->get();
            $store = StoreProfile::first();

            foreach ($admins as $admin) {
                if ($admin->email) {
                    $this->sendEmailNotification($admin->email, $order, $service);
                }
            }

            // Optional: jika butuh email store juga, bisa ditambahkan.
            // Saat ini hanya admin.
            // if ($store?->email) { ... }
        } catch (\Throwable $e) {
            Log::error('SendOrderNotificationsJob failed', [
                'order_id' => $this->orderId,
                'service_id' => $this->serviceId,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
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
            Log::error('Email notification failed', [
                'email' => $email,
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

