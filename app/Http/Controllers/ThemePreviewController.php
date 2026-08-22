<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationStory;
use App\Models\Theme;
use Illuminate\Support\Collection;

class ThemePreviewController extends Controller
{
    public function show(string $themeSlug)
    {
        $aliases = [
            'webtoon' => 'manga',
            'comic' => 'manga',
            'komik' => 'manga',
            'library-card' => 'library_card',
            'vintage-book' => 'library_card',
            'vintage_book' => 'library_card',
            'novel' => 'library_card',
            'buku' => 'library_card',
            'perpustakaan' => 'library_card',
            'newspaper' => 'newspaper',
            'koran' => 'newspaper',
            'breaking-news' => 'newspaper',
            'breaking_news' => 'newspaper',
            'news' => 'newspaper',
            'berita' => 'newspaper',
            'ojek-online' => 'ojek_online',
            'ojek_online' => 'ojek_online',
            'gofood' => 'ojek_online',
            'gojek' => 'ojek_online',
            'grab' => 'ojek_online',
            'delivery-order' => 'ojek_online',
            'delivery_order' => 'ojek_online',
            'ojol' => 'ojek_online',
            'buku-nikah' => 'buku_nikah',
            'buku_nikah' => 'buku_nikah',
            'kua' => 'buku_nikah',
            'dokumen-negara' => 'buku_nikah',
            'dokumen_negara' => 'buku_nikah',
            'akta-nikah' => 'buku_nikah',
            'akta_nikah' => 'buku_nikah',
            'scoreboard' => 'scoreboard',
            'papan-skor' => 'scoreboard',
            'papan_skor' => 'scoreboard',
            'arena' => 'scoreboard',
            'stadium' => 'scoreboard',
            'football' => 'scoreboard',
            'sport' => 'scoreboard',
            'match-day' => 'scoreboard',
            'surat-cinta' => 'surat_cinta',
            'surat_cinta' => 'surat_cinta',
            'love-letter' => 'surat_cinta',
            'love_letter' => 'surat_cinta',
            'kertas-buku' => 'surat_cinta',
            'kertas_buku' => 'surat_cinta',
            'surat-kaleng' => 'surat_cinta',
            'surat_kaleng' => 'surat_cinta',
            'notebook' => 'surat_cinta',
            'binder' => 'surat_cinta',
            'tabloid' => 'tabloid',
            'majalah' => 'tabloid',
            'magazine' => 'tabloid',
            'fashion' => 'tabloid',
            'y2k' => 'tabloid',
            'gossip' => 'tabloid',
            'retro-magazine' => 'tabloid',
            'vogue' => 'tabloid',
            'kai' => 'kai',
            'kai-access' => 'kai',
            'kai_access' => 'kai',
            'kereta' => 'kai',
            'kereta-api' => 'kai',
            'kereta_api' => 'kai',
            'train' => 'kai',
            'boarding-pass' => 'kai',
            'boarding_pass' => 'kai',
            'access' => 'kai',
            'crypto' => 'crypto',
            'lct' => 'crypto',
            'love-token' => 'crypto',
            'love_token' => 'crypto',
            'trading' => 'crypto',
            'binance' => 'crypto',
            'web3' => 'crypto',
            'blockchain' => 'crypto',
            'metamask' => 'crypto',
            'bitcoin' => 'crypto',
            'premier-screening' => 'premier_screening',
            'premier_screening' => 'premier_screening',
            'cinema' => 'premier_screening',
            'movie' => 'premier_screening',
            'bioskop' => 'premier_screening',
            'islamic' => 'islamic',
            'islami' => 'islamic',
            'muslim' => 'islamic',
            'nikah' => 'islamic',
            'masjid' => 'islamic',
            'claw-machine' => 'claw_machine',
            'claw_machine' => 'claw_machine',
            'love-claw-machine' => 'claw_machine',
            'love_claw_machine' => 'claw_machine',
            'mesin-capit' => 'claw_machine',
            'mesin_capit' => 'claw_machine',
            'claw' => 'claw_machine',
            'arcade-claw' => 'claw_machine',
            'snakes-and-ladders' => 'snakes_and_ladders',
            'snakes_and_ladders' => 'snakes_and_ladders',
            'snakes-ladders' => 'snakes_and_ladders',
            'snakes_ladders' => 'snakes_and_ladders',
            'ular-tangga' => 'snakes_and_ladders',
            'ular_tangga' => 'snakes_and_ladders',
            'path-to-pelaminan' => 'snakes_and_ladders',
            'path_to_pelaminan' => 'snakes_and_ladders',
            'daily-brew' => 'daily_brew',
            'daily_brew' => 'daily_brew',
            'the-daily-brew' => 'daily_brew',
            'the_daily_brew' => 'daily_brew',
            'coffee' => 'daily_brew',
            'coffee-shop' => 'daily_brew',
            'coffee_shop' => 'daily_brew',
            'kopi' => 'daily_brew',
            'ljk-exam' => 'ljk_exam',
            'ljk_exam' => 'ljk_exam',
            'ujian-sekolah' => 'ljk_exam',
            'ujian_sekolah' => 'ljk_exam',
            'lembar-jawaban' => 'ljk_exam',
            'lembar_jawaban' => 'ljk_exam',
            'ljk' => 'ljk_exam',
            'un' => 'ljk_exam',
            'shopee' => 'shopee_market',
            'shopee-market' => 'shopee_market',
            'shopee_market' => 'shopee_market',
            'shoppe' => 'shopee_market',
            'shope' => 'shopee_market',
            'ecommerce' => 'shopee_market',
            'marketplace' => 'shopee_market',
            'shop-love' => 'shopee_market',
            'shoplove' => 'shopee_market',
            'marker-doodle' => 'marker_doodle',
            'marker_doodle' => 'marker_doodle',
            'marker-sketch' => 'marker_doodle',
            'marker_sketch' => 'marker_doodle',
            'spidol' => 'marker_doodle',
            'papan-tulis' => 'marker_doodle',
            'papan_tulis' => 'marker_doodle',
            'whiteboard' => 'marker_doodle',
            'sketch' => 'marker_doodle',
            'doodle' => 'marker_doodle',
        ];

        $effectiveSlug = $aliases[$themeSlug] ?? $themeSlug;
        $themeSlugUnderscore = str_replace('-', '_', $effectiveSlug);
        $themeSlugDash = str_replace('_', '-', $effectiveSlug);

        $theme = Theme::with('previewData')
            ->where(function ($query) use ($effectiveSlug, $themeSlugUnderscore, $themeSlugDash) {
                $query->where('view_path', 'themes.'.$effectiveSlug)
                    ->orWhere('view_path', 'themes.'.$themeSlugUnderscore)
                    ->orWhere('view_path', 'themes.'.$themeSlugDash);
            })
            ->where('is_active', true)
            ->firstOrFail();

        $preview = $theme->resolvedPreviewData();

        $invitation = new Invitation([
            'title' => $preview->title,
            'cover_photo' => $preview->cover_photo,
            'music_url' => $preview->music_url,
            'show_video' => true,
            'youtube_url' => $preview->youtube_url ?? 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
            'youtube_video_id' => $preview->youtube_video_id ?: ($preview->youtube_url ? Invitation::extractYoutubeId($preview->youtube_url) : 'aqz-KE-bpKQ'),
            'timezone' => $preview->timezone ?? 'Asia/Jakarta',
            'bride_name' => $preview->bride_name,
            'bride_photo' => $preview->bride_photo,
            'groom_name' => $preview->groom_name,
            'groom_photo' => $preview->groom_photo,
            'bride_nickname' => $preview->bride_nickname,
            'groom_nickname' => $preview->groom_nickname,
            'bride_parents' => $preview->bride_parents,
            'groom_parents' => $preview->groom_parents,
            'event_date' => $preview->event_date,
            'event_time' => $preview->event_time,
            'event_time_end' => $preview->event_time_end,
            'venue_name' => $preview->venue_name,
            'venue_address' => $preview->venue_address,
            'venue_maps_url' => $preview->venue_maps_url,
            'love_story' => $preview->love_story,
            'theme' => $themeSlug,
            'tier' => 'gold',
            'is_active' => true,
            'slug' => 'preview',
            'gallery_photos' => $preview->gallery_photos ?? [],
            'gift_banks' => $preview->gift_banks ?? (
                $preview->gift_bank_name ? [
                    [
                        'bank_name' => $preview->gift_bank_name,
                        'account_number' => $preview->gift_bank_account,
                        'account_holder' => $preview->gift_bank_holder,
                    ],
                ] : []
            ),
            'gift_ewallets' => $preview->gift_ewallets ?? [],
            'quote_content' => $preview->quote_content,
            'quote_source' => $preview->quote_source,
            'show_rsvp' => true,
            'show_gallery' => true,
            'show_gift' => true,
            'show_stories' => true,
            'show_countdown' => true,
            'show_event_detail' => true,
            'show_quote' => true,
            'show_video' => true,
            'show_qr_checkin' => true,
            'show_comments' => true,
        ]);

        $invitation->exists = false;

        $dummyEvents = [];
        foreach ($preview->parsed_events as $eventData) {
            $event = new InvitationEvent($eventData);
            $event->exists = false;
            $dummyEvents[] = $event;
        }

        $invitation->setRelation('events', new Collection($dummyEvents));

        $dummyStories = [];
        foreach ($preview->parsed_stories as $storyData) {
            $story = new InvitationStory($storyData);
            $story->exists = false;
            $dummyStories[] = $story;
        }
        $invitation->setRelation('stories', new Collection($dummyStories));

        $guest = new Guest([
            'name' => 'Nama Tamu',
            'qr_code_token' => 'preview-demo-'.str_replace([' ', '.'], '', microtime()),
        ]);

        $themeView = $theme->view_path;

        if (! view()->exists($themeView)) {
            $themeView = 'themes.jawa';
        }

        return view($themeView, [
            'invitation' => $invitation,
            'guest' => $guest,
            'isPreview' => true,
        ]);
    }
}
