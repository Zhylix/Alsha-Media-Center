<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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
    {
        // Dinonaktifkan: pengiriman notifikasi email untuk order.
        // Job ini sengaja menjadi no-op agar queue tetap aman.
        Log::info('SendOrderNotificationsJob: email notifications disabled', [
            'order_id' => $this->orderId,
            'service_id' => $this->serviceId,
        ]);
    }
}

