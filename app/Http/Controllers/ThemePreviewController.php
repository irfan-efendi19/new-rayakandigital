<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Theme;

class ThemePreviewController extends Controller
{
    public function show(string $themeSlug)
    {
        $theme = Theme::where('view_path', 'themes.' . $themeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // Create dummy invitation data for preview
        $invitation = new Invitation([
            'title' => 'Pernikahan Budi & Ani',
            'bride_name' => 'Ani Suryani',
            'groom_name' => 'Budi Santoso',
            'bride_nickname' => 'Ani',
            'groom_nickname' => 'Budi',
            'bride_parents' => 'Bapak Surya & Ibu Dewi',
            'groom_parents' => 'Bapak Santo & Ibu Ratna',
            'event_date' => now()->addMonths(2)->format('Y-m-d'),
            'event_time' => '10:00',
            'event_time_end' => '14:00',
            'venue_name' => 'Grand Ballroom Hotel Mulia',
            'venue_address' => 'Jl. Asia Afrika No.8, Senayan, Jakarta Selatan 10270',
            'venue_maps_url' => 'https://maps.google.com/?q=-6.2088,106.8456',
            'love_story' => 'Kami bertemu di bangku kuliah pada tahun 2020. Sebuah perkenalan sederhana yang tumbuh menjadi cinta yang indah.',
            'theme' => $themeSlug,
            'tier' => 'gold',
            'is_active' => true,
            'slug' => 'preview',
            'gallery_photos' => [
                'https://picsum.photos/seed/wedding1/400/400',
                'https://picsum.photos/seed/wedding2/400/400',
                'https://picsum.photos/seed/wedding3/400/400',
            ],
            'gift_bank_name' => 'Bank Central Asia (BCA)',
            'gift_bank_account' => '1234567890',
            'gift_bank_holder' => 'Ani Suryani',
        ]);

        // Don't persist — this is a preview-only model
        $invitation->exists = false;

        $guest = new Guest(['name' => 'Nama Tamu']);

        $themeView = $theme->view_path;

        if (! view()->exists($themeView)) {
            $themeView = 'themes.elegant';
        }

        return view($themeView, [
            'invitation' => $invitation,
            'guest' => $guest,
            'isPreview' => true,
        ]);
    }
}
