<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\ThemeCategory;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index(Request $request)
    {
        $categories = ThemeCategory::withCount('themes')->get();

        $query = Theme::with('themeCategory')
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('theme_category_id', $request->input('category'));
        }

        $themes = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('all_themes', compact('categories', 'themes'));
    }
}
