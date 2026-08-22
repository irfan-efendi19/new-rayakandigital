<?php

use App\Models\PreviewData;
use App\Models\Theme;
use App\Models\ThemePreviewData;
use Database\Seeders\ThemeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('theme preview uses global fallback when no theme-specific data exists', function () {
    PreviewData::getPreview();

    Theme::create([
        'name' => 'Jawa',
        'view_path' => 'themes.jawa',
        'is_premium' => false,
        'is_active' => true,
    ]);

    $this->get(route('theme.preview', 'jawa'))
        ->assertSuccessful()
        ->assertSee('Ani Suryani');
});

test('theme preview uses theme-specific data when configured', function () {
    PreviewData::getPreview();

    $theme = Theme::create([
        'name' => 'Jawa',
        'view_path' => 'themes.jawa',
        'is_premium' => false,
        'is_active' => true,
    ]);

    ThemePreviewData::create([
        'theme_id' => $theme->id,
        'groom_full_name' => 'Rizky Pratama',
        'groom_short_name' => 'Rizky',
        'bride_full_name' => 'Dewi Lestari',
        'bride_short_name' => 'Dewi',
    ]);

    $this->get(route('theme.preview', 'jawa'))
        ->assertSuccessful()
        ->assertSee('Dewi Lestari')
        ->assertSee('Rizky Pratama')
        ->assertDontSee('Ani Suryani');
});

test('theme preview merges partial theme data with global fallback', function () {
    $fallback = PreviewData::getPreview();

    $theme = Theme::create([
        'name' => 'Jawa',
        'view_path' => 'themes.jawa',
        'is_premium' => false,
        'is_active' => true,
    ]);

    $themePreview = new ThemePreviewData([
        'theme_id' => $theme->id,
        'bride_full_name' => 'Putri Adinda',
        'bride_short_name' => 'Putri',
        'groom_full_name' => null,
        'groom_short_name' => null,
    ]);

    $resolved = $themePreview->mergeWithFallback($fallback);

    expect($resolved->bride_name)->toBe('Putri Adinda')
        ->and($resolved->groom_name)->toBe('Budi Santoso');
});

test('legacy preview url redirects to new theme preview url', function () {
    PreviewData::getPreview();

    Theme::create([
        'name' => 'Jawa',
        'view_path' => 'themes.jawa',
        'is_premium' => false,
        'is_active' => true,
    ]);

    $this->get('/preview/jawa')
        ->assertRedirect(route('theme.preview', 'jawa'));
});

test('resolved preview data merges parents from theme-specific data', function () {
    PreviewData::getPreview();

    $theme = Theme::create([
        'name' => 'Jawa',
        'view_path' => 'themes.jawa',
        'is_premium' => false,
        'is_active' => true,
    ]);

    ThemePreviewData::create([
        'theme_id' => $theme->id,
        'groom_father_name' => 'Ahmad',
        'groom_mother_name' => 'Siti',
        'bride_father_name' => 'Bambang',
        'bride_mother_name' => 'Rina',
    ]);

    $resolved = $theme->fresh()->resolvedPreviewData();

    expect($resolved->groom_parents)->toBe('Putra dari Bapak Ahmad & Ibu Siti')
        ->and($resolved->bride_parents)->toBe('Putri dari Bapak Bambang & Ibu Rina');
});

test('netflix theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'netflix'))
        ->assertSuccessful()
        ->assertSee('RAYAFLIX')
        ->assertSee('Siapa yang menonton?')
        ->assertSee('Putar Undangan')
        ->assertSee('Pemeran Utama')
        ->assertSee('Dian Sastrowardoyo')
        ->assertSee('Nicholas Saputra');
});

test('youtube theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'youtube'))
        ->assertSuccessful()
        ->assertSee('RayaTube')
        ->assertSee('VLOG PERNIKAHAN')
        ->assertSee('Kreator Utama')
        ->assertSee('Nagita Slavina')
        ->assertSee('Raffi Ahmad')
        ->assertSee('SUBSCRIBE');
});

