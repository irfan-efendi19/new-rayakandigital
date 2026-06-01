<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WelcomeScreenController extends Controller
{
    public function index(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            abort(403, 'Fitur QR Check-In diperlukan untuk Layar Sapa.');
        }

        $firstEvent = $invitation->firstEvent();

        return view('welcome-screen.index', compact('invitation', 'firstEvent'));
    }

    public function getLatestCheckIn(Request $request, Invitation $invitation): JsonResponse
    {
        Gate::authorize('view', $invitation);

        $since = $request->query('since');

        $query = $invitation->guests()
            ->where('attendance_status', 'hadir')
            ->orderByDesc('checked_in_at')
            ->limit(10);

        if ($since) {
            $query->where('checked_in_at', '>', $since);
        }

        $guests = $query->get(['id', 'name', 'checked_in_at']);

        return response()->json([
            'success' => true,
            'guests' => $guests->map(function ($g) {
                $checkinOrder = $invitation->guests()
                    ->where('attendance_status', 'hadir')
                    ->where('checked_in_at', '<=', $g->checked_in_at)
                    ->count();

                return [
                    'id' => $g->id,
                    'name' => $g->name,
                    'checked_in_at' => $g->checked_in_at->toIso8601String(),
                    'checkin_order' => $checkinOrder,
                ];
            }),
            'server_time' => now()->toIso8601String(),
        ]);
    }
}
