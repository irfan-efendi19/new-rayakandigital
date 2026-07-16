<?php

namespace App\Http\Controllers;

use App\Services\DokuService;
use Illuminate\Http\Request;

class DokuWebhookController extends Controller
{
    /**
     * Handle incoming DOKU Virtual Account payment notification.
     *
     * DOKU calls this endpoint when a customer successfully pays a VA.
     */
    public function handleWebhook(Request $request, DokuService $dokuService)
    {
        logger()->info('DOKU webhook received', $request->all());
        
        // Simpan log ke public/doku-log.json agar bisa dilihat via browser
        file_put_contents(public_path('doku-log.json'), json_encode([
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'signature_valid' => $dokuService->testSignature($request), // We need to add testSignature to DokuService to not fail the actual process
        ], JSON_PRETTY_PRINT));

        $order = $dokuService->handleNotification($request);

        if (! $order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        return response()->json(['status' => 'ok']);
    }
}
