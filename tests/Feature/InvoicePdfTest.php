<?php

use App\Models\Invitation;
use App\Models\User;

test('invitation owner can download a valid invoice pdf', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->for($user)->create([
        'slug' => 'andi-dan-sari',
        'title' => 'Pernikahan Andi & Sari',
        'bride_name' => 'Sari',
        'groom_name' => 'Andi',
        'created_at' => '2026-08-27 09:00:00',
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.invitations.invoice-pdf', $invitation));

    $response->assertSuccessful()
        ->assertHeader('content-type', 'application/pdf');

    expect($response->headers->get('content-disposition'))
        ->toContain('Invoice-RD-20260827-'.str_pad((string) $invitation->id, 4, '0', STR_PAD_LEFT))
        ->and(substr($response->getContent(), 0, 4))->toBe('%PDF');
});

test('user cannot download another users invoice', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $invitation = Invitation::factory()->for($owner)->create();

    $this->actingAs($otherUser)
        ->get(route('dashboard.invitations.invoice-pdf', $invitation))
        ->assertForbidden();
});
