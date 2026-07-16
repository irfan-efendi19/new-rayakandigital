<?php

use App\Models\Order;
use App\Models\PaymentMethodConfig;
use App\Models\User;
use App\Services\DokuService;
use Illuminate\Http\Request;

beforeEach(function () {
    // Ensure default config is not passing tests by accident
    config(['doku.client_id' => '']);
    config(['doku.secret_key' => '']);
    config(['doku.private_key' => '']);
});

it('checks if doku is configured via db', function () {
    $service = new DokuService;
    expect($service->isDokuConfigured())->toBeFalse();

    PaymentMethodConfig::create([
        'active_method' => 'doku',
        'doku_client_id' => 'CLIENT123',
        'doku_secret_key' => 'SECRET123',
        'doku_private_key' => 'PRIVATE123',
        'doku_environment' => 'sandbox',
    ]);

    $service2 = new DokuService;
    expect($service2->isDokuConfigured())->toBeTrue();
});

it('handles successful webhook notification', function () {
    $user = User::factory()->create();
    $order = Order::create([
        'order_id' => 'RD-12345',
        'user_id' => $user->id,
        'package_type' => 'gold',
        'payment_method_used' => 'doku',
        'gross_amount' => 150000,
        'unique_code' => 123,
        'payment_status' => 'pending',
        'payment_gateway_used' => 'doku',
    ]);

    PaymentMethodConfig::create([
        'active_method' => 'doku',
        'doku_client_id' => 'CLIENT123',
        'doku_secret_key' => 'SECRET',
        'doku_private_key' => 'KEY',
    ]);

    $service = new DokuService;

    $payload = [
        'order' => [
            'invoice_number' => 'RD-12345'
        ],
        'payment' => [
            'status' => 'SUCCESS',
        ]
    ];

    $request = new Request([], [], [], [], [], [
        'REQUEST_URI' => '/doku/notification',
    ], json_encode($payload));

    $request->merge($payload);

    $clientId = 'CLIENT123';
    $requestId = 'REQ-123';
    $timestamp = gmdate("Y-m-d\TH:i:s\Z");
    $targetPath = '/doku/notification';
    $digest = base64_encode(hash('sha256', json_encode($payload), true));

    $signatureString = 'Client-Id:'.$clientId."\n".
        'Request-Id:'.$requestId."\n".
        'Request-Timestamp:'.$timestamp."\n".
        'Request-Target:'.$targetPath."\n".
        'Digest:'.$digest;

    $signature = 'HMACSHA256='.base64_encode(hash_hmac('sha256', $signatureString, 'SECRET', true));

    $request->headers->set('Client-Id', $clientId);
    $request->headers->set('Request-Id', $requestId);
    $request->headers->set('Request-Timestamp', $timestamp);
    $request->headers->set('Signature', $signature);

    $handledOrder = $service->handleNotification($request);

    expect($handledOrder)->not->toBeNull();
    expect($handledOrder->payment_status)->toBe('success');

    $order->refresh();
    expect($order->payment_status)->toBe('success');
});
