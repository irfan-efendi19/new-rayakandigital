<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class QRGatewayController extends Controller
{
    public function show(Request $request, $slug)
    {
        $invitation = Invitation::with(['events'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return response()->view('invitations.expired', compact('invitation'));
        }

        return view('qr-gateway', compact('invitation'));
    }
}
