<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationStory;
use App\Models\PreviewData;
use App\Models\Theme;
use Illuminate\Support\Collection;

class ThemePreviewController extends Controller
{
    public function show(string $themeSlug)
    {
        $theme = Theme::where('view_path', 'themes.' . $themeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $preview = PreviewData::getPreview();

        $invitation = new Invitation([
            'title' => $preview->title,
            'bride_name' => $preview->bride_name,
            'groom_name' => $preview->groom_name,
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
            'qr_code_token' => 'preview-demo-' . str_replace([' ', '.'], '', microtime()),
        ]);

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
