<?php

namespace App\Http\Controllers;

use App\Models\AffiliateTier;
use App\Models\Package;
use App\Services\AffiliateService;
use Illuminate\View\View;

class ResellerAffiliateController extends Controller
{
    public function __invoke(AffiliateService $affiliates): View
    {
        $packages = Package::query()
            ->where('is_visible', true)
            ->where('price', '>', 0)
            ->orderBy('sort_order')
            ->get();

        $tiers = AffiliateTier::query()
            ->orderBy('commission_rate')
            ->get();

        return view('reseller-affiliate', [
            'settings' => $affiliates->settings(),
            'packages' => $packages,
            'tiers' => $tiers,
        ]);
    }
}
