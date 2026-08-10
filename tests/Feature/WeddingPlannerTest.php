<?php

use App\Models\Invitation;
use App\Models\User;
use App\Models\WeddingPlannerItem;
use App\Models\WeddingRundown;

function createVerifiedUser(): User
{
    return User::factory()->create(['email_verified_at' => now()]);
}

test('QA-WP-01: item modul planner tersimpan ke kategori terkait', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.items.store'), [
            'category' => 'ADMINISTRATION',
            'title' => 'Pengurusan Surat Nikah KUA',
            'description' => 'Daftar berkas di KUA',
            'status' => 'IN_PROGRESS',
        ])
        ->assertRedirect(route('dashboard.planner.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('wedding_planner_items', [
        'user_id' => $user->id,
        'category' => 'ADMINISTRATION',
        'title' => 'Pengurusan Surat Nikah KUA',
        'status' => 'IN_PROGRESS',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful()
        ->assertSee('Pengurusan Surat Nikah KUA');
});

test('QA-WP-01: item dapat diupdate status dan dihapus', function () {
    $user = createVerifiedUser();

    $item = WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'SESERAHAN',
        'title' => 'Beli boks seserahan',
        'status' => 'PENDING',
    ]);

    $this->actingAs($user)
        ->patch(route('dashboard.planner.items.update', $item), [
            'category' => 'SESERAHAN',
            'title' => 'Beli boks seserahan',
            'status' => 'COMPLETED',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    expect($item->fresh()->status)->toBe('COMPLETED');

    $this->actingAs($user)
        ->delete(route('dashboard.planner.items.destroy', $item))
        ->assertRedirect(route('dashboard.planner.index'));

    expect(WeddingPlannerItem::find($item->id))->toBeNull();
});

test('QA-WP-01: item pengguna lain tidak dapat diakses', function () {
    $owner = createVerifiedUser();
    $intruder = createVerifiedUser();

    $item = WeddingPlannerItem::create([
        'user_id' => $owner->id,
        'category' => 'BUDGET',
        'title' => 'Vendor MUA',
    ]);

    $this->actingAs($intruder)
        ->patch(route('dashboard.planner.items.update', $item), [
            'category' => 'BUDGET',
            'title' => 'Hacked',
        ])
        ->assertForbidden();

    $this->actingAs($intruder)
        ->delete(route('dashboard.planner.items.destroy', $item))
        ->assertForbidden();
});

test('QA-WP-02: akumulasi nominal budget di ringkasan finansial', function () {
    $user = createVerifiedUser();

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'BUDGET',
        'title' => 'Venue',
        'estimated_cost' => 50000000,
        'actual_cost' => 45000000,
        'paid_amount' => 25000000,
    ]);

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'VENDOR',
        'title' => 'MUA',
        'estimated_cost' => 3000000,
        'actual_cost' => 3000000,
        'paid_amount' => 1000000,
    ]);

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'CHECKLIST',
        'title' => 'Bukan budget',
        'estimated_cost' => 999999,
        'actual_cost' => 999999,
        'paid_amount' => 999999,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful()
        ->assertSee(number_format(53000000, 0, ',', '.'))    // total estimasi
        ->assertSee(number_format(26000000, 0, ',', '.'))    // total terbayar
        ->assertSee(number_format(22000000, 0, ',', '.'));   // sisa tagihan (48jt - 26jt)
});

