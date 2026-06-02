<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Theme;
use App\Models\ThemeCategory;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ThemeCategory::withCount('themes')->get();

        $themes = Theme::with('themeCategory')
            ->where('is_active', true)
            ->take(9)
            ->get();

        $totalThemes = Theme::where('is_active', true)->count();

        $packages = Package::with('features')
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        return view('landing_page', compact('categories', 'themes', 'packages', 'totalThemes'));
    }
}
