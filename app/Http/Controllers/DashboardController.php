<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Order;
use App\Services\PaymentRoutingService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, PaymentRoutingService $routing)
    {
        $user = $request->user();
        $invitations = $user->invitations;

        $trialInvitations = $invitations->filter(fn (Invitation $i) =>
            $i->expires_at !== null && !$i->hasPremiumFeatures()
        );

        $pendingOrders = $user->orders()
            ->whereIn('payment_status', ['pending', 'verifying'])
            ->latest()
            ->get();

        return view('dashboard.index', compact('invitations', 'trialInvitations', 'pendingOrders', 'routing'));
    }
}
