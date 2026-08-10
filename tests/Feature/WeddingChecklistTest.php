<?php

use App\Models\Invitation;
use App\Models\User;
use App\Models\WeddingChecklist;

function createChecklistUser(): User
{
    return User::factory()->create(['email_verified_at' => now()]);
}

function createChecklistInvitation(User $user, array $attributes = []): Invitation
{
    return Invitation::factory()->create(array_merge(['user_id' => $user->id], $attributes));
}

test('QA-CHK-01: inisialisasi checklist menghasilkan 40 preset + 18 dokumen persyaratan', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    expect(WeddingChecklist::where('invitation_id', $invitation->id)->count())->toBe(58);

    $documents = WeddingChecklist::where('invitation_id', $invitation->id)
        ->where('is_document', true)
        ->get();

    expect($documents)->toHaveCount(18)
        ->and($documents->every(fn ($item) => $item->is_preset))->toBeTrue()
        ->and($documents->every(fn ($item) => $item->category_code === 'ADMINISTRATION'))->toBeTrue();
});

test('QA-CHK-02: 40 preset item terbagi dalam 9 kategori', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $categories = WeddingChecklist::where('invitation_id', $invitation->id)
        ->pluck('category_code')
        ->unique()
        ->sort()
        ->values()
        ->all();

    $expected = collect(array_keys(WeddingChecklist::CATEGORIES))->sort()->values()->all();

    expect($categories)->toHaveCount(9)
        ->and($categories)->toBe($expected);
});

test('QA-CHK-03: seluruh preset memiliki is_preset=true dan status belum selesai', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $presets = WeddingChecklist::where('invitation_id', $invitation->id)->get();

    expect($presets->every(fn ($item) => $item->is_preset))->toBeTrue()
        ->and($presets->every(fn ($item) => ! $item->is_completed))->toBeTrue();
});

test('QA-CHK-04: toggle checklist mengubah status tanpa perlu reload (AJAX JSON)', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $item = WeddingChecklist::where('invitation_id', $invitation->id)
        ->where('is_document', false)
        ->first();

    $this->actingAs($user)
        ->patchJson(route('dashboard.planner.checklists.toggle', $item))
        ->assertSuccessful()
        ->assertJson([
            'success' => true,
            'is_completed' => true,
            'total_items' => 76,
            'completed_items' => 1,
            'progress_percent' => 1,
        ]);

    expect($item->fresh()->is_completed)->toBeTrue();

    $this->actingAs($user)
        ->patchJson(route('dashboard.planner.checklists.toggle', $item))
        ->assertJson(['is_completed' => false, 'completed_items' => 0, 'progress_percent' => 0]);
});

test('QA-CHK-05: progress global diperbarui sesuai item yang selesai', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    WeddingChecklist::where('invitation_id', $invitation->id)
        ->limit(10)
        ->update(['is_completed' => true]);

    $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    expect(WeddingChecklist::where('invitation_id', $invitation->id)->where('is_completed', true)->count())->toBe(10);
});

test('QA-CHK-06: progress mencapai 100% saat seluruh checkbox selesai', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    WeddingChecklist::where('invitation_id', $invitation->id)
        ->update(['is_completed' => true, 'is_completed_pria' => true, 'is_completed_wanita' => true]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful()
        ->assertSee('Checklist Wedding Plan')
        ->assertSee('Semua Ceklis Selesai');

    $content = $response->getContent();

    expect($content)->toContain('Dokumen Persyaratan')
        ->and($content)->toContain(e('Pendaftaran KUA'))
        ->and($content)->toContain(e('FC KTP calon pengantin'));
});

test('QA-CHK-07: tambah checklist custom dengan is_preset=false', function () {
    $user = createChecklistUser();
    createChecklistInvitation($user);

    $this->actingAs($user)
        ->post(route('dashboard.planner.checklists.store'), [
            'category_code' => 'OPERATIONS',
            'title' => 'Sewa mobil pengantin',
            'description' => 'Booking H-7',
        ])
        ->assertRedirect(route('dashboard.planner.index'))
        ->assertSessionHas('success');

    $item = WeddingChecklist::where('title', 'Sewa mobil pengantin')->first();

    expect($item)->not->toBeNull()
        ->and($item->is_preset)->toBeFalse()
        ->and($item->category_code)->toBe('OPERATIONS');
});

test('QA-CHK-08: edit checklist custom', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    $custom = $invitation->checklists()->create([
        'category_code' => 'CATERING',
        'category_name' => WeddingChecklist::CATEGORIES['CATERING'],
        'title' => 'Katering vegetarian',
        'is_completed' => false,
        'is_preset' => false,
    ]);

    $this->actingAs($user)
        ->patch(route('dashboard.planner.checklists.update', $custom), [
            'category_code' => 'CATERING',
            'title' => 'Katering vegetarian premium',
            'description' => 'Menu tambahan',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    expect($custom->fresh()->title)->toBe('Katering vegetarian premium')
        ->and($custom->fresh()->description)->toBe('Menu tambahan');
});

test('QA-CHK-09: delete checklist custom', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    $custom = $invitation->checklists()->create([
        'category_code' => 'CATERING',
        'category_name' => WeddingChecklist::CATEGORIES['CATERING'],
        'title' => 'Snack box',
        'is_completed' => false,
        'is_preset' => false,
    ]);

    $this->actingAs($user)
        ->delete(route('dashboard.planner.checklists.destroy', $custom))
        ->assertRedirect(route('dashboard.planner.index'));

    expect(WeddingChecklist::find($custom->id))->toBeNull();
});