test('QA-WP-03: rundown disimpan dan dirender secara kronologis', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.rundowns.store'), [
            'time_start' => '11:00',
            'time_end' => '13:00',
            'activity_name' => 'Resepsi',
            'person_in_charge' => 'MC',
            'notes' => 'Gedung A',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    WeddingRundown::create([
        'user_id' => $user->id,
        'time_start' => '08:00',
        'activity_name' => 'Akad Nikah',
        'person_in_charge' => 'Penghulu',
    ]);

    WeddingRundown::create([
        'user_id' => $user->id,
        'time_start' => '14:00',
        'activity_name' => 'Penutup',
    ]);

    $this->assertDatabaseHas('wedding_rundowns', [
        'user_id' => $user->id,
        'activity_name' => 'Resepsi',
        'person_in_charge' => 'MC',
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $ordered = WeddingRundown::where('user_id', $user->id)->orderBy('time_start')->pluck('activity_name')->all();
    expect($ordered)->toBe(['Akad Nikah', 'Resepsi', 'Penutup']);

    $content = $response->getContent();
    $akadPos = strpos($content, 'Akad Nikah');
    $resepsiPos = strpos($content, 'Resepsi');
    $penutupPos = strpos($content, 'Penutup');

    expect($akadPos)->not->toBeFalse()
        ->and($resepsiPos)->not->toBeFalse()
        ->and($penutupPos)->not->toBeFalse()
        ->and($akadPos)->toBeLessThan($resepsiPos)
        ->and($resepsiPos)->toBeLessThan($penutupPos);
});

test('QA-WP-03: rundown pengguna lain tidak dapat dimodifikasi', function () {
    $owner = createVerifiedUser();
    $intruder = createVerifiedUser();

    $rundown = WeddingRundown::create([
        'user_id' => $owner->id,
        'time_start' => '09:00',
        'activity_name' => 'Akad',
    ]);

    $this->actingAs($intruder)
        ->patch(route('dashboard.planner.rundowns.update', $rundown), [
            'time_start' => '10:00',
            'activity_name' => 'Hacked',
        ])
        ->assertForbidden();

    $this->actingAs($intruder)
        ->delete(route('dashboard.planner.rundowns.destroy', $rundown))
        ->assertForbidden();
});

test('QA-WP-03: validasi rundown menolak waktu akhir sebelum waktu mulai', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.rundowns.store'), [
            'time_start' => '14:00',
            'time_end' => '13:00',
            'activity_name' => 'Invalid',
        ])
        ->assertSessionHasErrors('time_end');
});

test('QA-WP-04: export PDF rundown & budget menghasilkan file PDF', function () {
    $user = createVerifiedUser();

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'BUDGET',
        'title' => 'Venue',
        'estimated_cost' => 50000000,
        'actual_cost' => 45000000,
        'paid_amount' => 25000000,
    ]);

    WeddingRundown::create([
        'user_id' => $user->id,
        'time_start' => '08:00',
        'activity_name' => 'Akad Nikah',
        'person_in_charge' => 'Penghulu',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.export-pdf'))
        ->assertSuccessful()
        ->assertHeader('content-type', 'application/pdf');
});

test('countdown Hari H tampil di header sesuai tanggal undangan', function () {
    $user = createVerifiedUser();

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'event_date' => now()->addMonths(3)->startOfDay()->toDateString(),
        'event_time' => '08:00',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful()
        ->assertSee('Countdown Menuju Hari H')
        ->assertSee($invitation->event_date->translatedFormat('l, d F Y'))
        ->assertSee($invitation->title)
        ->assertSee('plannerCountdown');
});

test('countdown Hari H mengikuti tanggal pada invitation_events', function () {
    $user = createVerifiedUser();

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'event_date' => null,
        'event_time' => null,
    ]);

    $invitation->events()->create([
        'event_title' => 'Resepsi',
        'event_date' => now()->addMonths(2)->startOfDay()->toDateString(),
        'start_time' => '10:00',
        'place_name' => 'Gedung A',
        'place_address' => 'Jakarta',
        'sort_order' => 0,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful()
        ->assertSee('Countdown Menuju Hari H')
        ->assertSee(now()->addMonths(2)->startOfDay()->translatedFormat('l, d F Y'));
});

