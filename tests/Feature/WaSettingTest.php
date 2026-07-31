<?php

use App\Jobs\SendWhatsappMessage;
use App\Models\Guest;
use App\Models\Invitation;
use App\Models\SystemConfig;
use App\Models\User;
use App\Models\WhatsappLog;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

test('authenticated user can view whatsapp setting page for invitation', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('dashboard.whatsapp.setting', $invitation));

    $response->assertStatus(200);
    $response->assertSee('WhatsApp Gateway');
    $this->assertDatabaseHas('wa_settings', [
        'invitation_id' => $invitation->id,
        'status' => 'PENDING_VERIFICATION',
    ]);
});

test('user can update sender phone number for invitation and status resets to pending verification', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post(route('dashboard.whatsapp.setting.update-phone', $invitation), [
        'phone_number' => '081234567890',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('wa_settings', [
        'invitation_id' => $invitation->id,
        'phone_number' => '081234567890',
        'status' => 'PENDING_VERIFICATION',
    ]);
});

test('user cannot get qr code if status is not ready to pair', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'phone_number' => '081234567890',
        'status' => 'PENDING_VERIFICATION',
    ]);

    $response = $this->actingAs($user)->postJson(route('dashboard.whatsapp.setting.get-qr', $invitation));

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
        ]);
});

test('user can request qr code when admin has set ready to pair status and token for invitation', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'phone_number' => '081234567890',
        'fonnte_token' => 'admin_injected_token_123',
        'status' => 'READY_TO_PAIR',
    ]);

    Http::fake([
        'https://api.fonnte.com/qr' => Http::response([
            'status' => true,
            'url' => 'https://api.fonnte.com/qr/sample.png',
        ], 200),
    ]);

    $response = $this->actingAs($user)->postJson(route('dashboard.whatsapp.setting.get-qr', $invitation));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'url' => 'https://api.fonnte.com/qr/sample.png',
        ]);

    $this->assertDatabaseHas('wa_settings', [
        'invitation_id' => $invitation->id,
        'status' => 'PAIRING',
    ]);
});

test('user can check device status for invitation from fonnte api', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'admin_injected_token_123',
        'status' => 'PAIRING',
    ]);

    Http::fake([
        'https://api.fonnte.com/device' => Http::response([
            'status' => true,
            'device' => '628123456789',
            'device_status' => 'CONNECT',
        ], 200),
    ]);

    $response = $this->actingAs($user)->getJson(route('dashboard.whatsapp.setting.check-status', $invitation));

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'CONNECTED',
            'phone_number' => '628123456789',
        ]);

    $this->assertDatabaseHas('wa_settings', [
        'invitation_id' => $invitation->id,
        'status' => 'CONNECTED',
        'phone_number' => '628123456789',
    ]);
});

test('user disconnect resets status to pending verification', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'admin_injected_token_123',
        'phone_number' => '628123456789',
        'status' => 'CONNECTED',
    ]);

    $response = $this->actingAs($user)->post(route('dashboard.whatsapp.setting.disconnect', $invitation));

    $response->assertRedirect();
    $this->assertDatabaseHas('wa_settings', [
        'invitation_id' => $invitation->id,
        'status' => 'PENDING_VERIFICATION',
    ]);
});

test('whatsapp blast dispatches send whatsapp message jobs for selected guests when connected', function () {
    Queue::fake();

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'user_token_123',
        'status' => 'CONNECTED',
    ]);

    $guest1 = Guest::factory()->create(['invitation_id' => $invitation->id, 'whatsapp_number' => '081234567890']);
    $guest2 = Guest::factory()->create(['invitation_id' => $invitation->id, 'whatsapp_number' => '089876543210']);

    $response = $this->actingAs($user)->post(route('dashboard.invitations.whatsapp.send', $invitation), [
        'guest_ids' => [$guest1->id, $guest2->id],
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    Queue::assertPushed(SendWhatsappMessage::class, 2);
});

test('send whatsapp message job uses fonnte service and admin token from invitation', function () {
    Http::fake([
        'https://api.fonnte.com/send' => Http::response([
            'status' => true,
            'detail' => 'Message queued/sent',
        ], 200),
    ]);

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'admin_injected_token_123',
        'status' => 'CONNECTED',
    ]);

    $guest = Guest::factory()->create(['invitation_id' => $invitation->id, 'whatsapp_number' => '081234567890']);

    $log = WhatsappLog::create([
        'invitation_id' => $invitation->id,
        'guest_id' => $guest->id,
        'message_content' => 'Halo Tamu Undangan',
        'status' => 'pending',
    ]);

    $job = new SendWhatsappMessage($log, $invitation, $guest, 'Halo Tamu Undangan');
    $job->handle(app(FonnteService::class));

    $this->assertDatabaseHas('whatsapp_logs', [
        'id' => $log->id,
        'status' => 'sent',
    ]);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.fonnte.com/send'
            && $request->hasHeader('Authorization', 'admin_injected_token_123')
            && $request['target'] === '081234567890';
    });
});

