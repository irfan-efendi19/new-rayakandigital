<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasInvitation()) {
            return redirect()->route('dashboard.invitations.show', $user->invitation);
        }

        return redirect()->route('invitation.create');
    }
}
