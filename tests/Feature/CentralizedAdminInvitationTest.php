<?php

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

test('regular user can only update their own invitation via policy', function () {
    $user1 = User::factory()->create(['role' => 'user']);
    $user2 = User::factory()->create(['role' => 'user']);

    $invitation = Invitation::factory()->create([
        'user_id' => $user1->id,
    ]);

    expect($user1->can('update', $invitation))->toBeTrue();
    expect($user2->can('update', $invitation))->toBeFalse();
});

test('admin can update any invitation via policy', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($admin->can('update', $invitation))->toBeTrue();
});

test('admin updating invitation creates an audit trail log', function () {
    $admin = User::factory()->create(['role' => 'admin', 'name' => 'Super Admin']);
    $user = User::factory()->create(['role' => 'user']);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
        'title' => 'Initial Title',
    ]);

    Log::shouldReceive('info')
        ->once()
        ->withArgs(fn ($message) => 
            str_contains($message, 'Admin (ID: ' . $admin->id) &&
            str_contains($message, 'updated Invitation (ID: ' . $invitation->id) &&
            str_contains($message, 'title')
        );

    $this->actingAs($admin);
    $invitation->update(['title' => 'Updated Title']);
});

test('admin deleting invitation creates an audit trail log', function () {
    $admin = User::factory()->create(['role' => 'admin', 'name' => 'Super Admin']);
    $user = User::factory()->create(['role' => 'user']);

    $invitation = Invitation::factory()->create([
        'user_id' => $user->id,
    ]);

    Log::shouldReceive('info')
        ->once()
        ->withArgs(fn ($message) => 
            str_contains($message, 'Admin (ID: ' . $admin->id) &&
            str_contains($message, 'deleted Invitation (ID: ' . $invitation->id)
        );

    $this->actingAs($admin);
    $invitation->delete();
});
