<?php

use App\Models\Theme;

test('nasi padang theme can be previewed with authentic Minang restaurant signboard, dishes and parody elements', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.nasi_padang'],
        [
            'name' => 'Rumah Makan Minang (Papan Nama Nasi Padang)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'nasi-padang']));

    $response->assertOk();
    $response->assertSee('themes/nasi_padang/assets/css/style.css', false);
    $response->assertSee('themes/nasi_padang/assets/js/script.js', false);

    // Main Signboard Branding
    $response->assertSee('RUMAH MAKAN', false);
    $response->assertSee('JODOH MINANG', false);
    $response->assertSee('SPESIAL SEPASANG PENGANTIN RENDANG CINTA', false);

    // Special Menu Items
    $response->assertSee('Gulai Kehangatan', false);
    $response->assertSee('Sambal Doa Restu', false);
    $response->assertSee('Prasmanan Sepuasnya', false);
    $response->assertSee('Rendang Daging Cinta Abadi', false);
    $response->assertSee('Ayam Pop Kasih Sayang', false);

    // Etalase Kaca & Susunan Piring
    $response->assertSee('ETALASE KACA HIDANGAN UTAMA', false);
    $response->assertSee('SUSUNAN PIRING MINANG', false);

    // Schedule & Maps
    $response->assertSee('JAM BUKA RUMAH MAKAN (JADWAL ACARA)', false);
    $response->assertSee('Petunjuk Jalan Menuju Gedung (Google Maps)', false);

    // Guest Interaction (RSVP Button Exact Match)
    $response->assertSee('[ Pesan Menu Utama &amp; Hadir ]', false);
});

test('nasi padang aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.nasi_padang'],
        [
            'name' => 'Rumah Makan Minang (Papan Nama Nasi Padang)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('RUMAH MAKAN', false);
    $response->assertSee('JODOH MINANG', false);
    $response->assertSee('SPESIAL SEPASANG PENGANTIN RENDANG CINTA', false);
})->with([
    'nasi-padang',
    'nasi_padang',
    'padang',
    'rumah-makan-padang',
    'rumah_makan_padang',
    'minang',
    'warung-padang',
    'warung_padang',
    'restoran-padang',
    'restoran_padang',
    'ampera',
    'jodoh-minang',
    'jodoh_minang',
    'nasi-kapau',
]);
