<?php

use App\Models\Theme;

test('coloring love theme can be previewed with interactive sketch coloring elements and animations', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.coloring_love'],
        [
            'name' => 'Coloring Game: Menghidupkan Warna Cinta',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'coloring-love']));

    $response->assertOk();
    $response->assertSee('themes/coloring_love/assets/css/style.css', false);
    $response->assertSee('themes/coloring_love/assets/js/coloring-love.js', false);
    $response->assertSee('Menghidupkan Warna Cinta', false);
    $response->assertSee('Dunia kami dulunya hitam putih, sebelum cinta memberi warna', false);
    $response->assertSee('Setiap warna membawa cerita, dan kehadiranmu adalah warna terindah di hari penyatuan kami.', false);
    $response->assertSee('cl-paint-zone', false);
    $response->assertSee('cl-swatch-btn', false);
    $response->assertSee('clBtnAutoColor', false);
    $response->assertSee('clBtnSkip', false);
    $response->assertSee('clBaContainer', false);
    $response->assertSee('clCountdownWrap', false);
    $response->assertSee('Simpan Warna &amp; Konfirmasi Hadir', false);
    $response->assertSee('Kehadiranmu melengkapi palet kebahagiaan kami!', false);
});

test('coloring love aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.coloring_love'],
        [
            'name' => 'Coloring Game: Menghidupkan Warna Cinta',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('Menghidupkan Warna Cinta', false);
    $response->assertSee('The Coloring of Love', false);
})->with([
    'coloring-love',
    'coloring_love',
    'coloring-game',
    'coloring_game',
    'coloring',
    'menghidupkan-warna-cinta',
    'warna-cinta',
    'the-coloring-love',
]);
