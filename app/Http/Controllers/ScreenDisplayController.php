<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScreenCheckinsRequest;
use App\Models\Invitation;
use App\Services\WelcomeScreenData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ScreenDisplayController extends Controller
{
    public function showLiveScreen(Invitation $invitation, WelcomeScreenData $data)
    {
        Gate::authorize('view', $invitation);
        abort_unless($invitation->hasFeature('qr_checkin'), 403, 'Fitur QR Check-In diperlukan untuk Layar Sapa.');

        $screen = $invitation->screen()->firstOrCreate([], [
            'selected_theme' => 'minimal-clean',
            'show_wishes_wall' => true,
        ]);
        $invitation->setRelation('screen', $screen);
        $preset = $screen->preset;
        $preset = $preset?->is_active ? $preset : null;
        $screenData = $data->configuration($invitation);
        $screenData['checkin_since'] = now()->startOfSecond()->toIso8601String();
        $screenData['data_url'] = route('dashboard.welcome-screen.data', $invitation);
        $screenData['checkins_url'] = route('dashboard.welcome-screen.latest-checkin', $invitation);

        if (! $preset?->storage_path || ! Storage::disk('public')->exists($preset->storage_path.'/index.html')) {
            $firstEvent = $invitation->firstEvent();
            $themeHtmlContent = $preset?->html_content;

            return view('welcome-screen.index', compact('invitation', 'firstEvent', 'screen', 'themeHtmlContent', 'preset', 'screenData'));
        }

        $baseUrl = rtrim(asset('storage/'.$preset->storage_path), '/').'/';
        $rawHtml = Storage::disk('public')->get($preset->storage_path.'/index.html');
        $parsedHtml = preg_replace_callback(
            '/(href|src|poster)=["\'](?![a-z][a-z0-9+.-]*:|\/|#|\{)([^"\']+)["\']/i',
            fn (array $matches) => $matches[1].'="'.$baseUrl.$matches[2].'"',
            $rawHtml
        );
        $wishesHtml = collect($screenData['wishes'])->map(fn ($wish) => '<div class="wish-card"><h4 class="wish-sender">'.e($wish['name']).'</h4><p class="wish-message">'.e($wish['message']).'</p></div>'
        )->implode('');
        $jsonFlags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
        $html = strtr($parsedHtml, [
            '{judul_kustom}' => e($screenData['title']),
            '{nama_pengantin}' => e($screenData['names']),
            '{wish_list_items}' => $wishesHtml,
            '{gallery_json}' => json_encode($screenData['galleries'], $jsonFlags),
            '{bg_image_url}' => e($invitation->screen_background_image ? asset('storage/'.$invitation->screen_background_image) : ''),
            '{bg_video_url}' => e($invitation->screen_background_video ? asset('storage/'.$invitation->screen_background_video) : ''),
            '{background_type}' => $screenData['background']['type'],
            '{invitation_slug}' => e($invitation->slug),
            '{api_base_url}' => e(url('/')),
            '{show_wishes_wall}' => $screenData['show_wishes_wall'] ? 'true' : 'false',
            '{screen_data_url}' => e($screenData['data_url']),
            '{screen_checkins_url}' => e($screenData['checkins_url']),
        ]);
        $runtime = view('welcome-screen.runtime', compact('screenData'))->render();
        $html = preg_match('/<\/body>/i', $html)
            ? preg_replace_callback('/<\/body>/i', fn () => $runtime.'</body>', $html, 1)
            : $html.$runtime;

        return response($html)->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Cache-Control', 'no-store');
    }

    public function data(Invitation $invitation, WelcomeScreenData $data): JsonResponse
    {
        Gate::authorize('view', $invitation);
        abort_unless($invitation->hasFeature('qr_checkin'), 403);

        return response()->json($data->configuration($invitation))->header('Cache-Control', 'no-store');
    }

    public function publicData(string $slug, WelcomeScreenData $data): JsonResponse
    {
        return response()->json($data->configuration($this->publicInvitation($slug)))
            ->header('Cache-Control', 'no-store');
    }

    public function screenWishes(string $slug, WelcomeScreenData $data): JsonResponse
    {
        return response()->json($data->wishes($this->publicInvitation($slug)))
            ->header('Cache-Control', 'no-store');
    }

    public function screenGalleries(string $slug): JsonResponse
    {
        $galleries = $this->publicInvitation($slug)->screenGalleries()->orderBy('sort_order')->orderBy('id')
            ->get(['id', 'image_path', 'sort_order']);

        return response()->json($galleries->map(fn ($image) => [
            'id' => $image->id,
            'url' => asset('storage/'.$image->image_path),
            'sort_order' => $image->sort_order,
        ]))->header('Cache-Control', 'no-store');
    }

    public function screenCheckins(ScreenCheckinsRequest $request, string $slug, WelcomeScreenData $data): JsonResponse
    {
        return response()->json($data->checkins($this->publicInvitation($slug), $request->validated()))
            ->header('Cache-Control', 'no-store');
    }

    private function publicInvitation(string $slug): Invitation
    {
        $invitation = Invitation::active()->where('slug', $slug)->firstOrFail();
        abort_unless($invitation->hasFeature('qr_checkin'), 403);

        return $invitation;
    }
}
