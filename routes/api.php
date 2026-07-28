<?php

use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ScreenDisplayController;
use Illuminate\Support\Facades\Route;

Route::post('/payment/callback', [PaymentWebhookController::class, 'handleWebhook']);

// PRD §3: Endpoint publik untuk template Layar Sapa (tanpa autentikasi)
Route::prefix('v1')->group(function () {
    Route::get('/screen-wishes/{slug}', [ScreenDisplayController::class, 'screenWishes'])
        ->name('api.screen-wishes');
    Route::get('/screen-galleries/{slug}', [ScreenDisplayController::class, 'screenGalleries'])
        ->name('api.screen-galleries');
    Route::get('/screen-checkins/{slug}', [ScreenDisplayController::class, 'screenCheckins'])
        ->name('api.screen-checkins');
});
