<?php

namespace App\Traits;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait WhatsAppBot
{
    protected function waBotBaseUrl(): string
    {
        return rtrim((string) config('services.wa_bot.base_url', env('WA_BOT_BASE_URL')), '/');
    }

    protected function waBotApiKey(): string
    {
        return (string) config('services.wa_bot.api_key', env('WA_BOT_API_KEY'));
    }

    protected function waBotHttpClient(): PendingRequest
    {
        return Http::timeout(10)
            ->connectTimeout(5)
            ->withHeaders([
                'x-api-key' => $this->waBotApiKey(),
            ]);
    }

    /**
     * Normalize phone to international format (62xxx)
     * Accepts: 08xxx, 62xxx, +62xxx, etc
     */
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', (string) $phone);

        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }

        if (!str_starts_with($phone, '62')) {
            return '62' . $phone;
        }

        return $phone;
    }

    /**
     * Format phone to local format (08xxx) for display
     */
    protected function formatPhoneLocal(string $phone): string
    {
        $phone = preg_replace('/\D/', '', (string) $phone);

        // Remove country code if present
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        } elseif (str_starts_with($phone, '0')) {
            // Already in local format
            return $phone;
        } else {
            // Assume it's just the number without prefix
            $phone = '0' . $phone;
        }

        return $phone;
    }

    protected function sendWhatsAppMessage(string $phone, string $message): void
    {
        try {
            $baseUrl = $this->waBotBaseUrl();
            $apiKey = $this->waBotApiKey();
            $normalizedPhone = $this->normalizePhone($phone);
            $displayPhone = $this->formatPhoneLocal($phone);

            Log::info('Attempting to send WhatsApp message', [
                'phone_input' => $phone,
                'phone_display' => $displayPhone,
                'phone_normalized' => $normalizedPhone,
                'base_url' => $baseUrl,
                'api_key_set' => !empty($apiKey),
            ]);

            if (!$baseUrl || !$apiKey) {
                Log::warning('WA bot not configured', [
                    'base_url' => $baseUrl,
                    'api_key_set' => !empty($apiKey),
                ]);
                return;
            }

            $payload = [
                'to' => $normalizedPhone,
                'message' => $message,
            ];

            Log::debug('Sending WA bot request', [
                'url' => $baseUrl . '/send',
                'to' => $normalizedPhone,
                'message_length' => strlen($message),
            ]);

            $response = $this->waBotHttpClient()->post($baseUrl . '/send', $payload);

            Log::info('WA bot response received', [
                'status' => $response->status(),
                'success' => $response->successful(),
                'phone_display' => $displayPhone,
            ]);

            if ($response->failed()) {
                $body = (string) $response->body();
                Log::error('WhatsApp notification via WA bot failed', [
                    'http_status' => $response->status(),
                    'response_body' => $body,
                    'phone_display' => $displayPhone,
                    'phone_normalized' => $normalizedPhone,
                ]);

                // Fallback: bot kadang butuh format lokal (0xxx) alih-alih 62xxx
                // jika error mengindikasikan nomor tidak ada di WhatsApp.
                if (str_contains($body, 'Number is not on WhatsApp')) {
                    $localPhone = $this->formatPhoneLocal($phone);

                    Log::warning('WA bot fallback retry with local phone', [
                        'phone_input' => $phone,
                        'phone_local' => $localPhone,
                        'phone_normalized' => $normalizedPhone,
                    ]);

                    try {
                        $retryPayload = [
                            'to' => $this->normalizePhone($localPhone),
                            'message' => $message,
                        ];

                        $retryResponse = $this->waBotHttpClient()->post($baseUrl . '/send', $retryPayload);

                        Log::info('WA bot retry response received', [
                            'status' => $retryResponse->status(),
                            'success' => $retryResponse->successful(),
                            'phone_display' => $localPhone,
                        ]);

                        if ($retryResponse->failed()) {
                            Log::error('WhatsApp notification via WA bot retry failed', [
                                'http_status' => $retryResponse->status(),
                                'response_body' => (string) $retryResponse->body(),
                                'phone_display' => $localPhone,
                            ]);
                        }
                    } catch (\Throwable $e) {
                        Log::error('WA bot fallback retry exception', [
                            'phone_input' => $phone,
                            'error' => $e->getMessage(),
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                        ]);
                    }
                }

                return;
            }


            Log::info('WhatsApp message sent successfully', [
                'phone_display' => $displayPhone,
                'response' => $response->json(),
            ]);
        } catch (\Throwable $e) {
            Log::error('WhatsApp notification exception', [
                'phone_input' => $phone,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
