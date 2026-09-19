<?php

use App\Auth\GoogleProvider;
use App\Models\Invitation;
use App\Models\Theme;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Facades\Socialite;

beforeEach(function () {
    config([
        'services.google.client_id' => 'test-client',
        'services.google.client_secret' => 'test-secret',
        'services.google.redirect' => route('google.callback'),
        'themes.default_theme_id' => null,
    ]);

    expect(Socialite::driver('google'))->toBeInstanceOf(GoogleProvider::class);

    $this->accessToken = 'test-access-'.str_repeat('a', 2048);
    $this->refreshToken = 'test-refresh-'.str_repeat('r', 1024);
    $this->googleResponses = new MockHandler([
        new Response(200, [], json_encode([
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken,
            'expires_in' => 3600,
        ])),
        new Response(200, [], json_encode([
            'sub' => 'google-test-user',
            'name' => 'Google User',
            'email' => 'google@example.com',
            'email_verified' => true,
            'picture' => 'https://example.com/avatar.jpg',
        ])),
    ]);

    $client = new Client(['handler' => HandlerStack::create($this->googleResponses)]);
    Socialite::extend('google', fn ($app) => Socialite::buildProvider(
        GoogleProvider::class, $app['config']['services.google'],
    )->setHttpClient($client));
    Socialite::forgetDrivers();

    $this->defaultTheme = Theme::create([
        'name' => 'Elegant Rose', 'view_path' => 'themes.elegant', 'is_active' => true,
    ]);
    $this->selectedTheme = Theme::create([
        'name' => 'Modern Dark', 'view_path' => 'themes.modern', 'is_active' => true,
    ]);
});

function beginGoogleThemeLogin(array $parameters = []): string
{
    Socialite::forgetDrivers();
    $response = test()->get(route('google.redirect', $parameters));
    $response->assertRedirect();
    $url = $response->headers->get('Location');
    expect(parse_url($url, PHP_URL_HOST))->toBe('accounts.google.com');
    parse_str(parse_url($url, PHP_URL_QUERY), $query);

    return $query['state'];
}

function completeGoogleThemeLogin(mixed $state, array $parameters = []): TestResponse
{
    Socialite::forgetDrivers();

    return test()->get(route('google.callback', array_merge([
        'state' => $state, 'code' => 'test-code',
    ], $parameters)));
}

test('theme links survive registration and login pages', function (string $page, string $key, mixed $value) {
    $parameters = [$key => $key === 'theme_id' ? $this->selectedTheme->id : $value];

    $this->get(route($page, $parameters))
        ->assertSuccessful()
        ->assertSee(route('google.redirect', $parameters))
        ->assertSee(route($page === 'login' ? 'register' : 'login', $parameters));
})->with(['register', 'login'])->with([
    ['theme', 'modern'], ['theme_id', null],
]);

test('Google token storage supports long nullable tokens', function () {
    $columns = collect(Schema::getColumns('users'))->keyBy('name');

    foreach (['google_token', 'google_refresh_token'] as $column) {
        expect($columns[$column]['type_name'])->toBe('text')
            ->and($columns[$column]['nullable'])->toBeTrue();
    }
});

test('Google token migration preserves existing credentials', function () {
    $user = User::factory()->create([
        'google_token' => 'existing-access-token',
        'google_refresh_token' => null,
    ]);
    $migration = require database_path('migrations/2026_09_19_232314_widen_google_tokens_on_users_table.php');

    $migration->down();
    $migration->up();

    $user->refresh();
    expect($user->google_token)->toBe('existing-access-token')
        ->and($user->google_refresh_token)->toBeNull();
});

test('Google token rollback refuses to truncate stored credentials', function (string $column) {
    $token = 'test-'.str_repeat('t', 512);
    $user = User::factory()->create([$column => $token]);
    $migration = require database_path('migrations/2026_09_19_232314_widen_google_tokens_on_users_table.php');

    expect(fn () => $migration->down())->toThrow(RuntimeException::class, 'Cannot shrink Google token columns');
    expect($user->fresh()->getAttribute($column))->toBe($token)
        ->and(Schema::getColumnType('users', $column))->toBe('text');
})->with(['google_token', 'google_refresh_token']);

