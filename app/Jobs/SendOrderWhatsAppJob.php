<?php

namespace App\Jobs;

use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOrderWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly int $orderId,
        public readonly int $serviceId
    ) {}

    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(10);
    }

    public function handle(): void
    {
        try {
            $order = Order::with('service')->find($this->orderId);
            if (!$order) {
                Log::warning('SendOrderWhatsAppJob: order not found', [
                    'order_id' => $this->orderId,
                ]);
                return;
            }

            $service = $order->service ?? Service::find($this->serviceId);
            if (!$service) {
                Log::warning('SendOrderWhatsAppJob: service not found', [
                    'order_id' => $this->orderId,
                    'service_id' => $this->serviceId,
                ]);
                return;
            }

            // Pakai existing notifyAdmins() agar format WA tetap sama.
            $controller = app(OrderController::class);
            $controller->notifyAdmins($order, $service);
        } catch (\Throwable $e) {
            Log::error('SendOrderWhatsAppJob failed', [
                'order_id' => $this->orderId,
                'service_id' => $this->serviceId,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }
}

