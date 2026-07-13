<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Theme;

class SitemapController extends Controller
{
    public function index()
    {
        $staticPages = [
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => '/semua-tema', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => '/undangan-web', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/buku-tamu', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/live-streaming', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/tentang-kami', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/hubungi-kami', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/syarat-ketentuan', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['loc' => '/kebijakan-privasi', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['loc' => '/dashboard', 'priority' => '0.4', 'changefreq' => 'weekly'],
            ['loc' => '/login', 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => '/register', 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => '/forgot-password', 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => '/verify-email', 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        // Filament admin (/admin) is intentionally excluded from the sitemap.

        $themes = Theme::where('is_active', true)->get()->map(fn (Theme $theme) => [
            'loc' => '/themes/'.$theme->slug.'/preview',
            'priority' => '0.6',
            'changefreq' => 'monthly',
        ]);

        $invitations = Invitation::active()->get()->map(fn (Invitation $invitation) => [
            'loc' => '/'.$invitation->slug,
            'priority' => '0.5',
            'changefreq' => 'weekly',
            'lastmod' => $invitation->updated_at->toW3cString(),
        ]);

        $urls = collect($staticPages)
            ->concat($themes)
            ->concat($invitations);

        return response()->view('sitemap', compact('urls'))->header('Content-Type', 'text/xml');
    }
}
