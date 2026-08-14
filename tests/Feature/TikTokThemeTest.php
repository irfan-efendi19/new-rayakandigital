<?php

use App\Models\Theme;

test('tiktok theme can be previewed', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.tiktok'],
        [
            'name' => 'TikTok FYP',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'tiktok']));

    $response->assertOk();
    $response->assertSee('tiktok', false);
    $response->assertSee('FYP', false);
    $response->assertSee('LIVE', false);
});
