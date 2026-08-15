<?php

use App\Models\Theme;

test('x theme can be previewed', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.x'],
        [
            'name' => '𝕏 (Twitter)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'x']));

    $response->assertOk();
    $response->assertSee('themes/x/assets/css/style.css', false);
    $response->assertSee('Spaces', false);
    $response->assertSee('Poll Kehadiran (RSVP)', false);
    $response->assertSee('Official Prewedding Cinematic Film', false);
});
