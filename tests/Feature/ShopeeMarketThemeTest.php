<?php

use App\Models\Theme;

test('shopee market theme can be previewed with marketplace elements', function () {
    $theme = Theme::firstOrCreate(
        ['view_path' => 'themes.shopee_market'],
        [
            'name' => 'Shopee Wedding Edition (ShopLove Flash Sale)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'shopee']));

    $response->assertOk();
    $response->assertSee('themes/shopee_market/assets/css/style.css', false);
    $response->assertSee('themes/shopee_market/assets/js/shopee-market.js', false);
    $response->assertSee('shpCoverGate', false);
    $response->assertSee('PAKET PERNIKAHAN TIBA', false);
    $response->assertSee('BUKA PAKET / UNBOXING SEKARANG', false);
    $response->assertSee('Star+ Seller', false);
    $response->assertSee('FLASH SALE PERNIKAHAN', false);
    $response->assertSee('BELI SEKARANG (RSVP HADIR)', false);
    $response->assertSee('ShopeePay &amp; Kado Digital', false);
    $response->assertSee('PENILAIAN PRODUK', false);
});
