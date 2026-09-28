<?php

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\PlatformFeature;
use App\Models\ScreenPreset;
use App\Models\User;
use App\Models\Wish;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $feature = PlatformFeature::create(['feature_key' => 'qr_checkin', 'feature_name' => 'QR Check-in']);
    $package = Package::create(['package_code' => 'platinum', 'package_name' => 'Platinum', 'price' => 250000]);
    $package->features()->attach($feature);
    $this->invitation = Invitation::factory()->create(['tier' => 'platinum']);
    $this->actingAs($this->invitation->user);
    $this->settingsUrl = route('dashboard.welcome-screen.settings.update', $this->invitation);
    $this->dataUrl = route('dashboard.welcome-screen.data', $this->invitation);
    $this->checkinsUrl = route('dashboard.welcome-screen.latest-checkin', $this->invitation);
});

test('display runs from standard CSS and JavaScript without a frontend build', function () {
    $this->invitation->screen()->create(['custom_title' => 'Selamat Datang', 'show_wishes_wall' => true]);
    $this->get(route('dashboard.welcome-screen.index', $this->invitation))
        ->assertSuccessful()->assertSee('data-welcome-screen', false)
        ->assertSee('welcome-screen/style.css')->assertSee('welcome-screen/modules.js')
        ->assertSee('welcome-screen/app.js')->assertDontSee('x-data=', false)
        ->assertDontSee('/build/assets/')->assertDontSee('@vite');
});

test('video backgrounds replace images and can be removed without activating the invitation', function () {
    Storage::disk('public')->put('screen-bg/old.webp', 'old');
    $this->invitation->update(['screen_background_image' => 'screen-bg/old.webp', 'is_active' => false]);
    $this->post($this->settingsUrl, ['screen_background_video' => UploadedFile::fake()->create('loop.mp4', 100, 'video/mp4')])
        ->assertSessionHasNoErrors()->assertRedirect();
    $invitation = $this->invitation->fresh();
    expect($invitation->screen_background_image)->toBeNull()->and($invitation->is_active)->toBeFalse();
    Storage::disk('public')->assertExists($invitation->screen_background_video);
    Storage::disk('public')->assertMissing('screen-bg/old.webp');
    $this->getJson($this->dataUrl)->assertOk()->assertJsonPath('background.type', 'video')
        ->assertJsonPath('background.url', asset('storage/'.$invitation->screen_background_video));
    $this->post($this->settingsUrl, ['remove_background' => '1'])->assertSessionHasNoErrors();
    Storage::disk('public')->assertMissing($invitation->screen_background_video);
    expect($invitation->fresh()->screen_background_video)->toBeNull();
});

test('uploading an image replaces an existing video', function () {
    Storage::disk('public')->put('screen-bg/old.mp4', 'old');
    $this->invitation->update(['screen_background_video' => 'screen-bg/old.mp4']);
    $this->post($this->settingsUrl, ['screen_background_image' => UploadedFile::fake()->image('photo.jpg')])
        ->assertSessionHasNoErrors();
    expect($this->invitation->fresh()->screen_background_video)->toBeNull();
    Storage::disk('public')->assertMissing('screen-bg/old.mp4');
    Storage::disk('public')->assertExists($this->invitation->fresh()->screen_background_image);
});

test('unsupported or oversized videos are rejected before replacing existing media', function (string $kind) {
    Storage::disk('public')->put('screen-bg/old.mp4', 'old');
    $this->invitation->update(['screen_background_video' => 'screen-bg/old.mp4']);
    $file = match ($kind) {
        'size' => UploadedFile::fake()->create('loop.mp4', 51201, 'video/mp4'),
        'extension' => UploadedFile::fake()->create('loop.php', 20, 'video/mp4'),
        default => UploadedFile::fake()->createWithContent('loop.mp4', '<?php echo "not a video";'),
    };
    $this->postJson($this->settingsUrl, ['screen_background_video' => $file])
        ->assertUnprocessable()->assertJsonValidationErrors('screen_background_video');
    Storage::disk('public')->assertExists('screen-bg/old.mp4');
    expect($this->invitation->fresh()->screen_background_video)->toBe('screen-bg/old.mp4');
})->with(['size', 'extension', 'content']);

test('image and video cannot be uploaded together', function () {
    $this->postJson($this->settingsUrl, [
        'screen_background_image' => UploadedFile::fake()->image('photo.png'),
        'screen_background_video' => UploadedFile::fake()->create('loop.webm', 100, 'video/webm'),
    ])->assertUnprocessable()->assertJsonValidationErrors(['screen_background_image', 'screen_background_video']);
});

test('live data reflects wish moderation deletion and wall visibility immediately', function () {
    $screen = $this->invitation->screen()->create(['show_wishes_wall' => true]);
    $visible = Wish::factory()->for($this->invitation)->create(['message' => 'Bahagia selalu']);
    Wish::factory()->for($this->invitation)->hidden()->create();
    $this->getJson($this->dataUrl)->assertOk()->assertJsonCount(1, 'wishes')->assertJsonPath('wishes.0.id', $visible->id);
    $visible->update(['is_hidden' => true]);
    $this->getJson($this->dataUrl)->assertJsonCount(0, 'wishes');
    $visible->update(['is_hidden' => false]);
    $screen->update(['show_wishes_wall' => false]);
    $this->getJson($this->dataUrl)->assertJsonPath('show_wishes_wall', false)->assertJsonCount(0, 'wishes');
    $this->getJson(route('api.screen-wishes', $this->invitation->slug))->assertExactJson([]);
    $screen->update(['show_wishes_wall' => true]);
    $visible->delete();
    $this->getJson($this->dataUrl)->assertJsonCount(0, 'wishes');
});

