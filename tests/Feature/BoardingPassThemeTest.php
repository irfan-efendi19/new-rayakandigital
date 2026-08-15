<?php

use App\Models\Theme;

test('boarding pass theme can be previewed with all sections', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.boarding_pass'],
        [
            'name' => 'Boarding Pass & Paspor',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'boarding-pass']));

    $response->assertOk();
    $response->assertSee('themes/boarding_pass/assets/css/style.css', false);
    $response->assertSee('PASSPORT OF ETERNAL LOVE', false);
    $response->assertSee('BOARDING PASS', false);
    $response->assertSee('REPUBLIK CINTA', false);
    $response->assertSee('AIRPORT DEPARTURES', false);
    $response->assertSee('FLIGHT CHECK-IN', false);
});