test('QA-CHK-10: preset item tidak dapat diedit atau dihapus', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $preset = WeddingChecklist::where('invitation_id', $invitation->id)->where('is_preset', true)->first();

    $this->actingAs($user)
        ->patch(route('dashboard.planner.checklists.update', $preset), [
            'category_code' => 'CATERING',
            'title' => 'Hacked',
        ])
        ->assertForbidden();

    $this->actingAs($user)
        ->delete(route('dashboard.planner.checklists.destroy', $preset))
        ->assertForbidden();
});

test('QA-CHK-11: checklist tampil terkelompok berdasarkan kategori', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    foreach (WeddingChecklist::CATEGORIES as $label) {
        expect($content)->toContain(e($label));
    }
});

test('QA-CHK-12: dokumen persyaratan toggle per pihak (Pria/Wanita) dan dihitung sebagai checkbox terpisah', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $document = WeddingChecklist::where('invitation_id', $invitation->id)
        ->where('is_document', true)
        ->first();

    $this->actingAs($user)
        ->patchJson(route('dashboard.planner.checklists.toggle', $document), ['party' => 'pria'])
        ->assertSuccessful()
        ->assertJson([
            'success' => true,
            'is_completed_pria' => true,
            'is_completed_wanita' => false,
            'completed_items' => 1,
        ]);

    expect($document->fresh()->is_completed_pria)->toBeTrue()
        ->and($document->fresh()->is_completed_wanita)->toBeFalse();

    $this->actingAs($user)
        ->patchJson(route('dashboard.planner.checklists.toggle', $document), ['party' => 'wanita'])
        ->assertJson([
            'is_completed_pria' => true,
            'is_completed_wanita' => true,
            'completed_items' => 2,
        ]);

    expect($document->fresh()->is_completed_wanita)->toBeTrue();
});

test('QA-CHK-13: toggle dokumen tanpa parameter party ditolak', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $document = WeddingChecklist::where('invitation_id', $invitation->id)
        ->where('is_document', true)
        ->first();

    $this->actingAs($user)
        ->patchJson(route('dashboard.planner.checklists.toggle', $document))
        ->assertStatus(422);

    expect($document->fresh()->is_completed_pria)->toBeFalse()
        ->and($document->fresh()->is_completed_wanita)->toBeFalse();
});

test('QA-CHK-14: pilar Administrasi menampilkan dokumen persyaratan dengan checkbox Pria/Wanita', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    WeddingChecklist::initializePresets($invitation);

    $document = WeddingChecklist::where('invitation_id', $invitation->id)
        ->where('is_document', true)
        ->first();

    $response = $this->actingAs($user)
        ->get(route('dashboard.planner.index'))
        ->assertSuccessful();

    $content = $response->getContent();

    expect($content)->toContain('Dokumen Persyaratan')
        ->and($content)->toContain(e($document->title))
        ->and($content)->toContain('data-party="pria"')
        ->and($content)->toContain('data-party="wanita"');

    $this->actingAs($user)
        ->patchJson(route('dashboard.planner.checklists.toggle', $document), ['party' => 'pria'])
        ->assertSuccessful()
        ->assertJson(['is_completed_pria' => true, 'completed_items' => 1]);
});

test('QA-CHK-15: undangan lama yang sudah punya 40 preset tetap mendapat 18 dokumen persyaratan (backfill)', function () {
    $user = createChecklistUser();
    $invitation = createChecklistInvitation($user);

    foreach (WeddingChecklist::PRESETS as $code => $titles) {
        foreach ($titles as $title) {
            $invitation->checklists()->create([
                'category_code' => $code,
                'category_name' => WeddingChecklist::CATEGORIES[$code],
                'title' => $title,
                'is_completed' => false,
                'is_preset' => true,
                'is_document' => false,
            ]);
        }
    }

    expect($invitation->checklists()->count())->toBe(40);

    WeddingChecklist::initializePresets($invitation);

    expect($invitation->checklists()->count())->toBe(58)
        ->and($invitation->checklists()->where('is_document', true)->count())->toBe(18);

    WeddingChecklist::initializePresets($invitation);

    expect($invitation->checklists()->count())->toBe(58);
});

test('QA-SEC-01: checklist undangan lain tidak dapat diakses', function () {
    $owner = createChecklistUser();
    $intruder = createChecklistUser();

    $invitation = createChecklistInvitation($owner);
    WeddingChecklist::initializePresets($invitation);

    $item = WeddingChecklist::where('invitation_id', $invitation->id)->first();

    $this->actingAs($intruder)
        ->patchJson(route('dashboard.planner.checklists.toggle', $item))
        ->assertForbidden();

    $this->actingAs($intruder)
        ->patch(route('dashboard.planner.checklists.update', $item), [
            'category_code' => 'CATERING',
            'title' => 'Hacked',
        ])
        ->assertForbidden();

    $this->actingAs($intruder)
        ->delete(route('dashboard.planner.checklists.destroy', $item))
        ->assertForbidden();
});

test('QA-SEC-02: checklist custom item baru memiliki status belum selesai', function () {
    $user = createChecklistUser();
    createChecklistInvitation($user);

    $this->actingAs($user)
        ->post(route('dashboard.planner.checklists.store'), [
            'category_code' => 'OPERATIONS',
            'title' => 'Panitia seksi acara',
        ])
        ->assertRedirect(route('dashboard.planner.index'));

    $item = WeddingChecklist::where('title', 'Panitia seksi acara')->first();

    expect($item->is_completed)->toBeFalse();
});
