<?php

use App\Models\Theme;

test('board game theme can be previewed with expected elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.board_game'],
        [
            'name' => 'Board Game Monopoli',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'board-game']));

    $response->assertOk();
    $response->assertSee('themes/board_game/assets/css/style.css', false);
    $response->assertSee('MONOPOLI CINTA', false);
    $response->assertSee('KOCOK DADU', false);
    $response->assertSee('KARTU KESEMPATAN', false);
    $response->assertSee('COMMUNITY CHEST', false);
});
