<?php

use App\Models\EventSharedPhoto;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('qr maps page can be accessed and displays navigation links and parking guide', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'test-maps-slug',
        'is_active' => true,
        'venue_name' => 'Grand Ballroom Hotel Mulia',
        'venue_address' => 'Jl. Asia Afrika No.1, Jakarta Pusat',
        'venue_maps_url' => 'https://maps.google.com/?q=Hotel+Mulia',
        'venue_parking_info' => 'Parkir VIP di Basement 1. Gunakan Lift Lobby Selatan.',
    ]);

    $response = $this->get('/test-maps-slug/maps');

    $response->assertStatus(200);
    $response->assertSee('Grand Ballroom Hotel Mulia');
    $response->assertSee('Jl. Asia Afrika No.1, Jakarta Pusat');
    $response->assertSee('Buka di Google Maps');
    $response->assertSee('Parkir VIP di Basement 1. Gunakan Lift Lobby Selatan.');
});

test('qr shared gallery requires gold tier to be accessed and handles photo uploads', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'test-gallery-slug',
        'is_active' => true,
        'tier' => 'gold',
        'shared_drive_url' => 'https://drive.google.com/drive/folders/test12345',
    ]);

    $package = Package::create([
        'package_name' => 'Gold',
        'package_code' => 'gold',
        'price' => 150000,
        'duration_days' => 365,
    ]);
    $invitation->update(['pricing_tier_id' => $package->id]);

    // 1. Visit shared gallery page
    $response = $this->get('/test-gallery-slug/galeri-bersama');
    $response->assertStatus(200);
    $response->assertSee('Galeri Momen Acara');

    // 2. Upload guest photo
    $photo = UploadedFile::fake()->image('wedding-moment.jpg', 800, 600);

    $uploadResponse = $this->post('/test-gallery-slug/galeri-bersama/upload', [
        'photo' => $photo,
        'guest_name' => 'Rian & Teman-teman',
        'caption' => 'Selamat menempuh hidup baru!',
    ]);

    $uploadResponse->assertRedirect();

    // Verify photo record was saved in database
    $this->assertDatabaseHas('event_shared_photos', [
        'invitation_id' => $invitation->id,
        'guest_name' => 'Rian & Teman-teman',
        'caption' => 'Selamat menempuh hidup baru!',
    ]);

    // Verify photo file exists in storage
    $savedPhoto = EventSharedPhoto::first();
    Storage::disk('public')->assertExists($savedPhoto->photo_path);
});

test('qr shared gallery blocks free tier invitations', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'test-gallery-free-slug',
        'is_active' => true,
        'tier' => 'free',
    ]);

    $this->get('/test-gallery-free-slug/galeri-bersama')->assertStatus(403);
    $this->post('/test-gallery-free-slug/galeri-bersama/upload', [
        'photo' => UploadedFile::fake()->image('blocked.jpg'),
    ])->assertStatus(403);
});

test('dashboard qr codes page displays maps and shared gallery qr cards', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'test-dashboard-qr',
        'is_active' => true,
        'tier' => 'gold',
    ]);

    $package = Package::create([
        'package_name' => 'Gold',
        'package_code' => 'gold',
        'price' => 150000,
        'duration_days' => 365,
    ]);
    $invitation->update(['pricing_tier_id' => $package->id]);

    $response = $this->actingAs($user)->get(route('dashboard.invitations.qr-codes', $invitation));

    $response->assertStatus(200);
    $response->assertSeeText('QR Maps & Petunjuk Arah');
    $response->assertSeeText('QR Galeri Foto Bersama');
    $response->assertSee(route('dashboard.invitations.qr-maps', $invitation));
    $response->assertSee(route('dashboard.invitations.qr-gallery', $invitation));
});