test('landing page theme survives real OAuth state validation and invitation creation', function (string $key) {
    $parameters = [$key => $key === 'theme_id' ? $this->selectedTheme->id : 'modern'];
    $this->get(route('home'))->assertSuccessful()->assertSee(route('register', ['theme' => 'modern']));

    $state = beginGoogleThemeLogin($parameters);
    $payload = json_decode(Crypt::decryptString($state), true);
    expect($payload['theme_id'])->toBe($this->selectedTheme->id)
        ->and($payload['nonce'])->toHaveLength(40);
    expect(session('state'))->toBe($state);

    completeGoogleThemeLogin($state)->assertRedirect(route('dashboard', absolute: false))
        ->assertSessionMissing('state');
    $user = User::where('email', 'google@example.com')->firstOrFail();
    $this->assertAuthenticatedAs($user);
    expect($user->theme_id)->toBe($this->selectedTheme->id)
        ->and($user->theme->is($this->selectedTheme))->toBeTrue()
        ->and($user->google_token)->toBe($this->accessToken)
        ->and($user->google_refresh_token)->toBe($this->refreshToken);

    $this->get(route('dashboard'))->assertRedirect(route('invitation.create'));
    $this->get(route('invitation.create'))->assertSuccessful()
        ->assertViewHas('selectedTheme', 'modern')
        ->assertViewHas('hasPredefinedTheme', false)
        ->assertSee('data-selected-theme="modern"', false);

    $this->post(route('invitation.store'), [
        'title' => 'Our Wedding', 'bride_name' => 'Bride', 'groom_name' => 'Groom',
        'bride_father_name' => 'Father', 'bride_mother_name' => 'Mother',
        'groom_father_name' => 'Father', 'groom_mother_name' => 'Mother', 'theme' => 'modern',
    ])->assertSessionHasNoErrors()->assertRedirect();

    expect($user->invitation()->firstOrFail()->theme)->toBe('modern');
})->with(['theme', 'theme_id']);

test('missing or unavailable themes use the configured default', function (array $parameters) {
    config(['themes.default_theme_id' => $this->selectedTheme->id]);
    completeGoogleThemeLogin(beginGoogleThemeLogin($parameters))->assertSessionHasNoErrors();

    expect(User::sole()->theme_id)->toBe($this->selectedTheme->id);
})->with([
    'no selection' => [[]],
    'empty selection' => [['theme_id' => '']],
    'unknown id' => [['theme_id' => 999999]],
    'unknown slug' => [['theme' => 'missing']],
]);

test('default falls back to an active theme or an empty catalog', function (string $availability) {
    config(['themes.default_theme_id' => 999999]);
    if ($availability !== 'elegant') {
        $this->defaultTheme->update(['is_active' => false]);
    }
    if ($availability === 'empty') {
        $this->selectedTheme->update(['is_active' => false]);
    }

    completeGoogleThemeLogin(beginGoogleThemeLogin())->assertSessionHasNoErrors();
    expect(User::sole()->theme_id)->toBe(match ($availability) {
        'elegant' => $this->defaultTheme->id,
        'first active' => $this->selectedTheme->id,
        'empty' => null,
    });
})->with(['elegant', 'first active', 'empty']);

test('theme availability is rechecked after returning from Google', function (string $change) {
    $state = beginGoogleThemeLogin(['theme_id' => $this->selectedTheme->id]);
    if ($change === 'deleted') {
        $this->selectedTheme->delete();
    } else {
        $this->selectedTheme->update(['is_active' => false]);
    }

    completeGoogleThemeLogin($state)->assertSessionHasNoErrors();
    expect(User::sole()->theme_id)->toBe($this->defaultTheme->id);
})->with(['deleted', 'inactive']);

test('malformed theme parameters fail validation before OAuth', function (array $parameters, string $field) {
    $this->getJson(route('google.redirect', $parameters))
        ->assertUnprocessable()->assertJsonValidationErrors($field);
    expect($this->googleResponses->count())->toBe(2);
})->with([
    [['theme_id' => ['1']], 'theme_id'],
    [['theme_id' => 'not-an-id'], 'theme_id'],
    [['theme_id' => -1], 'theme_id'],
    [['theme' => ['modern']], 'theme'],
]);

test('invalid OAuth state cannot authenticate or persist a theme', function (string $scenario) {
    $state = beginGoogleThemeLogin(['theme_id' => $this->selectedTheme->id]);
    $callbackState = $state;
    if ($scenario === 'tampered') {
        $payload = json_decode(Crypt::decryptString($state), true);
        $payload['theme_id'] = $this->defaultTheme->id;
        $callbackState = Crypt::encryptString(json_encode($payload));
    } elseif ($scenario === 'other session') {
        session()->forget('state');
    } elseif ($scenario === 'missing') {
        $callbackState = null;
    } elseif ($scenario === 'array') {
        $callbackState = [$state];
    } elseif ($scenario === 'superseded') {
        beginGoogleThemeLogin();
    }

    completeGoogleThemeLogin($callbackState)
        ->assertRedirect(route('login'))->assertSessionHasErrors('email')->assertSessionMissing('state');
    $this->assertGuest();
    expect(User::count())->toBe(0)->and($this->googleResponses->count())->toBe(2);
})->with(['tampered', 'other session', 'missing', 'array', 'superseded']);

