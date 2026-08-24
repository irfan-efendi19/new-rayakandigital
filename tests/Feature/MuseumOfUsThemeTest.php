<?php

use App\Models\Theme;

test('museum of us theme can be previewed with all museum gallery exhibition wings and interactive features', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.museum_of_us'],
        [
            'name' => 'The Museum of Us: Pameran Perjalanan Cinta',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'museum-of-us']));

    $response->assertOk();
    $response->assertSee('themes/museum_of_us/assets/css/style.css', false);
    $response->assertSee('themes/museum_of_us/assets/js/script.js', false);

    // Grand Entrance
    $response->assertSee('THE MUSEUM OF US', false);
    $response->assertSee('A Visual Exhibition of', false);
    $response->assertSee('Pintu galeri telah dibuka. Selamat menikmati kurasi perjalanan cinta kami.', false);
    $response->assertSee('Masuki Galeri Seni', false);

    // Exhibit Wings 01 - 04
    $response->assertSee('THE FIRST ENCOUNTER', false);
    $response->assertSee('Karya Seni: Awal Mula', false);
    $response->assertSee('Hari pertama dua semesta tak sengaja bersinggungan', false);

    $response->assertSee('THE MEMORIES', false);
    $response->assertSee('Karya Seni: Koleksi Kenangan', false);
    $response->assertSee('Kumpulan fragmen tawa, canda, dan perjalanan yang merajut hati', false);

    $response->assertSee('THE PROPOSAL', false);
    $response->assertSee('Karya Seni: The Turning Point', false);
    $response->assertSee('Satu pertanyaan sederhana yang mengubah selamanya', false);

    $response->assertSee('THE MASTERPIECE', false);
    $response->assertSee('Petunjuk Arah Menuju Gedung (Google Maps)', false);

    // Visitor Log & Countdown & RSVP E-Ticket
    $response->assertSee('VISITOR LOG', false);
    $response->assertSee('Buku Kesan &amp; Doa Restu Pengunjung Galeri', false);
    $response->assertSee('Grand Opening Exhibition in', false);
    $response->assertSee('Konfirmasi Tiket Kehadiran', false);
    $response->assertSee('VIP ADMISSION PASS', false);
    $response->assertSee('Tiket Anda telah divalidasi. Kurator dan pemilik museum menantikan kehadiran Anda di hari pameran utama.', false);
});

test('museum of us aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.museum_of_us'],
        [
            'name' => 'The Museum of Us: Pameran Perjalanan Cinta',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('THE MUSEUM OF US', false);
    $response->assertSee('Pameran Perjalanan', false);
})->with([
    'museum-of-us',
    'museum_of_us',
    'museum',
    'the-museum-of-us',
    'the_museum_of_us',
    'pameran-cinta',
    'pameran_cinta',
    'galeri-cinta',
    'galeri_cinta',
    'art-gallery',
    'gallery-of-us',
]);
