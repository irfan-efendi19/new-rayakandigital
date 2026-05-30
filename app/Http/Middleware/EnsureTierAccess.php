<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTierAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): Response  $next
     * @param  string  ...$tiers  Allowed tiers (e.g., 'silver', 'gold', 'platinum')
     */
    public function handle(Request $request, Closure $next, string ...$tiers): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $currentTier = $user->currentTier();

        if (! in_array($currentTier, $tiers)) {
            return redirect()->route('dashboard.checkout')
                ->with('warning', 'Fitur ini memerlukan paket '.implode(' / ', array_map('ucfirst', $tiers)).'. Silakan upgrade paket Anda.');
        }

        return $next($request);
    }
}
