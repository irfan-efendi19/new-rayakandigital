<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Theme;
use App\Models\ThemeCategory;
use App\Services\AffiliateService;
use App\Services\PromotionService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, PromotionService $promotions, AffiliateService $affiliateService)
    {
        $categories = ThemeCategory::withCount('themes')->get();

        $themes = Theme::with('themeCategory')
            ->where('is_active', true)
            ->get();

        $totalThemes = Theme::where('is_active', true)->count();

        $packages = Package::with('features')
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        $promotionCatalog = $promotions->catalog($packages, $request);
        $affiliateSettings = $affiliateService->settings();

        return response()->view('landing_page', compact('categories', 'themes', 'packages', 'totalThemes', 'promotionCatalog', 'affiliateSettings'))
            ->header('Cache-Control', 'private, no-store');
    }
}
