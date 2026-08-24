<?php

use App\Models\Theme;

test('grocery receipt theme can be previewed with authentic Indonesian thermal receipt items and parodies', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.grocery_receipt'],
        [
            'name' => 'Struk Catatan Belanja Supermarket (Grocery Receipt)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'grocery-receipt']));

    $response->assertOk();
    $response->assertSee('themes/grocery_receipt/assets/css/style.css', false);
    $response->assertSee('themes/grocery_receipt/assets/js/script.js', false);

    // Store Header Khas Indonesia
    $response->assertSee('SUPERMARKET', false);
    $response->assertSee('CINTA', false);
    $response->assertSee('PT PELAMINAN MAKMUR SENTOSA TBK', false);
    $response->assertSee('PROMO JSM', false);

    // Grocery Items
    $response->assertSee('1 Pcs Status Lajang', false);
    $response->assertSee('Rp 0,00', false);
    $response->assertSee('2 Porsi Komitmen Seumur Hidup', false);
    $response->assertSee('Unlimited Doa Restu &amp; Prasmanan', false);
    $response->assertSee('TOTAL PEMBAYARAN:', false);
    $response->assertSee('LUNAS', false);
    $response->assertSee('LUNAS SAH KUA', false);
    $response->assertSee('Bahagia Sampai Kakek Nenek', false);

    // Event & Maps
    $response->assertSee('WAKTU &amp; TEMPAT TRANSAKSI (ACARA PERNIKAHAN)', false);
    $response->assertSee('Petunjuk Arah Menuju Kasir (Google Maps)', false);

    // Interaksi Tamu
    $response->assertSee('Cetak Struk &amp; Hadir', false);
    $response->assertSee('STRUK E-TICKET TERVALIDASI', false);
    $response->assertSee('MAU SEKALIAN ISI PULSA', false);
});

test('grocery receipt aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.grocery_receipt'],
        [
            'name' => 'Struk Catatan Belanja Supermarket (Grocery Receipt)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('SUPERMARKET', false);
    $response->assertSee('TOTAL PEMBAYARAN:', false);
})->with([
    'grocery-receipt',
    'grocery_receipt',
    'struk-belanja',
    'struk_belanja',
    'struk',
    'receipt',
    'supermarket',
    'minimarket',
    'kasir-cinta',
    'struk-kasir',
]);
