<?php

use App\Models\User;
use App\Models\Theme;
use App\Models\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('user flow 4 langkah pernikahan platform', function () {
    // Seed themes
    Theme::create([
        'name' => 'Elegant Rose',
        'view_path' => 'themes.elegant',
        'thumbnail' => '/images/themes/elegant-thumb.jpg',
        'is_premium' => false,
        'is_active' => true,
    ]);

    // LANGKAH 1: PILIH TEMA
    // Guest visits homepage and sees themes
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Elegant Rose');

    // Guest visits preview page
    $this->get(route('theme.preview', 'elegant'))
        ->assertSuccessful()
        ->assertSee('Ani Suryani');

    // LANGKAH 2: REGISTER & DAFTAR DATA
    // Guest registers with selected theme parameter
    $registerResponse = $this->post(route('register', ['theme' => 'elegant']), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $registerResponse->assertRedirect(route('dashboard.invitations.create', ['theme' => 'elegant']));

    $user = User::where('email', 'john@example.com')->first();
    expect($user)->not->toBeNull();
    $this->assertAuthenticatedAs($user);

    // Fill primary invitation details (creation)
    $invitationData = [
        'title' => 'John & Jane Wedding',
        'bride_name' => 'Jane Doe',
        'groom_name' => 'John Doe',
        'bride_nickname' => 'Jane',
        'groom_nickname' => 'John',
        'bride_parents' => 'Bapak Jane & Ibu Jane',
        'groom_parents' => 'Bapak John & Ibu John',
        'theme' => 'elegant',
    ];

    $storeResponse = $this->actingAs($user)
        ->post(route('dashboard.invitations.store'), $invitationData);

    $storeResponse->assertRedirect(route('dashboard'));

    $invitation = Invitation::where('title', 'John & Jane Wedding')->first();
    expect($invitation)->not->toBeNull();
    expect($invitation->bride_nickname)->toBe('Jane');
    expect($invitation->groom_nickname)->toBe('John');

    // Fill extended detailed info
    $extendedData = array_merge($invitationData, [
        'event_date' => '2026-08-20',
        'event_time' => '09:00:00',
        'event_time_end' => '13:00:00',
        'timezone' => 'Asia/Jakarta',
        'venue_name' => 'Beautiful Cathedral',
        'venue_address' => '123 Holy Street',
        'venue_maps_url' => 'https://maps.google.com/?q=Cathedral',
        'love_story' => 'Met in library, got married in cathedral.',
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->put(route('dashboard.invitations.update', $invitation), $extendedData)
        ->assertRedirect(route('dashboard.invitations.show', $invitation));

    $invitation->refresh();
    expect($invitation->event_time_end)->toBe('13:00:00');
    expect($invitation->timezone)->toBe('Asia/Jakarta');

    // LANGKAH 3: AKTIVASI PAKET (SIMULATION)
    // Verify checkout page works
    $this->actingAs($user)
        ->get(route('dashboard.checkout'))
        ->assertSuccessful()
        ->assertSee('Paket');

    // Process upgrade to Gold (Simulation mode automatically activates package)
    $this->actingAs($user)
        ->post(route('dashboard.checkout.process'), ['tier' => 'gold'])
        ->assertRedirect(route('dashboard'));

    $user->refresh();
    expect($user->currentTier())->toBe('gold');

    $invitation->refresh();
    expect($invitation->canUseCustomMusic())->toBeTrue();
    expect($invitation->canUseGift())->toBeTrue();

    // LANGKAH 4: SEBARKAN UNDANGAN (Galeri + Kado + Tamu)
    // 1. Configure Kado Digital
    $giftData = [
        'gift_banks' => [
            [
                'bank_name' => 'BCA',
                'account_number' => '987654321',
                'account_holder' => 'Jane Doe',
            ],
        ],
    ];

    $this->actingAs($user)
        ->post(route('dashboard.invitations.gift.update', $invitation), $giftData)
        ->assertRedirect();

    $invitation->refresh();
    expect($invitation->gift_banks)->toBeArray();
    expect($invitation->gift_banks[0]['account_number'])->toBe('987654321');

    // 2. Import guests via CSV
    $csvContent = "Nama,Phone\nBudi Santoso,08123456789\nAni Suryani,08987654321\n";
    $csvFile = UploadedFile::fake()->createWithContent('guests.csv', $csvContent);

    $this->actingAs($user)
        ->post(route('dashboard.invitations.guests.import', $invitation), [
            'file' => $csvFile,
        ])
        ->assertRedirect();

    expect($invitation->guests()->count())->toBe(2);
    expect($invitation->guests()->where('name', 'Budi Santoso')->first())->not->toBeNull();
});
