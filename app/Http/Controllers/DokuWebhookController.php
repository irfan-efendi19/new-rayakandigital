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

        if (! $dokuService->validateNotification($request)) {
            logger()->warning('DOKU webhook: invalid signature', [
                'client_id' => $request->header('Client-Id'),
            ]);

            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 401);
        }

        $order = $dokuService->handleNotification($request);

        if (! $order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        return response()->json(['status' => 'ok']);
    }
}
