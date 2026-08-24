<?php

use App\Models\Theme;

test('linkedin theme can be previewed with professional wedding sections', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.linkedin'],
        [
            'name' => 'LinkedIn Wedding',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'linkedin']));

    $response->assertSuccessful();
    $response->assertSee('themes/linkedin/assets/css/style.css', false);
    $response->assertSee('Lihat Undangan', false);
    $response->assertSee('Partners for Life', false);
    $response->assertSee('Perjalanan profesional menuju selamanya', false);
    $response->assertSee('Konfirmasi kehadiran', false);
    $response->assertSee('li-mobile-nav', false);
});

test('linkedin wedding alias resolves to the linkedin theme', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.linkedin'],
        [
            'name' => 'LinkedIn Wedding',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $this->get(route('theme.preview', ['themeSlug' => 'linkedin-wedding']))
        ->assertSuccessful()
        ->assertSee('Partners for Life', false);
});
