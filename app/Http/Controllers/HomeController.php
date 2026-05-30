<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Theme;

class HomeController extends Controller
{
    public function index()
    {
        $themes = Theme::where('is_active', true)->get();
        $packages = Package::with('features')
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        return view('home.index', compact('themes', 'packages'));
    }
}
