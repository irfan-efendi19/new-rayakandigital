<?php

use App\Models\Theme;

test('google docs theme can be previewed with collaborative proposal details', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.google_docs'],
        [
            'name' => 'Google Docs — Proposal Hidup Bersama',
            'thumbnail_portrait' => '/images/themes/google-docs-thumb.svg',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'google-docs']));

    $response->assertSuccessful();
    $response->assertSee('themes/google_docs/assets/css/style.css', false);
    $response->assertSee('themes/google_docs/assets/js/script.js', false);
    $response->assertSee('id="gdocCover"', false);
    $response->assertSee('class="gdoc-cover-photo"', false);
    $response->assertSee('data-open-cover', false);
    $response->assertSee('Buka Dokumen', false);
    $response->assertSee('[DRAFT_FINAL]_Proposal_Kerjasama_Hidup_Seumur_Hidup_v2.0.docx', false);
    $response->assertSee('Tolong revisi tanggal resepsinya dipercepat ya nak!', false);
    $response->assertSee('Approved! Jangan lupa siapin makanan yang banyak.', false);
    $response->assertSee('Lampiran A — Galeri Dokumentasi', false);
    $response->assertSee('data-gallery-src=', false);
    $response->assertSee('Lampiran B — Tanda Kasih Digital', false);
    $response->assertSee('Bank Central Asia (BCA)', false);
    $response->assertSee('1234567890', false);
    $response->assertSee('data-copy-value=', false);
    $response->assertSee('[ Accept Changes &amp; Hadir ]', false);
});

test('google docs theme aliases resolve to the same collaborative document', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.google_docs'],
        [
            'name' => 'Google Docs — Proposal Hidup Bersama',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $this->get(route('theme.preview', ['themeSlug' => $slug]))
        ->assertSuccessful()
        ->assertSee('Proyek Hidup Bersama', false);
})->with(['google-doc', 'shared-document', 'dokumen-bersama']);
