<?php

use App\Models\Invitation;
use App\Models\Theme;

test('eternal flame theme can be previewed with sacred candle elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.eternal_flame'],
        [
            'name' => 'Lilin Doa Pengantin: The Eternal Flame',
            'thumbnail_portrait' => '/images/themes/eternal-flame-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'eternal-flame']));

    $response->assertOk();
    $response->assertSee('themes/eternal_flame/assets/css/style.css', false);
    $response->assertSee('themes/eternal_flame/assets/js/script.js', false);
    $response->assertSee('efGate', false);
    $response->assertSee('efCandleStage', false);
    $response->assertSee('Sentuh cahaya ini untuk membuka undangan pernikahan kami', false);
    $response->assertSee('Cinta bukan tentang mencari seseorang yang sempurna, tapi tentang menyatukan dua nyala api untuk menerangi jalan bersama', false);
    $response->assertSee('Nyalakan Doa Restu &amp; Hadir', false);
    $response->assertSee('efThankYouModal', false);
    $response->assertSee('Terima kasih telah menyalakan doa dan restu bersama kami. Kehadiran Anda adalah cahaya terindah di hari bahagia kami', false);
});

test('eternal flame theme can be accessed with lilin-doa alias', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.eternal_flame'],
        [
            'name' => 'Lilin Doa Pengantin: The Eternal Flame',
            'thumbnail_portrait' => '/images/themes/eternal-flame-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'lilin-doa']));

    $response->assertOk();
    $response->assertSee('efGate', false);
    $response->assertSee('The Eternal Flame', false);
});

test('eternal flame theme renders correctly for active invitation', function () {
    $invitation = Invitation::factory()->create([
        'theme' => 'eternal_flame',
        'is_active' => true,
        'title' => 'The Sacred Flame Wedding',
        'quote_content' => 'Cinta bukan tentang mencari seseorang yang sempurna, tapi tentang menyatukan dua nyala api untuk menerangi jalan bersama.',
    ]);

    $response = $this->get(route('invitation.show', $invitation->slug));

    $response->assertOk();
    $response->assertSee($invitation->couple_name);
    $response->assertSee('efCandleStage', false);
    $response->assertSee('Nyalakan Doa Restu &amp; Hadir', false);
});
