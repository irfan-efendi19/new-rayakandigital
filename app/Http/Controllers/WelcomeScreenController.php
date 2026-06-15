<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\ScreenGallery;
use App\Services\ImageCompressionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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

        return view('welcome-screen.index', compact('invitation', 'firstEvent', 'screenGalleries'));
    }

    public function settings(Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            abort(403, 'Fitur QR Check-In diperlukan untuk Layar Sapa.');
        }

        $screenGalleries = $invitation->screenGalleries()->get();

        return view('dashboard.guestbook.settings', compact('invitation', 'screenGalleries'));
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

        return response()->json([
            'success' => true,
            'guests' => $guests->map(function ($g) use ($invitation) {
                $checkinOrder = $invitation->guests()
                    ->where('attendance_status', 'hadir')
                    ->where('checked_in_at', '<=', $g->checked_in_at)
                    ->count();

                return [
                    'id' => $g->id,
                    'name' => $g->name,
                    'checked_in_at' => $g->checked_in_at->toIso8601String(),
                    'checkin_order' => $checkinOrder,
                ];
            }),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function updateSettings(Request $request, Invitation $invitation, ImageCompressionService $compressor)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'screen_bride_names' => 'nullable|string|max:255',
            'screen_overlay_opacity' => 'required|integer|min:0|max:100',
            'screen_background_image' => 'nullable|image|max:10240',
            'screen_gallery_photos' => 'nullable|array',
            'screen_gallery_photos.*' => 'image|max:10240',
            'remove_background' => 'nullable|boolean',
        ]);

        $updateData = [
            'screen_bride_names' => $validated['screen_bride_names'] ?? null,
            'screen_overlay_opacity' => $validated['screen_overlay_opacity'],
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

        $invitation->update($updateData);

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

    public function deleteGalleryImage(Invitation $invitation, ScreenGallery $screenGallery)
    {
        Gate::authorize('update', $invitation);

        if ($screenGallery->invitation_id !== $invitation->id) {
            abort(403);
        }

        Storage::disk('public')->delete($screenGallery->image_path);
        $screenGallery->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}
