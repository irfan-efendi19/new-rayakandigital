<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\ThemeCategory;

class ThemeController extends Controller
{
    public function index()
    {
        $categories = ThemeCategory::withCount('themes')->get();

        $themes = Theme::with('themeCategory')
            ->where('is_active', true)
            ->get();

        return view('themes.index', compact('categories', 'themes'));
    }
}
