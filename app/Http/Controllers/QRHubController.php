<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class QRHubController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $invitation = Invitation::with([
            'events',
            'wishes' => function ($q) {
                $q->where('is_hidden', false)->latest()->take(5);
            },
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        return view('qr-hub', compact('invitation'));
    }

    public function showKado(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        return view('qr-kado', compact('invitation'));
    }

    public function showUcapan(Request $request, string $slug)
    {
        $invitation = Invitation::with([
            'wishes' => function ($q) {
                $q->where('is_hidden', false)->latest()->take(10);
            },
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        return view('qr-ucapan', compact('invitation'));
    }

    public function showMaps(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        return view('qr-maps', compact('invitation'));
    }

    public function showSharedGallery(Request $request, string $slug)
    {
        $invitation = Invitation::with(['sharedPhotos' => fn ($q) => $q->latest()])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        if (! $invitation->canUseSharedGallery()) {
            abort(403, 'Fitur QR Galeri Foto Bersama hanya tersedia untuk paket Gold dan Platinum.');
        }

        $photos = $invitation->sharedPhotos;

        return view('qr-shared-gallery', compact('invitation', 'photos'));
    }

    public function uploadSharedPhoto(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->json(['message' => 'Undangan sudah kadaluarsa.'], 403);
        }

        if (! $invitation->canUseSharedGallery()) {
            return response()->json(['message' => 'Fitur Galeri Foto Bersama hanya tersedia untuk paket Gold dan Platinum.'], 403);
        }

        $request->validate([
            'photo' => ['required', 'image', 'max:10240'],
            'guest_name' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:500'],
        ]);

        $path = $request->file('photo')->store("event-shared-photos/{$invitation->id}", 'public');

        $photo = $invitation->sharedPhotos()->create([
            'guest_name' => $request->input('guest_name'),
            'photo_path' => $path,
            'caption' => $request->input('caption'),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diunggah!',
                'photo' => [
                    'id' => $photo->id,
                    'url' => $photo->url,
                    'guest_name' => $photo->guest_name ?: 'Tamu Undangan',
                    'caption' => $photo->caption,
                ],
            ]);
        }

        return back()->with('success', 'Foto berhasil diunggah!');
    }
}
