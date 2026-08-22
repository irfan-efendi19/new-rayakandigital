<?php

use App\Models\Theme;

test('daily brew theme can be previewed with coffee shop elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.daily_brew'],
        [
            'name' => 'The Daily Brew (Coffee & Roastery Edition)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'daily-brew']));

    $response->assertOk();
    $response->assertSee('themes/daily_brew/assets/css/style.css', false);
    $response->assertSee('themes/daily_brew/assets/js/daily-brew.js', false);
    $response->assertSee('brewCoverGate', false);
    $response->assertSee('WE ARE OPEN', false);
    $response->assertSee('BUKA UNDANGAN (ENTER ROASTERY)', false);
    $response->assertSee('COFFEE &amp; ROASTERY', false);
    $response->assertSee('SPECIAL BLEND OF THE DAY', false);
    $response->assertSee('ESPRESSO SHOT', false);
    $response->assertSee('CAPPUCCINO &amp; LATTE', false);
    $response->assertSee('BREW LOCATION', false);
    $response->assertSee('BARISTA NOTES', false);
    $response->assertSee('TABLE RESERVATION', false);
    $response->assertSee('Customer Reviews', false);
});
