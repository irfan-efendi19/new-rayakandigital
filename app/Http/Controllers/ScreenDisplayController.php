<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationScreen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

/**
 * ScreenDisplayController — Runtime HTML Parser untuk Modul Layar Sapa (PRD §2).
 *
 * Controller ini bekerja secara pasif: ia membaca file index.html mentah dari storage,
 * mengganti path relatif ke URL absolut, lalu menginjeksi placeholder {variable}
 * dengan data dinamis dari database. Tidak ada pre-processing saat upload.
 */
class ScreenDisplayController extends Controller
{
    public function showLiveScreen(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            abort(403, 'Fitur QR Check-In diperlukan untuk Layar Sapa.');
        }

        /** @var InvitationScreen|null $settings */
        $settings = InvitationScreen::with('screenPreset')
            ->where('invitation_id', $invitation->id)
            ->first();

        $preset = $settings?->screenPreset;

        // Render legacy view if preset has no storage_path or ZIP was not uploaded/extracted
        if (
            ! $preset ||
            ! $preset->is_active ||
            ! $preset->storage_path ||
            ! Storage::disk('public')->exists($preset->storage_path.'/index.html')
        ) {
            $firstEvent = $invitation->firstEvent();
            $screenGalleries = $invitation->screenGalleries()->get();
            $screen = $settings ?? $invitation->screen()->firstOrCreate([], [
                'selected_theme' => 'minimal-clean',
                'show_wishes_wall' => true,
            ]);
            $wishes = $screen->show_wishes_wall
                ? $invitation->wishes()->where('is_hidden', false)->latest()->get()
                : collect();

            $themeHtmlContent = $preset?->html_content;

            return view('welcome-screen.index', compact('invitation', 'firstEvent', 'screenGalleries', 'screen', 'wishes', 'themeHtmlContent', 'preset'));
        }

        // PRD §2: Eksekusi dari Cache untuk memastikan TTFB cepat (< 80ms)
        $cacheKey = "live_screen_output_{$invitation->id}";

        $htmlOutput = Cache::remember($cacheKey, now()->addHours(2), function () use ($invitation, $settings, $preset) {
            $folderPath = $preset->storage_path;
            $baseUrl = rtrim(asset('storage/'.$folderPath), '/').'/';

            // PRD §2 step 2: Baca isi Pure HTML mentah buatan pengembang lokal
            $rawHtml = Storage::disk('public')->get($folderPath.'/index.html');

            // PRD §2 step 3: AUTOMATION PARSER — ubah path relatif ke Absolute Storage URL
            $parsedHtml = preg_replace_callback(
                '/(href|src)=["\'](?!http|https:\/\/|\/\/|data:|mailto:|tel:|#)([^"\']+)["\']/i',
                function (array $matches) use ($baseUrl) {
                    $attribute = $matches[1];
                    $relativePath = ltrim($matches[2], '/');

                    return $attribute.'="'.$baseUrl.$relativePath.'"';
                },
                $rawHtml
            );

            // PRD §2 step 4: Generate ucapan tamu (Opsi A — CSS injection)
            $showWishesWall = $settings?->show_wishes_wall ?? true;
            $wishes = $showWishesWall
                ? $invitation->wishes()->where('is_hidden', false)->latest()->take(12)->get()
                : collect();

            $wishesHtml = '';
            foreach ($wishes as $wish) {
                $wishesHtml .= "
                    <div class='wish-card'>
                        <h4 class='wish-sender'>".e($wish->guest_name)."</h4>
                        <p class='wish-message'>\"".e($wish->message).'"</p>
                    </div>
                ';
            }

            // Generate gallery slideshow data sebagai JSON untuk JS
            $galleries = $invitation->screenGalleries()->orderBy('sort_order')->get();
            $galleryJson = $galleries->map(fn ($g) => [
                'id' => $g->id,
                'url' => asset('storage/'.$g->image_path),
            ])->toJson();

            // Background image URL
            $bgImageUrl = $invitation->screen_background_image
                ? asset('storage/'.$invitation->screen_background_image)
                : '';

            // Nama pengantin: prioritas screen_bride_names > couple_name > title
            $coupleDisplayName = $invitation->screen_bride_names
                ?: ($invitation->couple_name ?? $invitation->title ?? 'Pasangan Mempelai');

            // URL endpoint API publik untuk JS polling
            $apiBaseUrl = url('/');

            // PRD §2 step 5: INJEKSI VARIABEL — substitusi data ke bracket placeholder
            return str_replace(
                [
                    '{judul_kustom}',
                    '{nama_pengantin}',
                    '{wish_list_items}',
                    '{gallery_json}',
                    '{bg_image_url}',
                    '{invitation_slug}',
                    '{api_base_url}',
                    '{show_wishes_wall}',
                ],
                [
                    e($settings?->custom_title ?? 'Selamat Datang'),
                    e($coupleDisplayName),
                    $wishesHtml,
                    $galleryJson,
                    $bgImageUrl,
                    $invitation->slug,
                    $apiBaseUrl,
                    $showWishesWall ? 'true' : 'false',
                ],
                $parsedHtml
            );
        });

        // PRD §2 step 6: Kembalikan respons sebagai Pure HTML
        return response($htmlOutput, 200)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * PRD §3 Opsi B: REST API endpoint untuk JS Polling / Pure JS Custom Motion.
     */
    public function screenWishes(string $slug): JsonResponse
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $wishes = $invitation->wishes()
            ->where('is_hidden', false)
            ->latest()
            ->take(50)
            ->get(['id', 'guest_name', 'message', 'created_at']);

        return response()->json($wishes->map(fn ($wish) => [
            'id' => $wish->id,
            'name' => $wish->guest_name,
            'message' => $wish->message,
            'created_at' => $wish->created_at->toIso8601String(),
        ]));
    }

    /**
     * API publik: Data galeri slideshow untuk template JS.
     */
    public function screenGalleries(string $slug): JsonResponse
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $galleries = $invitation->screenGalleries()
            ->orderBy('sort_order')
            ->get(['id', 'image_path', 'sort_order']);

        return response()->json($galleries->map(fn ($g) => [
            'id' => $g->id,
            'url' => asset('storage/'.$g->image_path),
            'sort_order' => $g->sort_order,
        ]));
    }

    /**
     * API publik: Data check-in tamu terbaru untuk template JS (tanpa autentikasi).
     */
    public function screenCheckins(Request $request, string $slug): JsonResponse
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $since = $request->query('since');

        $query = $invitation->guests()
            ->where('attendance_status', 'hadir')
            ->orderByDesc('checked_in_at')
            ->limit(10);

        if ($since) {
            try {
                $sinceDate = Carbon::parse($since);
                $query->where('checked_in_at', '>', $sinceDate);
            } catch (\Exception $e) {
                // Ignore parsing errors
            }
        }

        $guests = $query->get(['id', 'name', 'checked_in_at']);

        // Hitung urutan check-in
        $checkinOrderMap = $invitation->guests()
            ->where('attendance_status', 'hadir')
            ->whereNotNull('checked_in_at')
            ->orderBy('checked_in_at')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn ($id, $index) => [$id => $index + 1]);

        return response()->json([
            'success' => true,
            'guests' => $guests->map(fn ($g) => [
                'id' => $g->id,
                'name' => $g->name,
                'checked_in_at' => $g->checked_in_at?->toIso8601String(),
                'checkin_order' => $checkinOrderMap->get($g->id, 0),
            ]),
            'server_time' => now()->toIso8601String(),
        ]);
    }
}
