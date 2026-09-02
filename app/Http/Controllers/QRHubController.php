<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QRHubController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $invitation = Invitation::with([
            'events',
            'pricingTier:id,package_code',
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

        $firstEvent = $invitation->events->first();
        $eventDate = $invitation->event_date ?: $firstEvent?->event_date;
        $venueName = $invitation->venue_name ?: $firstEvent?->place_name;
        $giftOptionCount = collect($invitation->gift_banks)
            ->filter(fn ($bank) => is_array($bank) && filled($bank['account_number'] ?? null))
            ->count()
            + collect($invitation->gift_ewallets)
                ->filter(fn ($ewallet) => is_array($ewallet) && filled($ewallet['wallet_number'] ?? null))
                ->count()
            + (filled($invitation->gift_qris_image) ? 1 : 0);
        $canUseSharedGallery = $invitation->canUseSharedGallery();

        return view('qr-hub', compact(
            'invitation',
            'eventDate',
            'venueName',
            'giftOptionCount',
            'canUseSharedGallery',
        ));
    }

    public function showKado(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        $giftBanks = collect($invitation->gift_banks)
            ->filter(fn ($bank) => is_array($bank)
                && filled($bank['bank_name'] ?? null)
                && filled($bank['account_number'] ?? null))
            ->values();
        $giftEwallets = collect($invitation->gift_ewallets)
            ->filter(fn ($ewallet) => is_array($ewallet)
                && filled($ewallet['wallet_name'] ?? null)
                && filled($ewallet['wallet_number'] ?? null))
            ->values();
        $qrisUrl = filled($invitation->gift_qris_image)
            ? Storage::disk('public')->url($invitation->gift_qris_image)
            : null;

        return view('qr-kado', compact('invitation', 'giftBanks', 'giftEwallets', 'qrisUrl'));
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
        $invitation = Invitation::with('events')->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        $firstEvent = $invitation->events->first();
        $venueName = $invitation->venue_name ?: ($firstEvent?->place_name ?? 'Lokasi acara');
        $venueAddress = $invitation->venue_address ?: ($firstEvent?->place_address ?? '');
        $mapsUrl = $invitation->venue_maps_url
            ?: ($firstEvent?->google_maps_url
                ?: 'https://www.google.com/maps/search/?api=1&query='.urlencode("{$venueName} {$venueAddress}"));
        $eventDate = $invitation->event_date ?: $firstEvent?->event_date;
        $eventTime = $invitation->event_time ?: $firstEvent?->start_time;

        return view('qr-maps', compact(
            'invitation',
            'venueName',
            'venueAddress',
            'mapsUrl',
            'eventDate',
            'eventTime',
        ));
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
        $officialGalleryUrl = $invitation->photographer_drive_url ?: $invitation->shared_drive_url;

        return view('qr-shared-gallery', compact('invitation', 'photos', 'officialGalleryUrl'));
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
