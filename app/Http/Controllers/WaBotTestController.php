<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\WhatsAppBot;

class WaBotTestController extends Controller
{
    use WhatsAppBot;

    /**
     * Test WhatsApp bot connectivity
     */
    public function healthCheck()
    {
        try {
            $baseUrl = $this->waBotBaseUrl();
            $apiKey = $this->waBotApiKey();

            $response = \Illuminate\Support\Facades\Http::timeout(5)->connectTimeout(3)->get($baseUrl . '/health');

            return response()->json([
                'success' => $response->successful(),
                'status' => $response->status(),
                'base_url' => $baseUrl,
                'api_key_length' => strlen($apiKey),
                'response' => $response->json(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'base_url' => $this->waBotBaseUrl(),
            ], 500);
        }
    }

    /**
     * Send test message
     */
    public function sendTest(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        $this->sendWhatsAppMessage($validated['phone'], $validated['message']);

        return response()->json([
            'success' => true,
            'message' => 'Test message sent',
            'phone_input' => $validated['phone'],
            'phone_normalized' => $this->normalizePhone($validated['phone']),
            'phone_formatted' => $this->formatPhoneLocal($validated['phone']),
        ]);
    }

    /**
     * View test form
     */
    public function form()
    {
        return <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <title>WA Bot Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .card { background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .info-box { background: #e3f2fd; padding: 15px; border-left: 4px solid #2196F3; margin-bottom: 20px; border-radius: 4px; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #dc2626; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background: #b91c1c; }
        .success { color: #10b981; font-weight: bold; }
        .error { color: #ef4444; font-weight: bold; }
        .info { color: #3b82f6; }
        small { color: #666; display: block; margin-top: 5px; }
        pre { background: #f3f4f6; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🤖 WA Bot Test & Debug</h1>
    
    <div class="info-box">
        <strong>📝 Format Nomor yang Diterima:</strong>
        <ul>
            <li>✓ 08xxxxxxxxxx (lokal format)</li>
            <li>✓ 62xxxxxxxxxx (internasional format)</li>
            <li>✓ +62xxxxxxxxxx (dengan prefix +)</li>
        </ul>
        <small>Sistem otomatis normalize ke format 62 untuk API WhatsApp</small>
    </div>

    <div class="card">
        <h3>Health Check</h3>
        <p>Cek koneksi ke WA Bot server</p>
        <button onclick="testHealth()">Check Bot Status</button>
        <pre id="healthResult"></pre>
    </div>

    <div class="card">
        <h3>Send Test Message</h3>
        <div>
            <label>Nomor WhatsApp (gunakan 08 atau 62):</label>
            <input type="text" id="phone" placeholder="Contoh: 08xxxxxxxxxx atau 62xxxxxxxxxx" value="6281234567890">
            <small>Masukkan nomor aktif untuk testing</small>
        </div>
        <div>
            <label>Pesan:</label>
            <textarea id="message" placeholder="Ketik pesan test..." rows="4">Test message dari admin panel - sistem WA Bot Baileys</textarea>
        </div>
        <button onclick="sendMessage()">Kirim Pesan Test</button>
        <pre id="sendResult"></pre>
    </div>

    <script>
        function testHealth() {
            document.getElementById('healthResult').textContent = 'Loading...';
            fetch('/test-wa-bot/health')
                .then(r => r.json())
                .then(d => {
                    document.getElementById('healthResult').textContent = JSON.stringify(d, null, 2);
                    document.getElementById('healthResult').className = d.success ? 'success' : 'error';
                })
                .catch(e => {
                    document.getElementById('healthResult').textContent = 'Error: ' + e.message;
                    document.getElementById('healthResult').className = 'error';
                });
        }

        function sendMessage() {
            const phone = document.getElementById('phone').value;
            const message = document.getElementById('message').value;
            
            if (!phone || !message) {
                alert('Isi nomor dan pesan terlebih dahulu!');
                return;
            }

            document.getElementById('sendResult').textContent = 'Sending...';
            
            fetch('/test-wa-bot/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ phone, message })
            })
            .then(r => r.json())
            .then(d => {
                document.getElementById('sendResult').textContent = JSON.stringify(d, null, 2);
                document.getElementById('sendResult').className = d.success ? 'success' : 'error';
            })
            .catch(e => {
                document.getElementById('sendResult').textContent = 'Error: ' + e.message;
                document.getElementById('sendResult').className = 'error';
            });
        }

        // Auto test health on load
        window.addEventListener('load', () => {
            console.log('WA Bot Test page loaded');
        });
    </script>
</body>
</html>
HTML;
    }
}
