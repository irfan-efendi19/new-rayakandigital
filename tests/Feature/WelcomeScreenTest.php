<?php

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\PlatformFeature;
use App\Models\ScreenPreset;
use App\Models\User;
use App\Models\Wish;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');

    // Seed screen presets so theme validation works
    ScreenPreset::insert([
        ['name' => 'Minimalist Typography', 'slug' => 'minimal-clean', 'description' => null, 'thumbnail_image' => null, 'html_content' => '<style>:root{--font-body:"Inter",sans-serif}</style>', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Rustic Floral', 'slug' => 'rustic-floral', 'description' => null, 'thumbnail_image' => null, 'html_content' => '<style>:root{--font-body:"Inter",sans-serif}</style>', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Modern Dark', 'slug' => 'modern-dark', 'description' => null, 'thumbnail_image' => null, 'html_content' => '<style>:root{--font-body:"Inter",sans-serif}</style>', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
    ]);

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

    // Create user and invitation
    $this->user = User::factory()->create(['role' => 'user']);
    $this->invitation = Invitation::factory()->create([
        'user_id' => $this->user->id,
        'tier' => 'platinum',
    ]);
});

test('owner can access welcome screen with platinum invitation', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard.welcome-screen.index', $this->invitation));

    $response->assertSuccessful()
        ->assertViewIs('welcome-screen.index');
});

test('non-owner cannot access welcome screen', function () {
    $otherUser = User::factory()->create();

    $response = $this->actingAs($otherUser)
        ->get(route('dashboard.welcome-screen.index', $this->invitation));

    $response->assertForbidden();
});

test('owner cannot access welcome screen if invitation is not premium (no qr_checkin feature)', function () {
    $goldInvitation = Invitation::factory()->create([
        'user_id' => $this->user->id,
        'tier' => 'gold',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('dashboard.welcome-screen.index', $goldInvitation));

    $response->assertForbidden();
});

test('owner can update welcome screen settings', function () {
    $response = $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'screen_bride_names' => 'Romeo & Juliet',
            'selected_theme' => 'rustic-floral',
            'custom_title' => 'Selamat Datang di Resepsi Kami',
            'show_wishes_wall' => '1',
        ]);

    $response->assertRedirect();

    $this->invitation->refresh();
    expect($this->invitation->screen_bride_names)->toBe('Romeo & Juliet');

    $screen = $this->invitation->screen;
    expect($screen)->not->toBeNull();
    expect($screen->selected_theme)->toBe('rustic-floral');
    expect($screen->custom_title)->toBe('Selamat Datang di Resepsi Kami');
    expect($screen->show_wishes_wall)->toBeTrue();
});

test('welcome screen settings validates selected theme', function () {
    $response = $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'selected_theme' => 'invalid-theme',
        ]);

    $response->assertSessionHasErrors(['selected_theme']);
});

test('owner can upload background image', function () {
    $file = UploadedFile::fake()->image('background.jpg');

    $response = $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'screen_background_image' => $file,
        ]);

    $response->assertRedirect();

    $this->invitation->refresh();
    expect($this->invitation->screen_background_image)->not->toBeNull();
    Storage::disk('public')->assertExists($this->invitation->screen_background_image);
});

test('owner can remove background image', function () {
    // First upload
    $file = UploadedFile::fake()->image('background.jpg');
    $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'screen_background_image' => $file,
        ]);

    $this->invitation->refresh();
    $path = $this->invitation->screen_background_image;
    Storage::disk('public')->assertExists($path);

    // Remove it
    $response = $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'remove_background' => true,
        ]);

    $response->assertRedirect();
    $this->invitation->refresh();
    expect($this->invitation->screen_background_image)->toBeNull();
    Storage::disk('public')->assertMissing($path);
});

test('owner can upload multiple gallery photos', function () {
    $photo1 = UploadedFile::fake()->image('photo1.jpg');
    $photo2 = UploadedFile::fake()->image('photo2.jpg');

    $response = $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'screen_gallery_photos' => [$photo1, $photo2],
        ]);

    $response->assertRedirect();

    expect($this->invitation->screenGalleries()->count())->toBe(2);

    $galleries = $this->invitation->screenGalleries()->get();
    expect($galleries[0]->sort_order)->toBe(0);
    expect($galleries[1]->sort_order)->toBe(1);

    Storage::disk('public')->assertExists($galleries[0]->image_path);
    Storage::disk('public')->assertExists($galleries[1]->image_path);
});

