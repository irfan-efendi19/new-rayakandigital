<?php

use App\Models\Theme;

test('claw machine theme can be previewed with interactive game elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.claw_machine'],
        [
            'name' => 'Love Claw Machine (Mesin Capit 3D)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'claw-machine']));

    $response->assertOk();
    $response->assertSee('themes/claw_machine/assets/css/style.css', false);
    $response->assertSee('themes/claw_machine/assets/js/claw-game.js', false);
    $response->assertSee('CATCH YOUR INVITE', false);
    $response->assertSee('DROP', false);
    $response->assertSee('EXCLUSIVE WEDDING PASS', false);
    $response->assertSee('PLAYTIME SCHEDULE', false);
    $response->assertSee('Gashapon Mystery Capsule', false);
    $response->assertSee('CLAIM PRIZE', false);
    $response->assertSee('HIGH SCORE LEADERBOARD', false);
});
