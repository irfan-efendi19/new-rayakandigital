<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Wish;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function store(Request $request, Invitation $invitation)
    {
        if ($request->has('sender_name') && ! $request->has('guest_name')) {
            $request->merge(['guest_name' => $request->input('sender_name')]);
        }
        if ($request->has('content') && ! $request->has('message')) {
            $request->merge(['message' => $request->input('content')]);
        }

        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $validated['is_hidden'] = false;

        $wish = $invitation->wishes()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas ucapan dan doa Anda.',
            'wish' => $wish,
        ]);
    }

    public function destroy(Invitation $invitation, Wish $wish)
    {
        if ($wish->invitation_id !== $invitation->id) {
            abort(404);
        }

        $wish->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ucapan berhasil dihapus.',
        ]);
    }
}
