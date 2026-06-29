<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        $impersonatorId = session('impersonator_id');
        if ($impersonatorId) {
            $impersonator = User::find($impersonatorId);
            if ($impersonator && $impersonator->isAdmin()) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized access.');
    }
}
