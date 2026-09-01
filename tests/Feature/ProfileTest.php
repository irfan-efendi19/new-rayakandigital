<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response
        ->assertOk()
        ->assertSee('Perbarui Kata Sandi')
        ->assertSee('name="password"', false)
        ->assertDontSee('name="email_confirmation"', false);
});

test('password update form is hidden for google users', function () {
    $user = User::factory()->create([
        'google_id' => 'google-user-id',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response
        ->assertOk()
        ->assertDontSee('Perbarui Kata Sandi')
        ->assertSee('name="email_confirmation"', false)
        ->assertDontSee('name="password"', false);
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertModelMissing($user);
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertModelExists($user);
});

test('google user can delete their account by confirming their email', function () {
    $user = User::factory()->create([
        'google_id' => 'google-delete-user-id',
    ]);

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'email_confirmation' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertModelMissing($user);
});

test('google user must confirm the correct email to delete their account', function () {
    $user = User::factory()->create([
        'google_id' => 'google-delete-user-id',
    ]);

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'email_confirmation' => 'wrong@example.com',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'email_confirmation')
        ->assertRedirect('/profile');

    $this->assertAuthenticatedAs($user);
    $this->assertModelExists($user);
});

test('google user cannot use a password instead of email confirmation to delete their account', function () {
    $user = User::factory()->create([
        'google_id' => 'google-delete-user-id',
    ]);

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'email_confirmation')
        ->assertRedirect('/profile');

    $this->assertAuthenticatedAs($user);
    $this->assertModelExists($user);
});

test('local user cannot use email confirmation instead of a password to delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'email_confirmation' => $user->email,
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertAuthenticatedAs($user);
    $this->assertModelExists($user);
});
