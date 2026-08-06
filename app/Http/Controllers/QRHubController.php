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
}