test('countdown tidak tampil bila tanggal undangan belum diisi', function () {
    $user = createVerifiedUser();

    Invitation::factory()->create([
        'user_id' => $user->id,
        'event_date' => null,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful()
        ->assertDontSee('Countdown Menuju Hari H');
});

test('planner hanya dapat diakses pengguna yang terautentikasi', function () {
    $this->get(route('dashboard.planner.index'))
        ->assertRedirect('/login');
});

test('QA-WP-05: vendor disimpan dengan tipe dan tampil pada kartu kategori vendor', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.items.store'), [
            'category' => 'VENDOR',
            'vendor_type' => 'VENUE',
            'title' => 'Venue Ballroom Grand',
            'description' => 'Gedung utama',
            'estimated_cost' => 50000000,
            'actual_cost' => 45000000,
            'paid_amount' => 10000000,
            'vendor_contact' => '0812-1111-2222',
            'status' => 'IN_PROGRESS',
        ])
        ->assertRedirect(route('dashboard.planner.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('wedding_planner_items', [
        'user_id' => $user->id,
        'category' => 'VENDOR',
        'vendor_type' => 'VENUE',
        'title' => 'Venue Ballroom Grand',
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    expect($content)->toContain('Vendor Pernikahan')
        ->and($content)->toContain(e('Venue Ballroom Grand'))
        ->and($content)->toContain(e('0812-1111-2222'));
});

test('QA-WP-05: setiap kategori vendor menampilkan state kosong saat belum ada vendor', function () {
    $user = createVerifiedUser();

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    foreach (WeddingPlannerItem::VENDOR_TYPES as $label) {
        expect($content)->toContain(e($label));
    }

    expect(substr_count($content, 'Belum ada vendor'))->toBe(7);
});

test('QA-WP-05: vendor diedit dan tipe kategorinya diperbarui', function () {
    $user = createVerifiedUser();

    $vendor = WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'VENDOR',
        'vendor_type' => 'MUA',
        'title' => 'MUA Ayu',
        'status' => 'PENDING',
    ]);

    $this->actingAs($user)
        ->patch(route('dashboard.planner.items.update', $vendor), [
            'category' => 'VENDOR',
            'vendor_type' => 'DOCUMENTATION',
            'title' => 'MUA & Foto Ayu',
            'status' => 'COMPLETED',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    expect($vendor->fresh()->vendor_type)->toBe('DOCUMENTATION')
        ->and($vendor->fresh()->title)->toBe('MUA & Foto Ayu')
        ->and($vendor->fresh()->status)->toBe('COMPLETED');
});

test('QA-WP-05: tipe vendor tidak valid ditolak', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.items.store'), [
            'category' => 'VENDOR',
            'vendor_type' => 'MAKANAN_RINGAN',
            'title' => 'Catering',
        ])
        ->assertSessionHasErrors('vendor_type');
});

test('QA-WP-06: panel pre-wedding menampilkan item persiapan dengan budget & realisasi', function () {
    $user = createVerifiedUser();

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'PRE_WEDDING',
        'title' => 'Make up',
        'estimated_cost' => 500000,
        'actual_cost' => 500000,
        'paid_amount' => 200000,
    ]);

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'PRE_WEDDING',
        'title' => 'Hairdo',
        'estimated_cost' => 300000,
        'actual_cost' => 250000,
        'paid_amount' => 100000,
    ]);

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'PRE_WEDDING',
        'title' => 'Baju pria',
        'estimated_cost' => 1000000,
        'actual_cost' => 1000000,
        'paid_amount' => 500000,
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    expect($content)->toContain('Item persiapan')
        ->and($content)->toContain('3 item · total Rp 1.800.000')
        ->and($content)->toContain(e('Make up'))
        ->and($content)->toContain(e('Hairdo'))
        ->and($content)->toContain(e('Baju pria'))
        ->and($content)->toContain('Total keseluruhan')
        ->and($content)->toContain('Budget Rp 1.800.000 · Realisasi Rp 1.750.000')
        ->and($content)->toContain('total terbayar')
        ->and($content)->toContain('800.000');
});

test('QA-WP-06: preset item pre-wedding otomatis dibuat saat pertama akses', function () {
    $user = createVerifiedUser();

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'PRE_WEDDING')->count())->toBe(10);

    expect($content)->toContain('Item persiapan')
        ->and($content)->toContain('10 item · total Rp 0')
        ->and($content)->toContain('Total keseluruhan')
        ->and($content)->not->toContain('Belum ada item persiapan');

    foreach (WeddingPlannerItem::PRE_WEDDING_ITEMS as $title) {
        expect($content)->toContain(e($title));
    }
});

