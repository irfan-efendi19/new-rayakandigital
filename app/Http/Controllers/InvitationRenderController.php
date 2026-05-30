<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationRenderController extends Controller
{
    public function show(Request $request, $slug)
    {
        $invitation = Invitation::with(['wishes', 'rsvps'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        $guest = null;
        if ($request->has('to')) {
            $guestName = $request->query('to');
            $guest = Guest::where('invitation_id', $invitation->id)
                ->where('name', $guestName)
                ->first();

            if (! $guest) {
                // Temporary guest for greeting
                $guest = new Guest(['name' => $guestName]);
            }
        }

        $themeView = 'themes.'.$invitation->theme;

        if (! view()->exists($themeView)) {
            $themeView = 'themes.elegant'; // fallback
        }

        return view($themeView, compact('invitation', 'guest'));
    }
}
