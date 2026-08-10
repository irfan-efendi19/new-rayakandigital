<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasNoInvitation
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasInvitation()) {
            return redirect()->route('invitation.dashboard');
        }

        return $next($request);
    }
}
