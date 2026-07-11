<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GuestbookController extends Controller
{
    public function index(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            abort(403, 'Fitur QR Check-In hanya tersedia untuk paket Platinum.');
        }

        $stats = [
            'total' => $invitation->guests()->count(),
            'hadir' => $invitation->guests()->where('attendance_status', 'hadir')->count(),
            'pending' => $invitation->guests()->where('attendance_status', 'pending')->count(),
        ];

        $recentCheckins = $invitation->guests()
            ->where('attendance_status', 'hadir')
            ->orderByDesc('checked_in_at')
            ->limit(50)
            ->get();

        return view('dashboard.guestbook.index', compact('invitation', 'stats', 'recentCheckins'));
    }

    public function checkin(Request $request, Invitation $invitation): JsonResponse
    {
        Gate::authorize('view', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            return response()->json([
                'success' => false,
                'message' => 'Fitur QR Check-In hanya tersedia untuk paket Platinum.',
            ], 403);
        }

        $request->validate([
            'qr_code_token' => 'required|string',
        ]);

        $guest = $invitation->guests()
            ->where('qr_code_token', $request->input('qr_code_token'))
            ->first();

        if (! $guest) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid. QR Code tidak ditemukan untuk undangan ini.',
            ], 404);
        }

        if ($guest->isHadir()) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu Sudah Hadir!',
                'already_checked_in' => true,
                'guest' => [
                    'id' => $guest->id,
                    'name' => $guest->name,
                    'checked_in_at' => $guest->checked_in_at->format('H:i, d M Y'),
                ],
            ], 409);
        }

        $guest->markAsHadir();
        $guest->refresh();

        $checkinOrder = $invitation->guests()
            ->where('attendance_status', 'hadir')
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'guest' => [
                'id' => $guest->id,
                'name' => $guest->name,
                'phone' => $guest->whatsapp_number ?? $guest->phone,
                'checked_in_at' => $guest->checked_in_at->format('H:i, d M Y'),
                'checkin_order' => $checkinOrder,
            ],
            'ticket_url' => route('dashboard.invitations.guestbook.ticket', [$invitation, $guest]),
        ]);
    }

    public function ticket(Invitation $invitation, Guest $guest)
    {
        Gate::authorize('view', $invitation);

        if (! $invitation->hasFeature('qr_checkin')) {
            abort(403, 'Fitur QR Check-In hanya tersedia untuk paket Platinum.');
        }

        $checkinOrder = $invitation->guests()
            ->where('attendance_status', 'hadir')
            ->where('checked_in_at', '<=', $guest->checked_in_at)
            ->count();

        $guest->load('events');

        return view('dashboard.guestbook.ticket', compact('invitation', 'guest', 'checkinOrder'));
    }
}
