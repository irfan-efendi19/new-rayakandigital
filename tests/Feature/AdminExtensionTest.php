<?php

use App\Models\Addon;
use App\Models\Invitation;
use App\Models\SystemConfig;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    SystemConfig::create([
        'demo_duration_days' => 5,
        'demo_grace_period_days' => 10,
    ]);

    Addon::create([
        'name' => 'Amplop Digital',
        'slug' => 'addon-digital-gift',
        'price' => 15000.00,
        'is_available' => true,
    ]);

    Addon::create([
        'name' => 'Musik Kustom',
        'slug' => 'addon-custom-music',
        'price' => 15000.00,
        'is_available' => true,
    ]);
});

test('free tier user invitation has expires_at set dynamically based on system config', function () {
    $user = User::factory()->create(['role' => 'user']);

    $invitationData = [
        'title' => 'My Wedding Dream',
        'bride_name' => 'Jane',
        'groom_name' => 'John',
        'bride_nickname' => 'Jane',
        'groom_nickname' => 'John',
        'theme' => 'elegant',
    ];

    $this->actingAs($user)
        ->post(route('dashboard.invitations.store'), $invitationData)
        ->assertRedirect(route('dashboard'));

    $invitation = Invitation::where('title', 'My Wedding Dream')->first();
    expect($invitation)->not->toBeNull();
    expect($invitation->expires_at)->not->toBeNull();

    $expectedExpiration = now()->addDays(5);
    expect($invitation->expires_at->format('Y-m-d'))->toBe($expectedExpiration->format('Y-m-d'));
});

test('expired invitation renders the custom expired page instead of showing the theme', function () {
    $user = User::factory()->create(['role' => 'user']);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'expired-wedding',
        'title' => 'Expired Wedding',
        'is_active' => true,
        'expires_at' => now()->subDay(),
    ]);

    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertViewIs('invitations.expired')
        ->assertSee('Masa Aktif Undangan Habis')
        ->assertSee('Login Pemilik Undangan');

    $this->actingAs($user)
        ->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertViewIs('invitations.expired')
        ->assertSee('Masa Aktif Undangan Habis')
        ->assertSee('Aktivasi Paket Sekarang');
});

test('addons bypass tier restrictions for premium features', function () {
    $user = User::factory()->create(['role' => 'user']);
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'tier' => 'free',
    ]);

    expect($invitation->canUseCustomMusic())->toBeFalse();
    expect($invitation->canUseGift())->toBeFalse();

    $giftAddon = Addon::where('slug', 'addon-digital-gift')->first();
    $invitation->addons()->attach($giftAddon, [
        'purchased_price' => 15000.00,
        'status_active' => true,
        'activated_at' => now(),
    ]);

    $invitation->refresh();
    expect($invitation->canUseCustomMusic())->toBeFalse();
    expect($invitation->canUseGift())->toBeTrue();
    expect($invitation->maxGiftAccounts())->toBe(3);

    $musicAddon = Addon::where('slug', 'addon-custom-music')->first();
    $invitation->addons()->attach($musicAddon, [
        'purchased_price' => 15000.00,
        'status_active' => true,
        'activated_at' => now(),
    ]);

    $invitation->refresh();
    expect($invitation->canUseCustomMusic())->toBeTrue();
    expect($invitation->canUseGift())->toBeTrue();
});

test('cleanup command deletes expired invitations after grace period', function () {
    $user = User::factory()->create(['role' => 'user']);

    $invitationWithinGrace = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'within-grace',
        'expires_at' => now()->subDays(5),
    ]);

    $invitationPastGrace = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'past-grace',
        'expires_at' => now()->subDays(12),
    ]);

    $activeInvitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'active-inv',
        'expires_at' => now()->addDays(3),
    ]);

    $this->artisan('invitations:cleanup')
        ->assertSuccessful()
        ->expectsOutput('Found 1 invitation(s) past grace period. Cleaning up...')
        ->expectsOutput('Successfully cleaned up 1 invitation(s).');

    $this->assertDatabaseHas('invitations', ['id' => $invitationWithinGrace->id]);
    $this->assertDatabaseHas('invitations', ['id' => $activeInvitation->id]);
    $this->assertDatabaseMissing('invitations', ['id' => $invitationPastGrace->id]);
});