test('QA-WP-06: seeding preset pre-wedding idempotent dan tidak menimpa data pengguna', function () {
    $user = createVerifiedUser();

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'PRE_WEDDING',
        'title' => 'Shooting studio',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'PRE_WEDDING')->count())->toBe(1);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'PRE_WEDDING')->count())->toBe(1);
});

test('QA-WP-06: preset pre-wedding dibuat ulang bila seluruh item dihapus', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'PRE_WEDDING')->count())->toBe(10);

    WeddingPlannerItem::where('user_id', $user->id)->where('category', 'PRE_WEDDING')->delete();

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'PRE_WEDDING')->count())->toBe(10);
});

test('QA-WP-07: preset rencana pertunangan otomatis dibuat (17 item di 7 kategori)', function () {
    $user = createVerifiedUser();

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'ENGAGEMENT')->count())->toBe(17);

    $content = $response->getContent();

    expect($content)->toContain('Rencana Pertunangan')
        ->and($content)->toContain('17 item di 7 kategori')
        ->and($content)->toContain('Total Pengeluaran')
        ->and($content)->toContain('Pria (CPP)')
        ->and($content)->toContain('Wanita (CPW)');

    foreach (WeddingPlannerItem::ENGAGEMENT_GROUP_LABELS as $label) {
        expect($content)->toContain(e('Subtotal '.$label));
    }

    foreach (array_merge(...array_values(WeddingPlannerItem::ENGAGEMENT_ITEMS)) as $title) {
        expect($content)->toContain(e($title));
    }
});

test('QA-WP-07: panel pertunangan menampilkan biaya pria/wanita, subtotal, dan total', function () {
    $user = createVerifiedUser();

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'ENGAGEMENT',
        'subcategory' => 'VENUE',
        'title' => 'Dekor',
        'cost_pria' => 100000,
        'cost_wanita' => 200000,
    ]);

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'ENGAGEMENT',
        'subcategory' => 'VENUE',
        'title' => 'Tenda',
        'cost_pria' => 300000,
        'cost_wanita' => 0,
    ]);

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'ENGAGEMENT',
        'subcategory' => 'DOCUMENTATION',
        'title' => 'Photografer',
        'cost_pria' => 150000,
        'cost_wanita' => 50000,
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    expect($content)->toContain('Pria Rp 550.000 · Wanita Rp 250.000')
        ->and($content)->toContain('Subtotal Venue')
        ->and($content)->toContain('Pria Rp 400.000 · Wanita Rp 200.000')
        ->and($content)->toContain('Subtotal Dokumentasi')
        ->and($content)->toContain('Pria Rp 150.000 · Wanita Rp 50.000')
        ->and($content)->toContain('Rp 800.000');
});

test('QA-WP-07: biaya pria/wanita disimpan dan diperbarui pada item pertunangan', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.items.store'), [
            'category' => 'ENGAGEMENT',
            'title' => 'Soflens',
            'cost_pria' => 75000,
            'cost_wanita' => 125000,
            'status' => 'PENDING',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    $item = WeddingPlannerItem::where('user_id', $user->id)->where('title', 'Soflens')->first();

    expect((float) $item->cost_pria)->toBe(75000.0)
        ->and((float) $item->cost_wanita)->toBe(125000.0);

    $this->actingAs($user)
        ->patch(route('dashboard.planner.items.update', $item), [
            'category' => 'ENGAGEMENT',
            'title' => 'Soflens',
            'cost_pria' => 80000,
            'cost_wanita' => 130000,
            'status' => 'COMPLETED',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    expect((float) $item->fresh()->cost_pria)->toBe(80000.0)
        ->and((float) $item->fresh()->cost_wanita)->toBe(130000.0);
});

test('QA-WP-07: biaya pria/wanita negatif ditolak', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.items.store'), [
            'category' => 'ENGAGEMENT',
            'title' => 'Dekor',
            'cost_pria' => -1000,
            'cost_wanita' => 5000,
        ])
        ->assertSessionHasErrors('cost_pria');
});

