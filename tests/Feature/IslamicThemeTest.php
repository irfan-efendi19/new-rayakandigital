<?php

use Database\Seeders\ThemeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('islamic theme preview route renders successfully without groom and bride photos', function () {
    $this->seed(ThemeSeeder::class);

    $response = $this->get(route('theme.preview', 'islamic'));

    $response->assertSuccessful();
    $response->assertSee('Ahmad Rizky Pratama');
    $response->assertSee('Fatimah Azzahra');
    $response->assertSee('Masjid Agung Al-Azhar');
    $response->assertSee('QS. Ar-Rum: 21');
    $response->assertSee('Mempelai Pria');
    $response->assertSee('Mempelai Wanita');
    $response->assertDontSee('isl-couple-photo-placeholder');
});
