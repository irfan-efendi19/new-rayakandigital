<?php

use App\Models\Theme;

test('spotify wrapped theme can be previewed with all sections', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.spotify_wrapped'],
        [
            'name' => 'Spotify Wrapped',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'spotify-wrapped']));

    $response->assertOk();
    $response->assertSee('themes/spotify_wrapped/assets/css/style.css', false);
    $response->assertSee('WRAPPED', false);
    $response->assertSee('Top Artists', false);
    $response->assertSee('Tour Dates', false);
    $response->assertSee('Tour Pass', false);
});