test('false checkbox values disable wishes and empty titles fall back to the default', function () {
    $this->invitation->screen()->create(['show_wishes_wall' => true, 'custom_title' => 'Previous']);
    $this->post($this->settingsUrl, ['show_wishes_wall' => '0', 'custom_title' => ''])
        ->assertSessionHasNoErrors();
    $this->getJson($this->dataUrl)->assertJsonPath('show_wishes_wall', false)
        ->assertJsonPath('title', 'Selamat Datang di Pernikahan');
});

test('live data keeps gallery order and reflects removal', function () {
    $later = $this->invitation->screenGalleries()->create(['image_path' => 'later.jpg', 'sort_order' => 10]);
    $first = $this->invitation->screenGalleries()->create(['image_path' => 'first.jpg', 'sort_order' => 0]);
    $this->getJson($this->dataUrl)->assertJsonPath('galleries.0.id', $first->id)->assertJsonPath('galleries.1.id', $later->id);
    $this->deleteJson(route('dashboard.welcome-screen.gallery.destroy', [$this->invitation, $first]))->assertOk();
    $this->getJson($this->dataUrl)->assertJsonCount(1, 'galleries')->assertJsonPath('galleries.0.id', $later->id);
});

test('check-in bursts are paginated chronologically including ties and late arrivals', function () {
    $at = now()->subSecond()->startOfSecond();
    $late = Guest::factory()->for($this->invitation)->create();
    $guests = Guest::factory()->for($this->invitation)->hadir()->count(105)->create(['checked_in_at' => $at]);
    Guest::factory()->for($this->invitation)->hadir()->create(['checked_in_at' => null]);
    Guest::factory()->hadir()->create(['checked_in_at' => $at]);
    $url = fn (array $cursor) => $this->checkinsUrl.'?'.http_build_query($cursor);
    $first = $this->getJson($url(['since' => $at->toIso8601String(), 'after_id' => 0]))
        ->assertOk()->assertJsonCount(100, 'guests')->assertJsonPath('has_more', true);
    $second = $this->getJson($url($first->json('next_cursor')))
        ->assertOk()->assertJsonCount(5, 'guests')->assertJsonPath('has_more', false);
    expect(array_merge(array_column($first->json('guests'), 'id'), array_column($second->json('guests'), 'id')))
        ->toBe($guests->pluck('id')->all());
    $late->update(['attendance_status' => 'hadir', 'checked_in_at' => $at]);
    $this->getJson($url(['since' => $at->toIso8601String(), 'after_id' => 0]))
        ->assertJsonPath('guests.0.id', $late->id);
});

test('scanner check-in appears in the incremental feed without replaying older arrivals', function () {
    $this->travelTo(now()->startOfSecond());
    Guest::factory()->for($this->invitation)->hadir()->create(['checked_in_at' => now()->subMinute()]);
    $guest = Guest::factory()->for($this->invitation)->create();
    $since = now()->toIso8601String();
    $this->postJson(route('dashboard.invitations.guestbook.checkin', $this->invitation), ['qr_code_token' => $guest->qr_code_token])
        ->assertOk()->assertJsonPath('success', true);
    $this->getJson($this->checkinsUrl.'?'.http_build_query(['since' => $since]))
        ->assertJsonCount(1, 'guests')->assertJsonPath('guests.0.id', $guest->id);
});

test('check-in cursor rejects malformed input', function (array $cursor) {
    $this->getJson($this->checkinsUrl.'?'.http_build_query($cursor))->assertUnprocessable();
})->with([[['since' => 'not a date']], [['since' => ['bad']]], [['after_id' => -1]], [['after_id' => 10]]]);

test('screen endpoints and mutations enforce ownership and package access', function (string $access) {
    if ($access === 'other owner') {
        $this->actingAs(User::factory()->create());
    } else {
        $this->invitation->update(['tier' => 'free']);
    }
    $this->getJson($this->dataUrl)->assertForbidden();
    $this->getJson($this->checkinsUrl)->assertForbidden();
    $this->postJson($this->settingsUrl, ['custom_title' => 'Unauthorized'])->assertForbidden();
})->with(['other owner', 'no feature']);

test('public display data excludes inactive invitations', function () {
    $this->invitation->update(['is_active' => false]);
    $this->getJson(route('api.screen-data', $this->invitation->slug))->assertNotFound();
});

test('preset variables support video and do not corrupt root paths or dynamic media placeholders', function () {
    $preset = ScreenPreset::create(['name' => 'Custom', 'slug' => 'custom', 'storage_path' => 'screen-templates/custom', 'is_active' => true]);
    Storage::disk('public')->put($preset->storage_path.'/index.html', '<html><head><link href="css/style.css"><link href="/shared.css"></head><body data-welcome-screen><video src="{bg_video_url}"></video><img src="{bg_image_url}"><h1>{nama_pengantin}</h1>{wish_list_items}</body></html>');
    $this->invitation->screen()->create(['selected_theme' => 'custom', 'show_wishes_wall' => true]);
    $this->invitation->update(['screen_background_video' => 'screen-bg/loop.mp4', 'screen_bride_names' => '</script><script>alert(1)</script>']);
    $wish = Wish::factory()->for($this->invitation)->create(['message' => 'Visible first']);
    $url = route('dashboard.welcome-screen.index', $this->invitation);
    $this->get($url)->assertOk()->assertSee('href="/shared.css"', false)
        ->assertSee(asset('storage/screen-templates/custom/css/style.css'), false)
        ->assertSee('src="'.asset('storage/screen-bg/loop.mp4').'"', false)
        ->assertDontSee('<script>alert(1)</script>', false)->assertSee('welcome-screen-data', false)->assertSee('Visible first');
    $wish->update(['is_hidden' => true]);
    $this->get($url)->assertDontSee('Visible first');
});
