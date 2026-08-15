<?php

use App\Models\Theme;

test('excel theme can be previewed with all sections', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.excel'],
        [
            'name' => 'Microsoft Excel',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'excel']));

    $response->assertOk();
    $response->assertSee('themes/excel/assets/css/style.css', false);
    $response->assertSee('Microsoft Excel', false);
    $response->assertSee('Buka Workbook Undangan', false);
    $response->assertSee('xl-running-ticker-bar', false);
    $response->assertSee('LIVE DATA', false);
    $response->assertSee('RSVP DATA ENTRY FORM', false);
    $response->assertSee('GUESTBOOK (DOA RESTU)', false);
});
