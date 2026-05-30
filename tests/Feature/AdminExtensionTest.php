<?php

use App\Models\Addon;
use App\Models\Invitation;
use App\Models\SystemConfig;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed default settings
    SystemConfig::create([
        'demo_duration_days' => 5,
        'demo_grace_period_days' => 10,
    ]);

    // Seed default addons
    Addon::create([
        'feature_name' => 'Amplop Digital',
        'feature_key' => 'addon_digital_gift',
        'price' => 15000.00,
        'is_active' => true,
    ]);

    Addon::create([
        'feature_name' => 'Musik Kustom',
        'feature_key' => 'addon_custom_music',
        'price' => 15000.00,
        'is_active' => true,
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

    // Verify it is set to 5 days in the future (based on seeder setting of 5)
    $expectedExpiration = now()->addDays(5);
    expect($invitation->expires_at->format('Y-m-d'))->toBe($expectedExpiration->format('Y-m-d'));
});

test('expired invitation renders the custom expired page instead of showing the theme', function () {
    $user = User::factory()->create(['role' => 'user']);
    
    // Create an invitation that expired 1 day ago
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'expired-wedding',
        'title' => 'Expired Wedding',
        'is_active' => true,
        'expires_at' => now()->subDay(),
    ]);

    // Access as guest (not logged in)
    $this->get(route('invitation.show', $invitation->slug))
        ->assertSuccessful()
        ->assertViewIs('invitations.expired')
        ->assertSee('Masa Aktif Undangan Habis')
        ->assertSee('Login Pemilik Undangan');

    // Access as invitation owner
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

    // Verify initially they cannot use custom music and gift
    expect($invitation->canUseCustomMusic())->toBeFalse();
    expect($invitation->canUseGift())->toBeFalse();

    // Purchase/attach the digital gift addon
    $giftAddon = Addon::where('feature_key', 'addon_digital_gift')->first();
    $invitation->addons()->attach($giftAddon, ['purchased_at' => now()]);

    // Refresh and check
    $invitation->refresh();
    expect($invitation->canUseCustomMusic())->toBeFalse();
    expect($invitation->canUseGift())->toBeTrue();
    expect($invitation->maxGiftAccounts())->toBe(3);

    // Purchase/attach custom music addon
    $musicAddon = Addon::where('feature_key', 'addon_custom_music')->first();
    $invitation->addons()->attach($musicAddon, ['purchased_at' => now()]);

    $invitation->refresh();
    expect($invitation->canUseCustomMusic())->toBeTrue();
    expect($invitation->canUseGift())->toBeTrue();
});

test('cleanup command deletes expired invitations after grace period', function () {
    $user = User::factory()->create(['role' => 'user']);

    // 1. Invitation expired but within grace period (expired 5 days ago, grace period is 10)
    $invitationWithinGrace = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'within-grace',
        'expires_at' => now()->subDays(5),
    ]);

    // 2. Invitation expired and past grace period (expired 12 days ago, grace period is 10)
    $invitationPastGrace = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'past-grace',
        'expires_at' => now()->subDays(12),
    ]);

    // 3. Active invitation (expires in 3 days)
    $activeInvitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'active-inv',
        'expires_at' => now()->addDays(3),
    ]);

    // Run the artisan command
    $this->artisan('invitations:cleanup')
        ->assertSuccessful()
        ->expectsOutput('Found 1 invitation(s) past grace period. Cleaning up...')
        ->expectsOutput('Successfully cleaned up 1 invitation(s).');

    // Assert only the one past grace was deleted
    $this->assertDatabaseHas('invitations', ['id' => $invitationWithinGrace->id]);
    $this->assertDatabaseHas('invitations', ['id' => $activeInvitation->id]);
    $this->assertDatabaseMissing('invitations', ['id' => $invitationPastGrace->id]);
});
