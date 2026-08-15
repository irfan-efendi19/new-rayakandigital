<?php

use App\Models\Theme;

test('retro game theme can be previewed with all sections', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.retro_game'],
        [
            'name' => 'Retro 8-Bit Game',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'retro-game']));

    $response->assertOk();
    $response->assertSee('themes/retro_game/assets/css/style.css', false);
    $response->assertSee('SUPER WEDDING', false);
    $response->assertSee('PRESS START TO PLAY', false);
    $response->assertSee('PRESS START TO ATTEND', false);
    $response->assertSee('HIGH SCORES', false);
});
