<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function store(Request $request, Invitation $invitation)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'attendance' => 'required|in:attending,not_attending,uncertain',
            'pax' => 'required|integer|min:1|max:10',
        ]);

        $invitation->rsvps()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas konfirmasi kehadiran Anda.',
        ]);
    }
}
