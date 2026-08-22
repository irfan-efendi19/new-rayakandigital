<?php

use App\Models\Theme;

test('snakes and ladders theme can be previewed with interactive board game elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.snakes_and_ladders'],
        [
            'name' => 'Snakes & Ladders (Ular Tangga Cinta)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'snakes-and-ladders']));

    $response->assertOk();
    $response->assertSee('themes/snakes_and_ladders/assets/css/style.css', false);
    $response->assertSee('themes/snakes_and_ladders/assets/js/snakes-ladders.js', false);
    $response->assertSee('SNAKES &amp; LADDERS', false);
    $response->assertSee('KOCOK DADU', false);
    $response->assertSee('KOTAK 100', false);
    $response->assertSee('PLAYTIME &amp; ROUNDS', false);
    $response->assertSee('Peti Harta Karun', false);
    $response->assertSee('IKUT BERMAIN &amp; KONFIRMASI HADIR', false);
    $response->assertSee('PLAYER LEADERBOARD', false);
});
