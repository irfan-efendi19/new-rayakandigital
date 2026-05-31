<?php

use App\Http\Controllers\PaymentWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/payment/callback', [PaymentWebhookController::class, 'handleWebhook']);
