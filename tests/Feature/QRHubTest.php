<?php

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('individual qr pages can be accessed publicly for active invitation', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'budi-ani',
        'bride_name' => 'Budi',
        'groom_name' => 'Ani',
        'is_active' => true,
        'gift_banks' => [
            ['bank_name' => 'BCA', 'account_number' => '1234567890', 'account_holder' => 'Budi'],
        ],
    ]);

    // 1. QR Hub page (3-in-1)
    $responseHub = $this->get('/budi-ani/qr');
    $responseHub->assertStatus(200);

    // 2. QR Kado page
    $responseKado = $this->get('/budi-ani/kado');
    $responseKado->assertStatus(200);
    $responseKado->assertSee('Kado Digital');
    $responseKado->assertSee('BCA');
    $responseKado->assertSee('1234567890');

    // 3. QR Ucapan page
    $responseUcapan = $this->get('/budi-ani/ucapan');
    $responseUcapan->assertStatus(200);
    $responseUcapan->assertSee('Ucapan & Doa');
    $responseUcapan->assertSee('Kirim Ucapan');
});

test('qr pages return 404 if invitation not found or inactive', function () {
    $this->get('/non-existent-slug/qr')->assertStatus(404);
    $this->get('/non-existent-slug/kado')->assertStatus(404);
    $this->get('/non-existent-slug/ucapan')->assertStatus(404);
});

test('dashboard invitation show page links to dedicated qr codes page and dedicated qr codes page displays cards', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'slug' => 'test-hub-slug',
        'is_active' => true,
    ]);

    // 1. Dashboard Show page contains link to Pusat QR Code
    $responseShow = $this->actingAs($user)->get(route('dashboard.invitations.show', $invitation));
    $responseShow->assertStatus(200);
    $responseShow->assertSeeText('Pusat Kelola & Unduh QR Code');
    $responseShow->assertSee(route('dashboard.invitations.qr-codes', $invitation));

    // 2. Dedicated QR Codes Page displays all QR cards
    $responseQr = $this->actingAs($user)->get(route('dashboard.invitations.qr-codes', $invitation));
    $responseQr->assertStatus(200);
    $responseQr->assertSee('Pusat QR Code');
    $responseQr->assertSee('QR Code Untuk Tamu');
    $responseQr->assertSee('QR Website Undangan');
    $responseQr->assertSee('QR Kado Digital');
    $responseQr->assertSee('QR Kirim Ucapan');
    $responseQr->assertSee('QR RSVP');
});
