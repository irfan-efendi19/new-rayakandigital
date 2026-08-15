<?php

use App\Models\Theme;

test('threads theme can be previewed with all sections', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.threads'],
        [
            'name' => 'Threads',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'threads']));

    $response->assertOk();
    $response->assertSee('themes/threads/assets/css/style.css', false);
    $response->assertSee('Buka Thread Undangan', false);
    $response->assertSee('Konfirmasi Kehadiran', false);
    $response->assertSee('Prewedding Cinematic Video Teaser', false);
    $response->assertSee('th-bottom-nav', false);
});
