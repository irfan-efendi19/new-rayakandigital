<?php

use App\Models\Theme;

test('tinder theme can be previewed', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.tinder'],
        [
            'name' => 'Tinder Love',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'tinder']));

    $response->assertOk();
    $response->assertSee('tinder', false);
    $response->assertSee('Kartu Match', false);
    $response->assertSee('It\'s a Match!', false);
});
