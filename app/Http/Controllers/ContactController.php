<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('hubungi-kami');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $scriptUrl = config('services.google_sheet.script_url') ?? env('GOOGLE_SHEET_SCRIPT_URL');

        if (! $scriptUrl) {
            return response()->json([
                'message' => 'Google Sheet webhook URL belum dikonfigurasi. Silakan setel GOOGLE_SHEET_SCRIPT_URL di .env.',
            ], 500);
        }

        try {
            $response = Http::timeout(10)
                ->asForm()
                ->post($scriptUrl, [
                    'timestamp' => now()->toDateTimeString(),
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'subject' => $data['subject'],
                    'message' => $data['message'],
                ]);

            if ($response->failed()) {
                Log::error('Google Sheet contact submission failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'message' => 'Gagal mengirim data ke Google Sheet. Silakan coba lagi.',
                ], 500);
            }
        } catch (\Throwable $exception) {
            Log::error('Google Sheet contact submission exception', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.',
            ], 500);
        }

        return response()->json([
            'message' => 'Pesan Anda berhasil terkirim dan disimpan ke Google Sheet.',
        ]);
    }
}
