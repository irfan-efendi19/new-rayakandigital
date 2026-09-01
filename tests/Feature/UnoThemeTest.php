<?php

use App\Models\Theme;

test('uno theme can be previewed with expected elements', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.uno'],
        [
            'name' => 'UNO Card Game (Wedding Edition)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'uno']));

    $response->assertOk();
    $response->assertSee('themes/uno/assets/css/style.css', false);
    $response->assertSee('UNO!', false);
    $response->assertSee('THE PLAYERS', false);
    $response->assertSee('ACTION CARDS', false);
    $response->assertSee('TARIK KARTU', false);
    $response->assertSee('RSVP', false);
});

test('uno theme aliases resolve correctly', function () {
    $response1 = $this->get(route('theme.preview', ['themeSlug' => 'kartu-uno']));
    $response1->assertOk();
    $response1->assertSee('themes/uno/assets/css/style.css', false);

    $response2 = $this->get(route('theme.preview', ['themeSlug' => 'uno-wedding']));
    $response2->assertOk();
    $response2->assertSee('themes/uno/assets/css/style.css', false);
});
