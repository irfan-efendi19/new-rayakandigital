<?php

use App\Models\Theme;

test('instagram theme can be previewed with all sections', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.instagram'],
        [
            'name' => 'Instagram Feed',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'instagram']));

    $response->assertOk();
    $response->assertSee('themes/instagram/assets/css/style.css', false);
    $response->assertSee('Instagram', false);
    $response->assertSee('Stories', false);
    $response->assertSee('Reels', false);
    $response->assertSee('RSVP', false);
    $response->assertSee('Kado', false);
});
