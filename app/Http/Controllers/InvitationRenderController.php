<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\PageView;
use Illuminate\Http\Request;

class InvitationRenderController extends Controller
{
    public function show(Request $request, $slug)
    {
        $invitation = Invitation::with(['wishes', 'rsvps', 'events', 'stories'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        // Jika parameter ?mode=scan_qr ada, redirect ke halaman QR Gateway RSVP Universal
        if ($request->query('mode') === 'scan_qr') {
            return redirect()->route('qr-gateway', $invitation->slug);
        }

        $this->trackPageView($request, $invitation);

        $guest = null;
        $guestEvents = null;
        if ($request->has('to')) {
            $guestSlug = $request->query('to');
            $guest = Guest::with('events')
                ->where('invitation_id', $invitation->id)
                ->where('slug', $guestSlug)
                ->first();

            if ($guest && $guest->events->isNotEmpty()) {
                $guestEvents = $guest->events;
            }

            if (! $guest) {
                $guest = new Guest(['name' => $guestSlug]);
            }
        }

        $themeView = 'themes.'.$invitation->theme;

        if (! view()->exists($themeView)) {
            $themeView = 'themes.jawa';
        }

        return view($themeView, compact('invitation', 'guest', 'guestEvents'));
    }

    protected function trackPageView(Request $request, Invitation $invitation): void
    {
        $ip = $request->ip();
        $ua = $request->userAgent();
        $visitorId = md5($ip . ($ua ?? ''));

        $exists = PageView::where('invitation_id', $invitation->id)
            ->where('visitor_id', $visitorId)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->exists();

        if (! $exists) {
            PageView::create([
                'invitation_id' => $invitation->id,
                'visitor_id' => $visitorId,
                'ip_address' => $ip,
                'user_agent' => substr($ua ?? '', 0, 500),
            ]);
        }
    }
}