test('spotify theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'spotify'))
        ->assertSuccessful()
        ->assertSee('RayaFy')
        ->assertSee('Putar Lagu Undangan')
        ->assertSee('Featured Artists')
        ->assertSee('Isyana Sarasvati')
        ->assertSee('Afgansyah Reza')
        ->assertSee('Tracklist');
});

test('whatsapp theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'whatsapp'))
        ->assertSuccessful()
        ->assertSee('WhatsApp')
        ->assertSee('Buka Undangan')
        ->assertSee('Budi Santoso')
        ->assertSee('Rina Wati');
});

test('tiktok theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'tiktok'))
        ->assertSuccessful()
        ->assertSee('TikTok')
        ->assertSee('Buka FYP Undangan')
        ->assertSee('Aaliyah Massaid')
        ->assertSee('Thariq Halilintar');
});

test('x theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'x'))
        ->assertSuccessful()
        ->assertSee('Buka Feed Undangan')
        ->assertSee('Sheila Dara Aisha')
        ->assertSee('Oxavia Aldiano');
});

test('instagram theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'instagram'))
        ->assertSuccessful()
        ->assertSee('Buka Feed Instagram')
        ->assertSee('Mahalini Raharja')
        ->assertSee('Rizky Febian');
});

test('spotify wrapped theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'spotify-wrapped'))
        ->assertSuccessful()
        ->assertSee('Start My Wrapped')
        ->assertSee('Kevin Aprilio')
        ->assertSee('Vicy Melanie');
});

test('threads theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'threads'))
        ->assertSuccessful()
        ->assertSee('Buka Thread Undangan')
        ->assertSee('Angga Yunanda')
        ->assertSee('Shenina Cinnamon');
});

test('excel theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'excel'))
        ->assertSuccessful()
        ->assertSee('Buka Workbook Undangan')
        ->assertSee('Ryan Nugraha')
        ->assertSee('Sheila Maharani');
});

test('boarding pass theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'boarding-pass'))
        ->assertSuccessful()
        ->assertSee('Buka Paspor Undangan')
        ->assertSee('Dion Wiyoko')
        ->assertSee('Vanya Alodia');
});

test('retro game theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'retro-game'))
        ->assertSuccessful()
        ->assertSee('PRESS START TO PLAY')
        ->assertSee('Genta Pratama')
        ->assertSee('Kirana Larasati');
});

test('board game theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'board-game'))
        ->assertSuccessful()
        ->assertSee('Buka Papan Permainan')
        ->assertSee('Kevin Sanjaya')
        ->assertSee('Valencia Amanda');
});

test('manga and webtoon theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'manga'))
        ->assertSuccessful()
        ->assertSee('WEBTOON ORIGINAL')
        ->assertSee('BACA WEBTOON SEKARANG')
        ->assertSee('Kenzo Pratama')
        ->assertSee('Aiko Larasati');

    $this->get(route('theme.preview', 'webtoon'))
        ->assertSuccessful()
        ->assertSee('WEBTOON ORIGINAL')
        ->assertSee('BACA WEBTOON SEKARANG')
        ->assertSee('Kenzo Pratama')
        ->assertSee('Aiko Larasati');
});

test('library card and vintage book theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'library-card'))
        ->assertSuccessful()
        ->assertSee('DEWEY DECIMAL')
        ->assertSee('BUKA HALAMAN PERTAMA')
        ->assertSee('Julian Arthur')
        ->assertSee('Clarissa Roseline');

    $this->get(route('theme.preview', 'vintage-book'))
        ->assertSuccessful()
        ->assertSee('DEWEY DECIMAL')
        ->assertSee('BUKA HALAMAN PERTAMA')
        ->assertSee('Julian Arthur')
        ->assertSee('Clarissa Roseline');
});

