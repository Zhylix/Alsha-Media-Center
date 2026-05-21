<?php

namespace App\Jobs;

use App\Models\Order;
use App\Traits\WhatsAppBot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCustomerNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WhatsAppBot;

    public function __construct(
        public readonly int|Order $order,
        public readonly ?string $forcedStatus = null,
        public readonly bool $hasPricingInput = false,
    ) {
    }

    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(10);
    }

    public function handle(): void
    {
        try {
            $order = $this->order instanceof Order
                ? $this->order
                : Order::with('service')->find($this->order);

            if (!$order) {
                Log::warning('SendCustomerNotificationJob: order not found', [
                    'order_id' => $this->order instanceof Order ? $this->order->id : $this->order,
                ]);
                return;
            }

            $status = $this->forcedStatus ?? $order->status;

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

            $whatsappMessage = " *Status Pesanan AMC - {$order->order_number}*\n\n";
            $whatsappMessage .= str_repeat('─', 15) . "\n";
            $whatsappMessage .= "Halo *{$order->customer_name}*!\n\n";
            $whatsappMessage .= " *Status:* {$statusLabel}\n";
            $whatsappMessage .= "	 *Info:* {$message}\n";

            if (!empty($order->notes)) {
                $whatsappMessage .= "\n
 *Catatan:* {$order->notes}\n";
            }

            $whatsappMessage .= "\n" . str_repeat('─', 15) . "\n";
            $whatsappMessage .= "Terima kasih telah mempercayakan layanan kami!\n\n";
            $whatsappMessage .= "_Cek status pesanan di: https://alshamedia.my.id/pesanan/tracking_";

            if (!empty($order->customer_phone)) {
                $this->sendWhatsAppMessage($order->customer_phone, $whatsappMessage);
            }
        } catch (\Throwable $e) {
            Log::error('SendCustomerNotificationJob failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }
}

