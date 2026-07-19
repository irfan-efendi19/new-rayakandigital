<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\ScreenGallery;
use App\Models\ScreenPreset;
use App\Services\ImageCompressionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class WelcomeScreenController extends Controller
{
    public function index(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            abort(403, 'Fitur QR Check-In diperlukan untuk Layar Sapa.');
        }

        $firstEvent = $invitation->firstEvent();
        $screenGalleries = $invitation->screenGalleries()->get();
        $screen = $invitation->screen()->firstOrCreate([], [
            'selected_theme' => 'minimal-clean',
            'show_wishes_wall' => true,
        ]);
        $screen->load('preset');
        $wishes = $screen->show_wishes_wall
            ? $invitation->wishes()->where('is_hidden', false)->latest()->get()
            : collect();

        $preset = $screen->preset;
        $themeHtmlContent = $preset?->html_content;

        return view('welcome-screen.index', compact('invitation', 'firstEvent', 'screenGalleries', 'screen', 'wishes', 'themeHtmlContent', 'preset'));
    }

    public function settings(Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            abort(403, 'Fitur QR Check-In diperlukan untuk Layar Sapa.');
        }

        $screenGalleries = $invitation->screenGalleries()->get();
        $screen = $invitation->screen()->firstOrCreate([], [
            'selected_theme' => 'minimal-clean',
            'show_wishes_wall' => true,
        ]);
        // PRD 2.1.2: kecualikan kolom besar `html_content` (longText) dari kueri massal.
        $presets = ScreenPreset::where('is_active', true)
            ->orderBy('name')
            ->select(['id', 'name', 'slug', 'description', 'thumbnail_image', 'is_active'])
            ->get();

        return view('dashboard.guestbook.settings', compact('invitation', 'screenGalleries', 'screen', 'presets'));
    }

    public function getLatestCheckIn(Request $request, Invitation $invitation): JsonResponse
    {
        Gate::authorize('view', $invitation);

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

        // PRD 2.1.1: hindari N+1. Hitung urutan check-in sekali via window function
        // (rank berdasarkan checked_in_at ascending) alih-alih query per tamu di dalam loop.
        $checkinOrderMap = $invitation->guests()
            ->where('attendance_status', 'hadir')
            ->whereNotNull('checked_in_at')
            ->orderBy('checked_in_at')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn ($id, $index) => [$id => $index + 1]);

        return response()->json([
            'success' => true,
            'guests' => $guests->map(function ($g) use ($checkinOrderMap) {
                return [
                    'id' => $g->id,
                    'name' => $g->name,
                    'checked_in_at' => $g->checked_in_at->toIso8601String(),
                    'checkin_order' => $checkinOrderMap->get($g->id, 0),
                ];
            }),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function updateSettings(Request $request, Invitation $invitation, ImageCompressionService $compressor)
    {
        Gate::authorize('update', $invitation);

        $activePresetSlugs = ScreenPreset::where('is_active', true)->pluck('slug');

        $validated = $request->validate([
            'screen_bride_names' => 'nullable|string|max:255',

            'screen_background_image' => 'nullable|image|max:10240',
            'screen_gallery_photos' => 'nullable|array',
            'screen_gallery_photos.*' => 'image|max:10240',
            'remove_background' => 'nullable|boolean',
            'selected_theme' => ['nullable', 'string', Rule::in($activePresetSlugs)],
            'custom_title' => 'nullable|string|max:255',
            'show_wishes_wall' => 'nullable',
        ]);

        $updateData = [
            'screen_bride_names' => $validated['screen_bride_names'] ?? null,
        ];

        // Handle background image removal
        if ($request->boolean('remove_background')) {
            if ($invitation->screen_background_image) {
                Storage::disk('public')->delete($invitation->screen_background_image);
            }
            $updateData['screen_background_image'] = null;
        }

        // Handle background image upload
        if ($request->hasFile('screen_background_image')) {
            // Delete old background if exists
            if ($invitation->screen_background_image) {
                Storage::disk('public')->delete($invitation->screen_background_image);
            }
            $updateData['screen_background_image'] = $compressor->compress(
                $request->file('screen_background_image'),
                'screen-bg/'.$invitation->id
            );
        }

        $invitation->update(array_merge($updateData, ['is_active' => true]));

        // Update or create screen configuration
        $screenData = [];
        if ($request->has('selected_theme')) {
            $screenData['selected_theme'] = $validated['selected_theme'] ?? 'minimal-clean';
        }
        if ($request->has('custom_title')) {
            $screenData['custom_title'] = $validated['custom_title'];
        }
        if ($request->has('selected_theme') || $request->has('custom_title') || $request->has('show_wishes_wall')) {
            $screenData['show_wishes_wall'] = $request->has('show_wishes_wall');
        }

        if (! empty($screenData)) {
            $invitation->screen()->updateOrCreate([], $screenData);
        }

        // Handle gallery photos upload
        if ($request->hasFile('screen_gallery_photos')) {
            $maxOrder = $invitation->screenGalleries()->max('sort_order') ?? -1;

            foreach ($request->file('screen_gallery_photos') as $photo) {
                $path = $compressor->compress($photo, 'screen-gallery/'.$invitation->id);
                $invitation->screenGalleries()->create([
                    'image_path' => $path,
                    'sort_order' => ++$maxOrder,
                ]);
            }
        }

        return back()->with('success', 'Pengaturan Layar Sapa berhasil disimpan.');
    }

    public function deleteGalleryImage(Request $request, Invitation $invitation, ScreenGallery $screenGallery)
    {
        Gate::authorize('update', $invitation);

        if ($screenGallery->invitation_id !== $invitation->id) {
            abort(403);
        }

        Storage::disk('public')->delete($screenGallery->image_path);
        $screenGallery->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Foto galeri berhasil dihapus.']);
        }

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}
