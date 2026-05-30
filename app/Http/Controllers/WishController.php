<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function store(Request $request, Invitation $invitation)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $wish = $invitation->wishes()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas ucapan dan doa Anda.',
            'wish' => $wish,
        ]);
    }
}