test('whatsapp blast is blocked when global quota is exhausted', function () {
    Queue::fake();

    SystemConfig::create(['wa_blast_quota_limit' => 1]);

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'wa_sent_count' => 1,
    ]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'user_token_123',
        'status' => 'CONNECTED',
    ]);

    $guest1 = Guest::factory()->create(['invitation_id' => $invitation->id, 'whatsapp_number' => '081234567890']);
    $guest2 = Guest::factory()->create(['invitation_id' => $invitation->id, 'whatsapp_number' => '089876543210']);

    $response = $this->actingAs($user)->post(route('dashboard.invitations.whatsapp.send', $invitation), [
        'guest_ids' => [$guest1->id, $guest2->id],
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');

    Queue::assertNotPushed(SendWhatsappMessage::class);

    $this->assertDatabaseHas('invitations', [
        'id' => $invitation->id,
        'wa_sent_count' => 1,
    ]);
});

test('whatsapp blast only queues up to remaining global quota and increments sent count', function () {
    Queue::fake();

    SystemConfig::create(['wa_blast_quota_limit' => 3]);

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'wa_sent_count' => 1,
    ]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'user_token_123',
        'status' => 'CONNECTED',
    ]);

    $guests = Guest::factory()->count(4)->create([
        'invitation_id' => $invitation->id,
        'whatsapp_number' => '081234567890',
    ]);

    $response = $this->actingAs($user)->post(route('dashboard.invitations.whatsapp.send', $invitation), [
        'guest_ids' => $guests->pluck('id')->all(),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    Queue::assertPushed(SendWhatsappMessage::class, 2);

    $this->assertDatabaseHas('invitations', [
        'id' => $invitation->id,
        'wa_sent_count' => 3,
    ]);
});

test('whatsapp blast without global quota limit dispatches all selected guests', function () {
    Queue::fake();

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'wa_sent_count' => 0,
    ]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'user_token_123',
        'status' => 'CONNECTED',
    ]);

    $guests = Guest::factory()->count(3)->create([
        'invitation_id' => $invitation->id,
        'whatsapp_number' => '081234567890',
    ]);

    $response = $this->actingAs($user)->post(route('dashboard.invitations.whatsapp.send', $invitation), [
        'guest_ids' => $guests->pluck('id')->all(),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    Queue::assertPushed(SendWhatsappMessage::class, 3);

    $this->assertDatabaseHas('invitations', [
        'id' => $invitation->id,
        'wa_sent_count' => 3,
    ]);
});

test('whatsapp single send is blocked when global quota is exhausted', function () {
    Queue::fake();

    SystemConfig::create(['wa_blast_quota_limit' => 2]);

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'wa_sent_count' => 2,
    ]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'user_token_123',
        'status' => 'CONNECTED',
    ]);

    $guest = Guest::factory()->create(['invitation_id' => $invitation->id, 'whatsapp_number' => '081234567890']);

    $response = $this->actingAs($user)->post(route('dashboard.invitations.whatsapp.send-single', [$invitation, $guest]));

    $response->assertRedirect();
    $response->assertSessionHas('error');

    Queue::assertNotPushed(SendWhatsappMessage::class);
});

test('whatsapp single send increments sent count when global quota is available', function () {
    Queue::fake();

    SystemConfig::create(['wa_blast_quota_limit' => 10]);

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'wa_sent_count' => 1,
    ]);
    $invitation->waSetting()->create([
        'user_id' => $user->id,
        'fonnte_token' => 'user_token_123',
        'status' => 'CONNECTED',
    ]);

    $guest = Guest::factory()->create(['invitation_id' => $invitation->id, 'whatsapp_number' => '081234567890']);

    $response = $this->actingAs($user)->post(route('dashboard.invitations.whatsapp.send-single', [$invitation, $guest]));

    $response->assertRedirect();
    $response->assertSessionHas('success');

    Queue::assertPushed(SendWhatsappMessage::class, 1);

    $this->assertDatabaseHas('invitations', [
        'id' => $invitation->id,
        'wa_sent_count' => 2,
    ]);
});

test('invitation quota helpers return correct values from global config', function () {
    $unlimited = Invitation::factory()->create(['wa_sent_count' => 0]);
    expect($unlimited->hasWaQuotaLimit())->toBeFalse();
    expect($unlimited->waQuotaLimit())->toBeNull();
    expect($unlimited->remainingWaQuota())->toBeNull();
    expect($unlimited->isWaQuotaExhausted())->toBeFalse();

    SystemConfig::create(['wa_blast_quota_limit' => 5]);

    $limited = Invitation::factory()->create(['wa_sent_count' => 2]);
    expect($limited->hasWaQuotaLimit())->toBeTrue();
    expect($limited->waQuotaLimit())->toBe(5);
    expect($limited->remainingWaQuota())->toBe(3);
    expect($limited->isWaQuotaExhausted())->toBeFalse();

    $exhausted = Invitation::factory()->create(['wa_sent_count' => 5]);
    expect($exhausted->remainingWaQuota())->toBe(0);
    expect($exhausted->isWaQuotaExhausted())->toBeTrue();
});
