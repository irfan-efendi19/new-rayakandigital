<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\ThemeCategory;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index(Request $request): mixed
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

        $themes = $query->orderByDesc('created_at')->orderByDesc('id')->cursorPaginate(12);

        if ($request->ajax()) {
            $html = view('themes.partials.catalog-items', compact('themes'))->render();

            return response()->json([
                'html' => $html,
                'next_cursor' => $themes->nextCursor()?->encode(),
                'has_more' => $themes->hasMorePages(),
            ]);
        }

        $totalThemes = Theme::where('is_active', true)->count();

        if ($request->filled('search')) {
            $totalThemes = Theme::where('is_active', true)
                ->where('name', 'like', "%{$request->input('search')}%")
                ->count();
        }

        if ($request->filled('category')) {
            $totalThemes = Theme::where('is_active', true)
                ->where('theme_category_id', $request->input('category'))
                ->count();
        }

        return view('all_themes', compact('categories', 'themes', 'totalThemes'));
    }
}
