<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScreenCheckinsRequest;
use App\Http\Requests\UpdateWelcomeScreenRequest;
use App\Models\Invitation;
use App\Models\ScreenGallery;
use App\Models\ScreenPreset;
use App\Services\ImageCompressionService;
use App\Services\WelcomeScreenData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class WelcomeScreenController extends Controller
{
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

    public function getLatestCheckIn(ScreenCheckinsRequest $request, Invitation $invitation, WelcomeScreenData $data): JsonResponse
    {
        Gate::authorize('view', $invitation);
        abort_unless($invitation->hasFeature('qr_checkin'), 403);

        return response()->json($data->checkins($invitation, $request->validated()))
            ->header('Cache-Control', 'no-store');
    }

    public function updateSettings(UpdateWelcomeScreenRequest $request, Invitation $invitation, ImageCompressionService $compressor)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validated();
        $updateData = [];
        if (array_key_exists('screen_bride_names', $validated)) {
            $updateData['screen_bride_names'] = $validated['screen_bride_names'];
        }

        $oldBackgrounds = array_filter([$invitation->screen_background_image, $invitation->screen_background_video]);
        if ($request->boolean('remove_background') || $request->hasFile('screen_background_image') || $request->hasFile('screen_background_video')) {
            $updateData['screen_background_image'] = null;
            $updateData['screen_background_video'] = null;
        }
        if ($request->hasFile('screen_background_image')) {
            $updateData['screen_background_image'] = $compressor->compress(
                $validated['screen_background_image'], 'screen-bg/'.$invitation->id
            );
        }
        if ($request->hasFile('screen_background_video')) {
            $updateData['screen_background_video'] = $validated['screen_background_video']
                ->store('screen-bg/'.$invitation->id, 'public');
            abort_if($updateData['screen_background_video'] === false, 500, 'Video gagal disimpan.');
        }

        $invitation->update($updateData);
        if (array_key_exists('screen_background_image', $updateData)) {
            Storage::disk('public')->delete($oldBackgrounds);
        }

        // Update or create screen configuration
        $screenData = [];
        if ($request->has('selected_theme')) {
            $screenData['selected_theme'] = $validated['selected_theme'] ?? 'minimal-clean';
        }
        if ($request->has('custom_title')) {
            $screenData['custom_title'] = $validated['custom_title'];
        }
        if ($request->has('selected_theme') || $request->has('custom_title') || $request->has('show_wishes_wall')) {
            $screenData['show_wishes_wall'] = $request->boolean('show_wishes_wall');
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

        // Clear welcome screen output cache
        Cache::forget("live_screen_output_{$invitation->id}");

        return back()->with('success', 'Pengaturan Layar Sapa berhasil disimpan.');
    }

    public function deleteGalleryImage(Request $request, Invitation $invitation, ScreenGallery $screenGallery)
    {
        Gate::authorize('update', $invitation);

        abort_unless($invitation->hasFeature('qr_checkin'), 403);

        if ($screenGallery->invitation_id !== $invitation->id) {
            abort(403);
        }

        Storage::disk('public')->delete($screenGallery->image_path);
        $screenGallery->delete();

        // Clear welcome screen output cache
        Cache::forget("live_screen_output_{$invitation->id}");

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Foto galeri berhasil dihapus.']);
        }

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}
