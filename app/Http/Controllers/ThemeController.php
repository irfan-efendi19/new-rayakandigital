<?php

namespace App\Http\Controllers;

use App\Models\Theme;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::where('is_active', true)->get();

        return view('themes.index', compact('themes'));
    }
}
