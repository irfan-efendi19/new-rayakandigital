<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\WhatsappGatewaySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppDiagnosticController extends Controller
{
    public function check(Request $request)
    {
        $gateway = WhatsappGatewaySetting::active()->first();
        $token = $gateway?->api_token;

        $lines = [];

        $lines[] = '=== GATEWAY CONFIGURATION ===';

        if (!$gateway) {
            $lines[] = '❌ No active WhatsApp gateway found.';
            $lines[] = 'Go to admin → WhatsApp Gateway Settings → create one.';
            return $this->render($lines);
        }

        $lines[] = "✅ Provider: {$gateway->provider_name}";
        $lines[] = "✅ API URL:  {$gateway->api_url}";
        $lines[] = '✅ API Token: ' . (strlen($token) > 6
            ? substr($token, 0, 4) . '****' . substr($token, -4)
            : '(too short)');

        $lines[] = '';
        $lines[] = '=== SAMPLE GUEST PHONE NUMBERS ===';

        $samples = Guest::whereNotNull('whatsapp_number')
            ->limit(10)
            ->pluck('whatsapp_number')
            ->toArray();

        if (empty($samples)) {
            $samples = Guest::whereNotNull('phone')
                ->limit(10)
                ->pluck('phone')
                ->toArray();
        }

        if (empty($samples)) {
            $lines[] = '(no guests with phone numbers found)';
        } else {
            foreach ($samples as $phone) {
                $clean = preg_replace('/[^0-9]/', '', $phone);
                $lines[] = "  Raw: \"{$phone}\"  →  Clean: \"{$clean}\"";
            }
        }

        $lines[] = '';
        $lines[] = '=== FONNTE API TEST ===';

        if ($gateway->provider_name !== 'fonnte') {
            $lines[] = "⏭ Skipping — not Fonnte.";
            return $this->render($lines);
        }

        $url = rtrim($gateway->api_url ?: 'https://api.fonnte.com/send', '/');
        if (!str_contains($url, '/send')) {
            $url .= '/send';
        }

        // If a test number was submitted via POST, use it
        $testTarget = $request->input('test_target', '0');
        $testMessage = $request->input('test_message', 'Test dari Rayakan Digital');

        $lines[] = "POST {$url}";
        $lines[] = "target: {$testTarget}";
        $lines[] = "message: {$testMessage}";
        $lines[] = "countryCode: 62";
        $lines[] = '';

        try {
            $response = Http::timeout(15)->withHeaders([
                'Authorization' => $token,
            ])->asForm()->post($url, [
                'target' => $testTarget,
                'message' => $testMessage,
                'countryCode' => '62',
            ]);

            $lines[] = "HTTP Status: {$response->status()}";
            $lines[] = "Full Response: {$response->body()}";

            $json = $response->json();
            if ($json) {
                if (isset($json['status']) && $json['status'] === true) {
                    $lines[] = '✅✅✅ MESSAGE SENT SUCCESSFULLY! ✅✅✅';
                } elseif (isset($json['reason'])) {
                    $lines[] = "❌ Fonnte reason: {$json['reason']}";
                }
            }
        } catch (\Throwable $e) {
            $lines[] = "❌ Exception: {$e->getMessage()}";
        }

        $lines[] = '';
        $lines[] = '═══════════════════════════════';
        $lines[] = 'TEST WITH YOUR OWN NUMBER BELOW';
        $lines[] = '═══════════════════════════════';

        return $this->render($lines, $testTarget, $testMessage);
    }

    private function render(array $lines, string $lastTarget = '', string $lastMessage = '')
    {
        $html = '<html><head><title>WhatsApp Diagnostic</title></head>';
        $html .= '<style>
            body{font-family:monospace;padding:2rem;background:#1e293b;color:#e2e8f0;font-size:14px;line-height:1.7;max-width:800px;margin:0 auto}
            h1{color:#f59e0b} .pass{color:#22c55e} .fail{color:#ef4444}
            form{background:#334155;padding:1.5rem;border-radius:12px;margin:1rem 0}
            label{display:block;margin-bottom:0.25rem;color:#94a3b8;font-size:12px}
            input,textarea{width:100%;padding:0.5rem;border:1px solid #475569;border-radius:8px;background:#1e293b;color:#e2e8f0;margin-bottom:1rem;font-family:monospace;font-size:14px;box-sizing:border-box}
            button{background:#f59e0b;color:#1e293b;border:none;padding:0.6rem 1.5rem;border-radius:8px;font-weight:bold;cursor:pointer}
            button:hover{background:#d97706}
            </style>';
        $html .= '</head><body>';
        $html .= '<h1>🔍 WhatsApp Gateway Diagnostic</h1>';

        $html .= '<form method="GET" style="margin-bottom:0.5rem">';
        $html .= '<button type="submit" style="background:#475569;color:white">🔄 Refresh Gateway Check</button>';
        $html .= '</form>';

        $html .= '<pre>';
        foreach ($lines as $line) {
            $cls = '';
            if (str_starts_with($line, '✅')) $cls = 'pass';
            if (str_starts_with($line, '❌')) $cls = 'fail';
            $html .= $cls ? "<span class=\"{$cls}\">{$line}</span>\n" : "{$line}\n";
        }
        $html .= '</pre>';

        $html .= '<form method="GET">';
        $html .= '<h3 style="color:#f59e0b;margin-top:0">📱 Kirim Test WhatsApp</h3>';
        $html .= '<label>Nomor Target (contoh: 08123456789)</label>';
        $html .= '<input type="text" name="test_target" value="' . htmlspecialchars($lastTarget) . '" placeholder="08123456789">';
        $html .= '<label>Pesan</label>';
        $html .= '<textarea name="test_message" rows="3">' . htmlspecialchars($lastMessage) . '</textarea>';
        $html .= '<button type="submit">📤 Kirim Test</button>';
        $html .= '</form>';

        $html .= '</body></html>';
        return response($html);
    }
}
