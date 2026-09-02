<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class QRGatewayController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $invitation = Invitation::with(['events'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        $eventDate = $invitation->event_date ?: $invitation->events->first()?->event_date;
        $maxPax = $invitation->is_rsvp_pax_limited
            ? ($invitation->max_pax_per_guest ?? 2)
            : 50;

        return view('qr-gateway', compact('invitation', 'eventDate', 'maxPax'));
    }
}
