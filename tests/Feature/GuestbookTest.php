<?php

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\PlatformFeature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed packages and features
    $this->feature = PlatformFeature::create([
        'feature_key' => 'qr_checkin',
        'feature_name' => 'QR Code Check-In',
        'description' => 'Scan QR code untuk check-in tamu',
    ]);

    $this->platinumPackage = Package::create([
        'package_name' => 'Platinum',
        'package_code' => 'platinum',
        'price' => 250000,
        'duration_days' => 365,
    ]);

    $this->platinumPackage->features()->attach($this->feature);

    $this->goldPackage = Package::create([
        'package_name' => 'Gold',
        'package_code' => 'gold',
        'price' => 150000,
        'duration_days' => 365,
    ]);

    // Create user and invitation
    $this->user = User::factory()->create(['role' => 'user']);
    $this->invitation = Invitation::factory()->create([
        'user_id' => $this->user->id,
        'tier' => 'platinum',
    ]);
});

test('guest has auto-generated qr code token and correct defaults', function () {
    $guest = Guest::factory()->create([
        'invitation_id' => $this->invitation->id,
        'name' => 'Adit',
    ]);

    expect($guest->qr_code_token)->not->toBeNull();
    expect(Str::isUuid($guest->qr_code_token))->toBeTrue();
    expect($guest->attendance_status)->toBe('pending');
    expect($guest->checked_in_at)->toBeNull();
    $svg = $guest->qr_code_svg;
    expect(strlen($svg))->toBeGreaterThan(0);
    expect(str_contains($svg, '<svg'))->toBeTrue();
});

test('markAsHadir works correctly and is idempotent', function () {
    $guest = Guest::factory()->create([
        'invitation_id' => $this->invitation->id,
        'name' => 'Adit',
    ]);

    expect($guest->isHadir())->toBeFalse();

    $result = $guest->markAsHadir();
    expect($result)->toBeTrue();
    expect($guest->isHadir())->toBeTrue();
    expect($guest->checked_in_at)->not->toBeNull();

    // Secondary attempt should return false (idempotent)
    $result2 = $guest->markAsHadir();
    expect($result2)->toBeFalse();
});

test('owner can access guestbook dashboard with platinum invitation', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard.invitations.guestbook', $this->invitation));

    $response->assertSuccessful()
        ->assertViewIs('dashboard.guestbook.index');
});

test('non-owner cannot access guestbook dashboard', function () {
    $otherUser = User::factory()->create();

    $response = $this->actingAs($otherUser)
        ->get(route('dashboard.invitations.guestbook', $this->invitation));

    $response->assertForbidden();
});

test('owner cannot access guestbook if invitation is not platinum (no qr_checkin feature)', function () {
    $goldInvitation = Invitation::factory()->create([
        'user_id' => $this->user->id,
        'tier' => 'gold',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('dashboard.invitations.guestbook', $goldInvitation));

    $response->assertForbidden();
});

test('checkin with valid token works', function () {
    $guest = Guest::factory()->create([
        'invitation_id' => $this->invitation->id,
        'name' => 'Adit',
    ]);

    $response = $this->actingAs($this->user)
        ->postJson(route('dashboard.invitations.guestbook.checkin', $this->invitation), [
            'qr_code_token' => $guest->qr_code_token,
        ]);

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'guest' => [
                'name' => 'Adit',
                'checkin_order' => 1,
            ],
        ]);

    expect($guest->refresh()->isHadir())->toBeTrue();
});

test('checkin with already checked-in token returns 409', function () {
    $guest = Guest::factory()->hadir()->create([
        'invitation_id' => $this->invitation->id,
        'name' => 'Adit',
    ]);

    $response = $this->actingAs($this->user)
        ->postJson(route('dashboard.invitations.guestbook.checkin', $this->invitation), [
            'qr_code_token' => $guest->qr_code_token,
        ]);

    $response->assertStatus(409)
        ->assertJson([
            'success' => false,
            'message' => 'Tamu Sudah Hadir!',
            'already_checked_in' => true,
        ]);
});

test('checkin with invalid token returns 404', function () {
    $response = $this->actingAs($this->user)
        ->postJson(route('dashboard.invitations.guestbook.checkin', $this->invitation), [
            'qr_code_token' => 'invalid-token',
        ]);

    $response->assertNotFound()
        ->assertJson([
            'success' => false,
            'message' => 'Token tidak valid. QR Code tidak ditemukan untuk undangan ini.',
        ]);
});

test('owner can access guest ticket print page', function () {
    $guest = Guest::factory()->hadir()->create([
        'invitation_id' => $this->invitation->id,
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('dashboard.invitations.guestbook.ticket', [$this->invitation, $guest]));

    $response->assertSuccessful()
        ->assertViewIs('dashboard.guestbook.ticket');
});
