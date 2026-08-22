<?php

use App\Models\Theme;

test('marker doodle whiteboard theme can be previewed with interactive sketch elements and animations', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.marker_doodle'],
        [
            'name' => 'Spidol & Papan Tulis (The Marker Sketch Animation)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'marker-doodle']));

    $response->assertOk();
    $response->assertSee('themes/marker_doodle/assets/css/style.css', false);
    $response->assertSee('themes/marker_doodle/assets/js/marker-doodle.js', false);
    $response->assertSee('THE MARKER SKETCH', false);
    $response->assertSee('wb-drawing-pen-anim', false);
    $response->assertSee('wbScratchCanvas', false);
    $response->assertSee('THE INTERACTIVE ERASER', false);
    $response->assertSee('POJOK CORET-CORET', false);
    $response->assertSee('wbFreehandCanvas', false);
    $response->assertSee('wbBtnClearBoard', false);
    $response->assertSee('wbGuestInput', false);
    $response->assertSee('wbChoiceYes', false);
    $response->assertSee('wbChoiceNo', false);
    $response->assertSee('SIMPAN KEHADIRAN DI PAPAN', false);
});

test('marker doodle aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.marker_doodle'],
        [
            'name' => 'Spidol & Papan Tulis (The Marker Sketch Animation)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('THE MARKER SKETCH', false);
})->with([
    'marker-doodle',
    'spidol',
    'papan-tulis',
    'whiteboard',
    'doodle',
]);