test('newspaper and breaking news theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'newspaper'))
        ->assertSuccessful()
        ->assertSee('THE DAILY GAZETTE')
        ->assertSee('BREAKING NEWS')
        ->assertSee('Bramantyo Wicaksono')
        ->assertSee('Anya Praditya');

    $this->get(route('theme.preview', 'breaking-news'))
        ->assertSuccessful()
        ->assertSee('THE DAILY GAZETTE')
        ->assertSee('BREAKING NEWS')
        ->assertSee('Bramantyo Wicaksono')
        ->assertSee('Anya Praditya');
});

test('ojek online and delivery order theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'ojek-online'))
        ->assertSuccessful()
        ->assertSee('GoNikah')
        ->assertSee('Order Now')
        ->assertSee('Dimas Anggara')
        ->assertSee('Sarah Amanda');

    $this->get(route('theme.preview', 'gofood'))
        ->assertSuccessful()
        ->assertSee('GoNikah')
        ->assertSee('Order Now')
        ->assertSee('Dimas Anggara')
        ->assertSee('Sarah Amanda');
});

test('buku nikah and dokumen negara kua theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'buku-nikah'))
        ->assertSuccessful()
        ->assertSee('KEMENTERIAN AGAMA')
        ->assertSee('BUKU NIKAH')
        ->assertSee('Fadhil Pratama')
        ->assertSee('Nabila Putri');

    $this->get(route('theme.preview', 'kua'))
        ->assertSuccessful()
        ->assertSee('KEMENTERIAN AGAMA')
        ->assertSee('BUKU NIKAH')
        ->assertSee('Fadhil Pratama')
        ->assertSee('Nabila Putri');
});

test('scoreboard and papan skor arena theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'scoreboard'))
        ->assertSuccessful()
        ->assertSee('MATCH DAY')
        ->assertSee('Rizky FC')
        ->assertSee('United Nabila')
        ->assertSee('MASUK KE STADION');

    $this->get(route('theme.preview', 'papan-skor'))
        ->assertSuccessful()
        ->assertSee('MATCH DAY')
        ->assertSee('Rizky FC')
        ->assertSee('United Nabila')
        ->assertSee('MASUK KE STADION');
});

test('surat cinta dan kertas buku bergaris theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'surat-cinta'))
        ->assertSuccessful()
        ->assertSee('Sepucuk Surat Cinta')
        ->assertSee('Titip salam')
        ->assertSee('Gilang')
        ->assertSee('Dinda')
        ->assertSee('BALAS SURAT');

    $this->get(route('theme.preview', 'love-letter'))
        ->assertSuccessful()
        ->assertSee('Sepucuk Surat Cinta')
        ->assertSee('Titip salam')
        ->assertSee('Gilang')
        ->assertSee('Dinda')
        ->assertSee('BALAS SURAT');
});

test('majalah fashion and tabloid gosip y2k theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'tabloid'))
        ->assertSuccessful()
        ->assertSee('VOW')
        ->assertSee('EKSKLUSIF: Pasangan Ini Akhirnya Menikah')
        ->assertSee('Kevin')
        ->assertSee('Clarissa')
        ->assertSee('SUBSCRIBE TO OUR HAPPINESS');

    $this->get(route('theme.preview', 'majalah'))
        ->assertSuccessful()
        ->assertSee('VOW')
        ->assertSee('EKSKLUSIF: Pasangan Ini Akhirnya Menikah')
        ->assertSee('Kevin')
        ->assertSee('Clarissa')
        ->assertSee('SUBSCRIBE TO OUR HAPPINESS');
});

test('kai wedding access and boarding pass theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'kai'))
        ->assertSuccessful()
        ->assertSee('KAI WEDDING ACCESS')
        ->assertSee('WDD2026')
        ->assertSee('KA 01 - CINTA EXPRESS')
        ->assertSee('Stasiun Masa Lajang')
        ->assertSee('Stasiun Pelaminan')
        ->assertSee('CHECK-IN TIKET');

    $this->get(route('theme.preview', 'kai-access'))
        ->assertSuccessful()
        ->assertSee('KAI WEDDING ACCESS')
        ->assertSee('WDD2026')
        ->assertSee('KA 01 - CINTA EXPRESS')
        ->assertSee('Stasiun Masa Lajang')
        ->assertSee('Stasiun Pelaminan')
        ->assertSee('CHECK-IN TIKET');
});

