<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Impersonate
{
    public function handle(Request $request, Closure $next): Response
    {
        $impersonateUserId = session('impersonate_user_id');

        if ($impersonateUserId && Auth::check()) {
            $impersonatedUser = User::find($impersonateUserId);

            if ($impersonatedUser) {
                $impersonator = Auth::user();
                Auth::setUser($impersonatedUser);
                $request->setUserResolver(fn () => $impersonatedUser);

                $impersonatedUser->is_impersonated = true;
                $impersonatedUser->impersonator = $impersonator;
            } else {
                session()->forget('impersonate_user_id');
            }
        }

        return $next($request);
    }
}
