<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Order;
use App\Models\User;
use App\Services\PaymentRoutingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request, PaymentRoutingService $routing)
    {
        $user = $request->user();
        $isAdmin = $user->isAdmin();

        if ($isAdmin) {
            $adminIds = Cache::remember('admin_user_ids', 3600, function () {
                return User::where('role', 'admin')->pluck('id')->toArray();
            });

            $invitations = Invitation::with('pricingTier')
                ->whereNotIn('user_id', $adminIds)
                ->orWhere('user_id', $user->id)
                ->get();

            $pendingOrders = Order::whereIn('payment_status', ['pending', 'verifying'])
                ->latest()
                ->get();
        } else {
            $invitations = $user->invitations()->with('pricingTier')->get();

            $pendingOrders = $user->orders()
                ->whereIn('payment_status', ['pending', 'verifying'])
                ->latest()
                ->get();
        }

        $trialInvitations = $invitations->filter(fn (Invitation $i) =>
            $i->expires_at !== null && !$i->hasPremiumFeatures()
        );

        $totalUsers = null;
        $totalInvitations = null;
        if ($isAdmin) {
            $totalUsers = User::count();
            $totalInvitations = Invitation::count();
        }

        return view('dashboard.index', compact(
            'invitations', 'trialInvitations', 'pendingOrders', 'routing',
            'isAdmin', 'totalUsers', 'totalInvitations'
        ));
    }
}
