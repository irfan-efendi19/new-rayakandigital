<?php

use App\Models\Theme;

test('tetris theme can be previewed with expected elements', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.tetris'],
        [
            'name' => 'Tetris Arcade (The Perfect Fit Edition)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'tetris']));

    $response->assertOk();
    $response->assertSee('themes/tetris/assets/css/style.css', false);
    $response->assertSee('TETRIS!', false);
    $response->assertSee('THE FITTING PIECES', false);
    $response->assertSee('GAME QUESTS', false);
    $response->assertSee('DROP THE PERFECT PIECE', false);
    $response->assertSee('RSVP', false);
});

test('tetris theme aliases resolve correctly', function () {
    $response1 = $this->get(route('theme.preview', ['themeSlug' => 'game-tetris']));
    $response1->assertOk();
    $response1->assertSee('themes/tetris/assets/css/style.css', false);

    $response2 = $this->get(route('theme.preview', ['themeSlug' => 'tetris-wedding']));
    $response2->assertOk();
    $response2->assertSee('themes/tetris/assets/css/style.css', false);
});
