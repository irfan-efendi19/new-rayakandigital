<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThemePreviewData extends Model
{
    /** @var array<string, string> */
    public const FORM_FIELD_MAP = [
        'title' => 'preview_title',
        'groom_full_name' => 'preview_groom_full_name',
        'groom_short_name' => 'preview_groom_short_name',
        'groom_father_name' => 'preview_groom_father_name',
        'groom_mother_name' => 'preview_groom_mother_name',
        'bride_full_name' => 'preview_bride_full_name',
        'bride_short_name' => 'preview_bride_short_name',
        'bride_father_name' => 'preview_bride_father_name',
        'bride_mother_name' => 'preview_bride_mother_name',
        'bride_photo_path' => 'preview_bride_photo_path',
        'groom_photo_path' => 'preview_groom_photo_path',
        'hero_image_path' => 'preview_hero_image_path',
        'bg_music_path' => 'preview_bg_music_path',
        'show_video' => 'preview_show_video',
        'youtube_url' => 'preview_youtube_url',
        'youtube_video_id' => 'preview_youtube_video_id',
        'timezone' => 'preview_timezone',
        'event_date_offset_days' => 'preview_event_date_offset_days',
        'event_time' => 'preview_event_time',
        'event_time_end' => 'preview_event_time_end',
        'venue_name' => 'preview_venue_name',
        'venue_address' => 'preview_venue_address',
        'venue_maps_url' => 'preview_venue_maps_url',
        'quote_content' => 'preview_quote_content',
        'quote_source' => 'preview_quote_source',
        'love_story' => 'preview_love_story',
        'stories' => 'preview_stories',
        'gallery_photos' => 'preview_gallery_photos',
        'gift_banks' => 'preview_gift_banks',
        'gift_ewallets' => 'preview_gift_ewallets',
        'events' => 'preview_events',
    ];

    protected $fillable = [
        'theme_id',
        'title',
        'groom_full_name',
        'groom_short_name',
        'groom_father_name',
        'groom_mother_name',
        'bride_full_name',
        'bride_short_name',
        'bride_father_name',
        'bride_mother_name',
        'bride_photo_path',
        'groom_photo_path',
        'hero_image_path',
        'bg_music_path',
        'show_video',
        'youtube_url',
        'youtube_video_id',
        'timezone',
        'event_date_offset_days',
        'event_time',
        'event_time_end',
        'venue_name',
        'venue_address',
        'venue_maps_url',
        'quote_content',
        'quote_source',
        'love_story',
        'stories',
        'gallery_photos',
        'gift_banks',
        'gift_ewallets',
        'events',
    ];

    protected function casts(): array
    {
        return [
            'show_video' => 'boolean',
            'event_date_offset_days' => 'integer',
            'stories' => 'array',
            'gallery_photos' => 'array',
            'gift_banks' => 'array',
            'gift_ewallets' => 'array',
            'events' => 'array',
        ];
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /** @return array<string, mixed> */
    public function toFormData(): array
    {
        $data = [];

        foreach (self::FORM_FIELD_MAP as $attribute => $formField) {
            $data[$formField] = $this->{$attribute};
        }

        return $data;
    }

    /** @param array<string, mixed> $formData */
    public static function fromFormData(array $formData): array
    {
        $attributes = [];

        foreach (self::FORM_FIELD_MAP as $attribute => $formField) {
            $attributes[$attribute] = $formData[$formField] ?? null;
        }

        return $attributes;
    }

    public function groomParentsText(): ?string
    {
        $parts = [];

        if ($this->groom_father_name) {
            $parts[] = 'Bapak '.$this->groom_father_name;
        }

        if ($this->groom_mother_name) {
            $parts[] = 'Ibu '.$this->groom_mother_name;
        }

        if (empty($parts)) {
            return null;
        }

        return 'Putra dari '.implode(' & ', $parts);
    }

    public function brideParentsText(): ?string
    {
        $parts = [];

        if ($this->bride_father_name) {
            $parts[] = 'Bapak '.$this->bride_father_name;
        }

        if ($this->bride_mother_name) {
            $parts[] = 'Ibu '.$this->bride_mother_name;
        }

        if (empty($parts)) {
            return null;
        }

        return 'Putri dari '.implode(' & ', $parts);
    }

    public function mergeWithFallback(PreviewData $fallback): PreviewData
    {
        $merged = $fallback->replicate();

        $merged->title = $this->valueOrFallback($this->title, $fallback->title);
        $merged->groom_name = $this->valueOrFallback($this->groom_full_name, $fallback->groom_name);
        $merged->groom_nickname = $this->valueOrFallback($this->groom_short_name, $fallback->groom_nickname);
        $merged->bride_name = $this->valueOrFallback($this->bride_full_name, $fallback->bride_name);
        $merged->bride_nickname = $this->valueOrFallback($this->bride_short_name, $fallback->bride_nickname);
        $merged->groom_parents = $this->groomParentsText() ?: $fallback->groom_parents;
        $merged->bride_parents = $this->brideParentsText() ?: $fallback->bride_parents;
        $merged->bride_photo = $this->valueOrFallback($this->bride_photo_path, $fallback->bride_photo);
        $merged->groom_photo = $this->valueOrFallback($this->groom_photo_path, $fallback->groom_photo);
        $merged->cover_photo = $this->valueOrFallback($this->hero_image_path, $fallback->cover_photo);
        $merged->music_url = $this->valueOrFallback($this->bg_music_path, $fallback->music_url);
        $merged->show_video = $this->show_video ?? $fallback->show_video;
        $merged->youtube_url = $this->valueOrFallback($this->youtube_url, $fallback->youtube_url);
        $merged->youtube_video_id = $this->valueOrFallback($this->youtube_video_id, $fallback->youtube_video_id);
        $merged->timezone = $this->valueOrFallback($this->timezone, $fallback->timezone);
        $merged->event_date_offset_days = $this->event_date_offset_days ?? $fallback->event_date_offset_days;
        $merged->event_time = $this->valueOrFallback($this->event_time, $fallback->event_time);
        $merged->event_time_end = $this->valueOrFallback($this->event_time_end, $fallback->event_time_end);
        $merged->venue_name = $this->valueOrFallback($this->venue_name, $fallback->venue_name);
        $merged->venue_address = $this->valueOrFallback($this->venue_address, $fallback->venue_address);
        $merged->venue_maps_url = $this->valueOrFallback($this->venue_maps_url, $fallback->venue_maps_url);
        $merged->quote_content = $this->valueOrFallback($this->quote_content, $fallback->quote_content);
        $merged->quote_source = $this->valueOrFallback($this->quote_source, $fallback->quote_source);
        $merged->love_story = $this->valueOrFallback($this->love_story, $fallback->love_story);
        $merged->stories = $this->valueOrFallback($this->stories, $fallback->stories);
        $merged->gallery_photos = $this->valueOrFallback($this->gallery_photos, $fallback->gallery_photos);
        $merged->gift_banks = $this->valueOrFallback($this->gift_banks, $fallback->gift_banks);
        $merged->gift_ewallets = $this->valueOrFallback($this->gift_ewallets, $fallback->gift_ewallets);
        $merged->events = $this->valueOrFallback($this->events, $fallback->events);

        return $merged;
    }

    private function valueOrFallback(mixed $value, mixed $fallback): mixed
    {
        if (is_array($value)) {
            return ! empty($value) ? $value : $fallback;
        }

        return filled($value) ? $value : $fallback;
    }
}
