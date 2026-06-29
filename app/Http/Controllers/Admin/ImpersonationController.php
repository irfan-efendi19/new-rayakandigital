<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ImpersonationController extends Controller
{
    public function switch(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        if ($user->isAdmin() && ! $request->user()->isSuperAdmin()) {
            abort(403, 'Anda tidak dapat mengintip dasbor admin lain.');
        }

        $impersonatorId = session('impersonator_id');
        if ($impersonatorId) {
            $currentImpersonator = User::find($impersonatorId);
            if ($currentImpersonator) {
                Log::warning("Admin {$currentImpersonator->email} (ID: {$currentImpersonator->id}) switched impersonation from {$user->email} (ID: {$user->id})");
            }
        } else {
            Log::info("Admin {$request->user()->email} (ID: {$request->user()->id}) started impersonating {$user->email} (ID: {$user->id})");
        }

        if (! $impersonatorId) {
            session(['impersonator_id' => $request->user()->id]);
        }

        session(['impersonate_user_id' => $user->id]);

        Cache::forget('admin_user_ids');

        return redirect()->route('dashboard')
            ->with('success', 'Anda sedang mengintip dasbor sebagai ' . $user->name . '.');
    }

    public function leave(Request $request)
    {
        $impersonatorId = session('impersonator_id');
        $impersonatedId = session('impersonate_user_id');

        if ($impersonatedId) {
            $impersonated = User::find($impersonatedId);
            Log::info("Admin ended impersonation of {$impersonated?->email} (ID: {$impersonatedId})");
        }

        session()->forget('impersonate_user_id');

        if ($impersonatorId) {
            session()->forget('impersonator_id');
        }

        Cache::forget('admin_user_ids');

        return redirect()->route('dashboard')
            ->with('success', 'Anda kembali ke dasbor admin.');
    }

    public function index(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        $users = User::where('role', 'user')
            ->withCount('invitations')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.impersonation', compact('users'));
    }
}
