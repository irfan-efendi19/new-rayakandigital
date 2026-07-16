<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function update(Request $request, Invitation $invitation, ImageCompressionService $compressor)
    {
        Gate::authorize('update', $invitation);

        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image',
        ]);

        $currentPhotos = $invitation->gallery_photos ?? [];
        $maxPhotos = $invitation->maxGalleryPhotos();

        if (count($currentPhotos) + count($request->file('photos')) > $maxPhotos) {
            return back()->with('error', 'Batas maksimal foto untuk paket Anda adalah ' . $maxPhotos . ' foto.');
        }

        foreach ($request->file('photos') as $photo) {
            $path = $compressor->compress($photo, 'gallery/' . $invitation->id);
            $currentPhotos[] = $path;
        }

        $invitation->update(['gallery_photos' => $currentPhotos, 'is_active' => true]);

        return back()->with('success', 'Foto berhasil diunggah.');
    }

    public function destroy(Request $request, Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        $request->validate([
            'photo_index' => 'required|integer|min:0',
        ]);

        $photos = $invitation->gallery_photos ?? [];
        $index = $request->input('photo_index');

        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);
            unset($photos[$index]);
            $invitation->update(['gallery_photos' => array_values($photos), 'is_active' => true]);
        }

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
