<?php

use App\Models\User;

test('api complete onboarding returns success status', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/complete-onboarding', [
        'tour_key' => 'editor_tour',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'tour_key' => 'editor_tour',
        ]);
});

test('invitation create page renders driver tour attributes and retrigger button', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard.invitations.create'));

    $response->assertStatus(200);
    $response->assertSee('id="btn-start-tour"', false);
    $response->assertSee('data-tour="select-theme"', false);
    $response->assertSee('data-tour="mempelai-info"', false);
    $response->assertSee('data-tour="event-schedule"', false);
    $response->assertSee('data-tour="layar-sapa-config"', false);
    $response->assertSee('data-tour="publish-btn"', false);
});