test('crypto wedding dashboard and lct protocol theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'crypto'))
        ->assertSuccessful()
        ->assertSee('LCT-Wedding-Protocol-v2')
        ->assertSee('$LOVE')
        ->assertSee('Satria')
        ->assertSee('Aurel')
        ->assertSee('Sign &amp; Connect', false);

    $this->get(route('theme.preview', 'lct'))
        ->assertSuccessful()
        ->assertSee('LCT-Wedding-Protocol-v2')
        ->assertSee('$LOVE')
        ->assertSee('Satria')
        ->assertSee('Aurel')
        ->assertSee('Sign &amp; Connect', false);
});

test('buku rapor sekolah report card theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'rapor'))
        ->assertSuccessful()
        ->assertSee('BUKU RAPOR CINTA')
        ->assertSee('KEMENTERIAN CINTA & ASMARA')
        ->assertSee('Laporan Hasil Belajar Masa Lajang')
        ->assertSee('Rangga')
        ->assertSee('Cinta')
        ->assertSee('DINYATAKAN LULUS MENUJU PELAMINAN');
});

test('pixel arcade pac-love theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'arcade'))
        ->assertSuccessful()
        ->assertSee('PAC-LOVE')
        ->assertSee('FINAL STAGE: THE WEDDING')
        ->assertSee('THE LOVE MAZE')
        ->assertSee('PLAYER 1: THE GROOM')
        ->assertSee('PLAYER 2: THE BRIDE')
        ->assertSee('Andi')
        ->assertSee('Maya')
        ->assertSee('PRESS START');
});

test('teka teki silang cinta the love crossword theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'tts'))
        ->assertSuccessful()
        ->assertSee('TEKA-TEKI SILANG CINTA')
        ->assertSee('Lengkapi kotak-kotak bersilangan ini untuk membuka akses ke pesta kami!')
        ->assertSee('KORAN CINTA & ASMARA')
        ->assertSee('Rangga')
        ->assertSee('Cinta')
        ->assertSee('H - A - D - I - R')
        ->assertSee('Mulai Memecahkan TTS');
});

test('the eternal ring box experience theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'ring_box'))
        ->assertSuccessful()
        ->assertSee('THE ETERNAL PROMISE')
        ->assertSee('Sentuh untuk membuka lembaran janji suci kami')
        ->assertSee('Buka Kotak Cincin')
        ->assertSee('Cinta sejati bagaikan lingkaran cincin: tanpa awal, tanpa akhir, dan terikat dalam keabadian.')
        ->assertSee('Arya')
        ->assertSee('Maya');
});

test('the eternal date kalender abadi cinta theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'eternal_date'))
        ->assertSuccessful()
        ->assertSee('THE ETERNAL DATE')
        ->assertSee('Buka Lembaran Kalender')
        ->assertSee('Hari di mana kami resmi mengucap janji sehidup semati.')
        ->assertSee('Lembar RSVP tidak aktif dalam mode pratinjau tema.')
        ->assertSee('Dimas')
        ->assertSee('Anindya');
});

test('papan pengumuman surat edaran resmi theme preview renders successfully with expected elements', function () {
    $this->seed(ThemeSeeder::class);

    $this->get(route('theme.preview', 'papan-pengumuman'))
        ->assertSuccessful()
        ->assertSee('SEKOLAH TINGGI CINTA SEHIDUP SEMATI')
        ->assertSee('SURAT EDARAN RESMI')
        ->assertSee('Libur Permanen dari Masa Lajang')
        ->assertSee('LULUS &amp; SAH', false)
        ->assertSee('Bagas')
        ->assertSee('Sarah');
});
