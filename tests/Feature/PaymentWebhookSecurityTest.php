<?php

use App\Models\Subscription;
use App\Models\User;

beforeEach(function () {
    // Set up standard midtrans server key to force simulation mode off
    config(['midtrans.server_key' => 'test-server-key']);
});

test('webhook fails when signature key is missing and not in simulation mode', function () {
    $user = User::factory()->create();

    $subscription = Subscription::create([
        'user_id' => $user->id,
        'tier' => 'gold',
        'midtrans_order_id' => 'RD-20260704-1-ABCD',
        'payment_status' => 'pending',
        'amount' => 99000,
    ]);

    $response = $this->postJson('/api/payment/callback', [
        'order_id' => 'RD-20260704-1-ABCD',
        'transaction_status' => 'settlement',
        'status_code' => '200',
        'gross_amount' => '99000.00',
    ]);

    $response->assertStatus(400);
    $response->assertJsonFragment(['status' => 'error', 'message' => 'Invalid notification']);

    $subscription->refresh();
    expect($subscription->payment_status)->toBe('pending');
});

test('webhook succeeds when valid signature key is provided', function () {
    $user = User::factory()->create();

    $subscription = Subscription::create([
        'user_id' => $user->id,
        'tier' => 'gold',
        'midtrans_order_id' => 'RD-20260704-1-ABCD',
        'payment_status' => 'pending',
        'amount' => 99000,
    ]);

    $orderId = 'RD-20260704-1-ABCD';
    $statusCode = '200';
    $grossAmount = '99000.00';
    $serverKey = 'test-server-key';

    $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

    $response = $this->postJson('/api/payment/callback', [
        'order_id' => $orderId,
        'transaction_status' => 'settlement',
        'status_code' => $statusCode,
        'gross_amount' => $grossAmount,
        'signature_key' => $signatureKey,
    ]);

    $response->assertStatus(200);
    $response->assertJsonFragment(['status' => 'ok']);

    $subscription->refresh();
    expect($subscription->payment_status)->toBe('settlement');
});
