<?php

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\QueryException;

function oneToOneInvitationPayload(array $overrides = []): array
{
    return array_merge([
        'title' => 'Budi & Siti Wedding',
        'bride_name' => 'Siti Rahayu',
        'groom_name' => 'Budi Santoso',
        'bride_nickname' => 'Siti',
        'groom_nickname' => 'Budi',
        'bride_father_name' => 'Bapak Siti',
        'bride_mother_name' => 'Ibu Siti',
        'groom_father_name' => 'Bapak Budi',
        'groom_mother_name' => 'Ibu Budi',
        'theme' => 'elegant',
    ], $overrides);
}

test('QA-001: user can create their single invitation via invitation.store', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('invitation.store'), oneToOneInvitationPayload());

    $invitation = Invitation::where('title', 'Budi & Siti Wedding')->first();

    expect($invitation)->not->toBeNull()
        ->and($invitation->user_id)->toBe($user->id);

    $response->assertRedirect(route('dashboard.invitations.show', $invitation));

    expect($user->hasInvitation())->toBeTrue();
});

test('timezone undangan hanya menerima zona waktu Indonesia yang didukung', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('invitation.store'), oneToOneInvitationPayload([
            'timezone' => 'Europe/London',
        ]))
        ->assertSessionHasErrors('timezone');

    expect($user->hasInvitation())->toBeFalse();
});

test('QA-002: user with an invitation is redirected away from the create page', function () {
    $user = User::factory()->create();
    Invitation::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('invitation.create'))
        ->assertRedirect(route('invitation.dashboard'));
});

test('QA-003: user cannot store a second invitation', function () {
    $user = User::factory()->create();
    Invitation::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->post(route('invitation.store'), oneToOneInvitationPayload())
        ->assertRedirect(route('invitation.dashboard'));

    expect(Invitation::count())->toBe(1);
});

test('QA-004: user_id is unique at the database level', function () {
    $user = User::factory()->create();
    Invitation::factory()->create(['user_id' => $user->id]);

    expect(fn () => Invitation::factory()->create(['user_id' => $user->id]))
        ->toThrow(QueryException::class);
});

test('QA-005: hasInvitation returns false for a user without an invitation', function () {
    $user = User::factory()->create();

    expect($user->hasInvitation())->toBeFalse();
});

test('QA-006: hasInvitation returns true once an invitation exists', function () {
    $user = User::factory()->create();
    Invitation::factory()->create(['user_id' => $user->id]);

    expect($user->hasInvitation())->toBeTrue();
});

test('QA-007: invitation() exposes the single invitation relation', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);

    expect($user->invitation)->not->toBeNull()
        ->and($user->invitation->is($invitation))->toBeTrue();
});

test('QA-008: user_id is not mass assignable (SR-03)', function () {
    expect((new Invitation)->getFillable())->not->toContain('user_id');
});

test('QA-009: creating via the invitation() relation assigns the owner', function () {
    $user = User::factory()->create();

    $invitation = $user->invitation()->create([
        'slug' => 'relation-created',
        'title' => 'Relation Wedding',
        'bride_name' => 'Ayu',
        'groom_name' => 'Bima',
        'theme' => 'elegant',
        'is_active' => true,
    ]);

    expect($invitation->user_id)->toBe($user->id);
});

test('QA-010: non-admin without invitation is redirected from dashboard to create', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('invitation.create'));
});

test('QA-011: non-admin with invitation is redirected from dashboard to their invitation', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('dashboard.invitations.show', $invitation));
});

test('QA-012: admin without invitation is redirected from dashboard to create', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertRedirect(route('invitation.create'));
});

test('QA-013: invitation.dashboard redirects to create when no invitation exists', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('invitation.dashboard'))
        ->assertRedirect(route('invitation.create'));
});

test('QA-014: invitation.dashboard redirects to the invitation page when one exists', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('invitation.dashboard'))
        ->assertRedirect(route('dashboard.invitations.show', $invitation));
});
