<?php

use App\Models\Theme;

test('premier screening theme can be previewed with all sections', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.premier_screening'],
        [
            'name' => 'Premier Screening — Cinema Wedding',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'premier-screening']));

    $response->assertOk();
    $response->assertSee('themes/premier_screening/assets/css/style.css', false);
    $response->assertSee('PREMIER', false);
    $response->assertSee('FOREVER IN THEATERS', false);
    $response->assertSee('THEATER RULES', false);
    $response->assertSee('Book Ticket', false);
});