test('owner can delete a gallery photo', function () {
    $photo = UploadedFile::fake()->image('photo.jpg');

    $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'screen_gallery_photos' => [$photo],
        ]);

    $galleryItem = $this->invitation->screenGalleries()->first();
    $path = $galleryItem->image_path;
    Storage::disk('public')->assertExists($path);

    $response = $this->actingAs($this->user)
        ->delete(route('dashboard.welcome-screen.gallery.destroy', [$this->invitation, $galleryItem]));

    $response->assertRedirect();
    expect($this->invitation->screenGalleries()->count())->toBe(0);
    Storage::disk('public')->assertMissing($path);
});

test('owner cannot delete gallery photo of another invitation', function () {
    $photo = UploadedFile::fake()->image('photo.jpg');

    $this->actingAs($this->user)
        ->post(route('dashboard.welcome-screen.settings.update', $this->invitation), [
            'screen_gallery_photos' => [$photo],
        ]);

    $galleryItem = $this->invitation->screenGalleries()->first();

    $otherUser = User::factory()->create();
    $otherInvitation = Invitation::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($otherUser)
        ->delete(route('dashboard.welcome-screen.gallery.destroy', [$otherInvitation, $galleryItem]));

    $response->assertForbidden();
});

test('get latest checkin endpoint returns data correctly', function () {
    $guest = Guest::factory()->hadir()->create([
        'invitation_id' => $this->invitation->id,
        'name' => 'John Doe',
        'checked_in_at' => now()->subMinutes(5),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson(route('dashboard.welcome-screen.latest-checkin', $this->invitation));

    $response->assertSuccessful()
        ->assertJsonStructure([
            'success',
            'guests' => [
                '*' => ['id', 'name', 'checked_in_at', 'checkin_order'],
            ],
            'server_time',
        ])
        ->assertJsonFragment([
            'name' => 'John Doe',
            'checkin_order' => 1,
        ]);
});

test('get latest checkin endpoint filters by since parameter', function () {
    $time = now()->subMinutes(5);

    $guestOld = Guest::factory()->hadir()->create([
        'invitation_id' => $this->invitation->id,
        'name' => 'Old Guest',
        'checked_in_at' => $time->copy()->subMinutes(10),
    ]);

    $guestNew = Guest::factory()->hadir()->create([
        'invitation_id' => $this->invitation->id,
        'name' => 'New Guest',
        'checked_in_at' => $time->copy()->addMinutes(2),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson(route('dashboard.welcome-screen.latest-checkin', [
            'invitation' => $this->invitation,
            'since' => $time->toIso8601String(),
        ]));

    $response->assertSuccessful();

    $guests = $response->json('guests');
    expect(count($guests))->toBe(1);
    expect($guests[0]['name'])->toBe('New Guest');
});

test('welcome screen initializes default screen settings on index access', function () {
    expect($this->invitation->screen)->toBeNull();

    $response = $this->actingAs($this->user)
        ->get(route('dashboard.welcome-screen.index', $this->invitation));

    $response->assertSuccessful();

    $this->invitation->refresh();
    expect($this->invitation->screen)->not->toBeNull();
    expect($this->invitation->screen->selected_theme)->toBe('minimal-clean');
    expect($this->invitation->screen->show_wishes_wall)->toBeTrue();
});

test('welcome screen displays custom title and wishes wall when configured', function () {
    $this->invitation->screen()->create([
        'selected_theme' => 'rustic-floral',
        'custom_title' => 'Titel Kustom Kita',
        'show_wishes_wall' => true,
    ]);

    // Create a wish
    $this->invitation->wishes()->create([
        'guest_name' => 'Tamu Istimewa',
        'message' => 'Semoga bahagia selalu!',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('dashboard.welcome-screen.index', $this->invitation));

    $response->assertSuccessful()
        ->assertSee('Titel Kustom Kita')
        ->assertSee('Tamu Istimewa')
        ->assertSee('Semoga bahagia selalu!');
});

test('welcome screen does not display wishes wall when disabled', function () {
    $this->invitation->screen()->create([
        'selected_theme' => 'rustic-floral',
        'custom_title' => 'Titel Kustom Kita',
        'show_wishes_wall' => false,
    ]);

    // Create a wish
    $this->invitation->wishes()->create([
        'guest_name' => 'Tamu Istimewa',
        'message' => 'Semoga bahagia selalu!',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('dashboard.welcome-screen.index', $this->invitation));

    $response->assertSuccessful()
        ->assertSee('Titel Kustom Kita')
        ->assertDontSee('Tamu Istimewa')
        ->assertDontSee('Semoga bahagia selalu!');
});