test('Google cancellation clears state without creating a user', function () {
    $state = beginGoogleThemeLogin(['theme' => 'modern']);
    completeGoogleThemeLogin($state, ['error' => 'access_denied'])
        ->assertRedirect(route('login'))->assertSessionHasErrors('email')->assertSessionMissing('state');
    $this->assertGuest();
    expect(User::count())->toBe(0)->and($this->googleResponses->count())->toBe(2);

    $newState = beginGoogleThemeLogin();
    expect(json_decode(Crypt::decryptString($newState), true)['theme_id'])->toBeNull();
});

test('failed Google token exchange clears state without persisting a theme', function () {
    $this->googleResponses->reset();
    $this->googleResponses->append(new Response(400, [], '{"error":"invalid_grant"}'));
    completeGoogleThemeLogin(beginGoogleThemeLogin(['theme' => 'modern']))
        ->assertRedirect(route('login'))->assertSessionHasErrors('email')->assertSessionMissing('state');
    $this->assertGuest();
    expect(User::count())->toBe(0);
});

test('a successful callback cannot be replayed', function () {
    $state = beginGoogleThemeLogin(['theme' => 'modern']);
    completeGoogleThemeLogin($state)->assertSessionHasNoErrors();
    Auth::logout();

    completeGoogleThemeLogin($state)->assertRedirect(route('login'))->assertSessionHasErrors('email');
    $this->assertGuest();
    expect(User::count())->toBe(1);
});

test('untrusted callback query parameters cannot replace the selected theme', function () {
    $state = beginGoogleThemeLogin(['theme' => 'modern']);
    completeGoogleThemeLogin($state, ['theme_id' => $this->defaultTheme->id])->assertSessionHasNoErrors();
    expect(User::sole()->theme_id)->toBe($this->selectedTheme->id);
});

test('existing invitations and their profile preferences are preserved', function (bool $alreadyLinked) {
    $user = User::factory()->create([
        'email' => 'google@example.com', 'theme_id' => $this->defaultTheme->id,
        'google_id' => $alreadyLinked ? 'google-test-user' : null,
    ]);
    $invitation = Invitation::factory()->for($user)->create(['theme' => 'elegant']);

    completeGoogleThemeLogin(beginGoogleThemeLogin(['theme' => 'modern']))->assertSessionHasNoErrors();
    $this->assertAuthenticatedAs($user);
    expect($user->fresh()->theme_id)->toBe($this->defaultTheme->id)
        ->and($invitation->fresh()->theme)->toBe('elegant');
})->with([true, false]);

test('existing users without invitations can continue with a newly selected theme', function () {
    $user = User::factory()->create(['email' => 'google@example.com']);
    completeGoogleThemeLogin(beginGoogleThemeLogin(['theme' => 'modern']))->assertSessionHasNoErrors();
    $this->assertAuthenticatedAs($user);
    $user->refresh();
    expect($user->theme_id)->toBe($this->selectedTheme->id)
        ->and($user->google_id)->toBe('google-test-user')
        ->and($user->google_token)->toBe($this->accessToken)
        ->and($user->google_refresh_token)->toBe($this->refreshToken);
});

test('login without a new selection preserves a saved preference and intended URL', function () {
    $user = User::factory()->create(['email' => 'google@example.com', 'theme_id' => $this->selectedTheme->id]);
    $this->withSession(['url.intended' => route('profile.edit')]);
    completeGoogleThemeLogin(beginGoogleThemeLogin())->assertRedirect(route('profile.edit'));
    expect($user->fresh()->theme_id)->toBe($this->selectedTheme->id);

    $this->get(route('invitation.create'))->assertViewHas('selectedTheme', 'modern');
});

test('an explicit active theme overrides the saved preference in the creation form', function () {
    $user = User::factory()->create(['theme_id' => $this->selectedTheme->id]);
    $this->actingAs($user)->get(route('invitation.create', ['theme' => 'elegant']))
        ->assertSuccessful()->assertViewHas('selectedTheme', 'elegant');
});

test('an inactive saved theme does not leave a hidden invalid selection', function () {
    $user = User::factory()->create(['theme_id' => $this->selectedTheme->id]);
    $this->selectedTheme->update(['is_active' => false]);
    $this->actingAs($user)->get(route('invitation.create'))
        ->assertSuccessful()->assertViewHas('selectedTheme', '')->assertViewHas('hasPredefinedTheme', false);
});

test('deleting a theme clears the profile preference without deleting the user', function () {
    $user = User::factory()->create(['theme_id' => $this->selectedTheme->id]);
    $this->selectedTheme->delete();
    expect($user->fresh()->theme_id)->toBeNull();
});
