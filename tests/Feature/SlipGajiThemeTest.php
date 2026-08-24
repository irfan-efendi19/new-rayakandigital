<?php

use App\Models\Theme;

test('slip gaji theme can be previewed with authentic Indonesian retro corporate payslip parody', function () {
    Theme::firstOrCreate(
        ['view_path' => 'themes.slip_gaji'],
        [
            'name' => 'Slip Gaji & Tunjangan Hari Bahagia (Payslip Notice)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => 'slip-gaji']));

    $response->assertOk();
    $response->assertSee('themes/slip_gaji/assets/css/style.css', false);
    $response->assertSee('themes/slip_gaji/assets/js/script.js', false);

    // Kop & Header Dokumen
    $response->assertSee('PT. BAHAGIA SELAMANYA Tbk.', false);
    $response->assertSee('DEPARTEMEN MERGER HATI', false);
    $response->assertSee('PAYSLIP NOTICE', false);
    $response->assertSee('SANGAT RAHASIA / CONFIDENTIAL', false);

    // Earnings & Deductions
    $response->assertSee('Gaji Pokok Kasih Sayang', false);
    $response->assertSee('Tunjangan Prasmanan &amp; Jamuan Seumur Hidup', false);
    $response->assertSee('Potongan Rindu &amp; Kesendirian', false);
    $response->assertSee('SAH MENJADI SUAMI &amp; ISTRI!', false);
    $response->assertSee('PAID IN FULL / LUNAS', false);

    // Events & Lokasi
    $response->assertSee('JADWAL PENCAIRAN &amp; LOKASI', false);
    $response->assertSee('Petunjuk Arah Menuju Lokasi (Google Maps)', false);

    // Features & RSVP
    $response->assertSee('PROCESSING PAYROLL DISBURSEMENT...', false);
    $response->assertSee('EMPLOYEE OF THE MONTH', false);
    $response->assertSee('HRD VALIDATION', false);
    $response->assertSee('Klaim Slip Gaji &amp; Hadir', false);
    $response->assertSee('APPROVED &amp; VALIDATED', false);
});

test('slip gaji aliases resolve correctly to the theme preview', function (string $slug) {
    Theme::firstOrCreate(
        ['view_path' => 'themes.slip_gaji'],
        [
            'name' => 'Slip Gaji & Tunjangan Hari Bahagia (Payslip Notice)',
            'is_premium' => true,
            'is_active' => true,
        ]
    );

    $response = $this->get(route('theme.preview', ['themeSlug' => $slug]));

    $response->assertOk();
    $response->assertSee('PT. BAHAGIA SELAMANYA Tbk.', false);
    $response->assertSee('PAYSLIP NOTICE', false);
})->with([
    'slip-gaji',
    'slip_gaji',
    'payslip',
    'payroll',
    'gaji',
]);
