<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function handleWebhook(Request $request, MidtransService $midtransService)
    {
        $payload = $request->all();

        $subscription = $midtransService->handleNotification($payload);

        if (! $subscription) {
            return response()->json(['status' => 'error', 'message' => 'Invalid notification'], 400);
        }

        return response()->json(['status' => 'ok']);
    }
}
