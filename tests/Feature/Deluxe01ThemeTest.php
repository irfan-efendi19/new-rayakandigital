<?php

use App\Models\Theme;

test('deluxe 01 theme can be previewed with the editorial layout and invitation features', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.deluxe_01'],
        [
            'name' => 'Deluxe 01 — Luxury Editorial',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'deluxe-01']));

    $response->assertSuccessful();
    $response->assertSee('themes/deluxe_01/assets/css/style.css', false);
    $response->assertSee('themes/deluxe_01/assets/js/script.js', false);
    $response->assertDontSee('PRIVATE INVITATION', false);
    $response->assertSee('Buka Undangan', false);
    $response->assertSee('DELUXE / 01', false);
    $response->assertSee('NO. 01 · EDITORIAL COLLECTION', false);
    $response->assertSee('d04-cover-curtain', false);
    $response->assertSee('d04ScrollProgress', false);
    $response->assertSee('d04FloatingControls', false);
    $response->assertSee('data-d04-reveal="clip"', false);
    $response->assertDontSee('d04-nav', false);
    $response->assertSee('E-Invitation &amp; QR Code', false);
    $response->assertSee('d04Checkin', false);
    $response->assertSee('Kedua Mempelai', false);
    $response->assertSee('Acara Pernikahan', false);
    $response->assertSee('Kisah Cinta', false);
    $response->assertSee('Galeri Kenangan', false);
    $response->assertSee('Konfirmasi Kehadiran', false);
    $response->assertSee('Ucapan &amp; Doa', false);
    $response->assertSee('data-preview="true"', false);
});

test('deluxe 01 and legacy aliases resolve to the same theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.deluxe_01'],
        [
            'name' => 'Deluxe 01 — Luxury Editorial',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertDontSee('PRIVATE INVITATION', false)
        ->assertSee('DELUXE / 01', false);
})->with([
    'deluxe-01',
    'deluxe_01',
    'deluxe01',
    'deluxe-editorial',
    'editorial-wedding',
    'luxury-editorial',
]);

test('deluxe 01 supports custom guest name via query param to', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.deluxe_01'],
        [
            'name' => 'Deluxe 01 — Luxury Editorial',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', [
        'themeSlug' => 'deluxe-01',
        'to' => 'Sahabat Terbaik',
    ]));

    $response->assertSuccessful();
    $response->assertSee('Sahabat Terbaik', false);
});
