<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ReferralController extends Controller
{
    public function __invoke(Request $request, string $slug): RedirectResponse
    {
        $link = AffiliateLink::query()->with('affiliate')
            ->whereHas('affiliate', fn ($query) => $query->eligible())->where('slug', $slug)->firstOrFail();

        if ($request->user()?->id !== $link->affiliate->user_id) {
            $key = 'affiliate_clicks.'.$link->id;
            if ((int) $request->session()->get($key, 0) < now()->timestamp) {
                $link->increment('clicks');
                $request->session()->put($key, now()->addMinutes(30)->timestamp);
            }
            $referral = ['link_id' => $link->id, 'expires_at' => now()->addDays(30)->timestamp];
            $request->session()->put('affiliate_referral', $referral);
            Cookie::queue(cookie('affiliate_referral', json_encode($referral), 60 * 24 * 30, '/', null, $request->isSecure(), true, false, 'lax'));
        }

        return redirect()->route($link->destination)->header('Cache-Control', 'private, no-store');
    }
}
