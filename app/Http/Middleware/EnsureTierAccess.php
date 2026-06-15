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
     * Middleware ini memvalidasi akses berdasarkan tier invitation (bukan user).
     * Pastikan route memiliki parameter invitation agar dapat diperiksa.
     *
     * @param  \Closure(Request): Response  $next
     * @param  string  ...$tiers  Allowed tiers (e.g., 'silver', 'gold', 'platinum')
     */
    public function handle(Request $request, Closure $next, string ...$tiers): Response
    {
        $invitation = $request->route('invitation');

        if (! $invitation) {
            return $next($request);
        }

        $currentTier = $invitation->currentTier();

        if (! in_array($currentTier, $tiers)) {
            return redirect()->route('dashboard.checkout', ['invitation_id' => $invitation->id])
                ->with('warning', 'Fitur ini memerlukan paket '.implode(' / ', array_map('ucfirst', $tiers)).'. Silakan upgrade paket undangan Anda.');
        }

        return $next($request);
    }
}