test('QA-WP-08: preset seserahan otomatis dibuat per pihak (pria & wanita) saat pertama akses', function () {
    $user = createVerifiedUser();

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'SESERAHAN')->count())->toBe(17)
        ->and(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'SESERAHAN')->where('subcategory', 'PRIA')->count())->toBe(8)
        ->and(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'SESERAHAN')->where('subcategory', 'WANITA')->count())->toBe(9);

    foreach (WeddingPlannerItem::SESERAHAN_ITEMS as $party => $titles) {
        foreach ($titles as $title) {
            expect($content)->toContain(e($title));
        }
    }

    expect($content)->toContain('Seserahan Pria')
        ->and($content)->toContain('Seserahan Wanita')
        ->and($content)->toContain('Pria (CPP)')
        ->and($content)->toContain('Wanita (CPW)')
        ->and($content)->not->toContain('Belum ada item seserahan.');
});

test('QA-WP-08: seeding preset seserahan idempotent per pihak dan tidak menimpa data pengguna', function () {
    $user = createVerifiedUser();

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'SESERAHAN',
        'subcategory' => 'PRIA',
        'title' => 'Beli boks seserahan',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    expect(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'SESERAHAN')->where('subcategory', 'PRIA')->count())->toBe(1)
        ->and(WeddingPlannerItem::where('user_id', $user->id)->where('category', 'SESERAHAN')->where('subcategory', 'WANITA')->count())->toBe(9);
});

test('QA-WP-08: item seserahan disimpan dengan pihak (subcategory) dan biaya, lalu dapat diubah', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.items.store'), [
            'category' => 'SESERAHAN',
            'subcategory' => 'WANITA',
            'title' => 'Kue hantaran',
            'estimated_cost' => 250000,
            'status' => 'PENDING',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    $item = WeddingPlannerItem::where('user_id', $user->id)->where('title', 'Kue hantaran')->first();

    expect($item)->not->toBeNull()
        ->and($item->subcategory)->toBe('WANITA')
        ->and((float) $item->estimated_cost)->toBe(250000.0);

    $this->actingAs($user)
        ->patch(route('dashboard.planner.items.update', $item), [
            'category' => 'SESERAHAN',
            'subcategory' => 'PRIA',
            'title' => 'Kue hantaran',
            'estimated_cost' => 300000,
            'status' => 'COMPLETED',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    expect($item->fresh()->subcategory)->toBe('PRIA')
        ->and((float) $item->fresh()->estimated_cost)->toBe(300000.0)
        ->and($item->fresh()->status)->toBe('COMPLETED');
});

test('QA-WP-08: subcategory seserahan hanya boleh PRIA/WANITA', function () {
    $user = createVerifiedUser();

    $this->actingAs($user)
        ->post(route('dashboard.planner.items.store'), [
            'category' => 'SESERAHAN',
            'subcategory' => 'KELUARGA',
            'title' => 'Seserahan keluarga',
        ])
        ->assertSessionHasErrors('subcategory');
});

test('QA-WP-08: panel seserahan menghitung subtotal dan total per pihak', function () {
    $user = createVerifiedUser();

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'SESERAHAN',
        'subcategory' => 'PRIA',
        'title' => 'Hantaran',
        'estimated_cost' => 1000000,
    ]);

    WeddingPlannerItem::create([
        'user_id' => $user->id,
        'category' => 'SESERAHAN',
        'subcategory' => 'WANITA',
        'title' => 'Kosmetik set',
        'estimated_cost' => 500000,
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    expect($content)->toContain('Subtotal Seserahan Pria')
        ->and($content)->toContain('Subtotal Seserahan Wanita')
        ->and($content)->toContain('Pria Rp 1.000.000 · Wanita Rp 500.000')
        ->and($content)->toContain('Rp 1.500.000');
});
