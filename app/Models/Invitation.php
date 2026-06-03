<?php

namespace App\Models;

use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pricing_tier_id',
        'slug',
        'slug_change_count',
        'title',
        'bride_name',
        'groom_name',
        'bride_nickname',
        'groom_nickname',
        'bride_parents',
        'groom_parents',
        'bride_photo',
        'groom_photo',
        'event_date',
        'event_time',
        'event_time_end',
        'timezone',
        'venue_name',
        'venue_address',
        'venue_maps_url',
        'cover_photo',
        'love_story',
        'theme',
        'tier',
        'is_active',
        'trial_started_at',
        'expires_at',
        'gallery_photos',
        'music_url',
        'gift_bank_name',
        'gift_bank_account',
        'gift_bank_holder',
        'gift_ewallet_name',
        'gift_ewallet_number',
        'gift_qris_image',
        'gift_banks',
        'gift_ewallets',
        'wa_template_enabled',
        'wa_message_template',
        'show_qr_checkin',
        'show_comments',
        'show_rsvp',
        'show_gallery',
        'show_gift',
        'show_stories',
        'show_countdown',
        'show_event_detail',
        'show_quote',
        'show_video',
        'youtube_url',
        'youtube_video_id',
        'quote_content',
        'quote_source',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'expires_at' => 'datetime',
            'trial_started_at' => 'datetime',
            'is_active' => 'boolean',
            'gallery_photos' => 'array',
            'gift_banks' => 'array',
            'gift_ewallets' => 'array',
            'wa_template_enabled' => 'boolean',
            'show_qr_checkin' => 'boolean',
            'show_comments' => 'boolean',
            'show_rsvp' => 'boolean',
            'show_gallery' => 'boolean',
            'show_gift' => 'boolean',
            'show_stories' => 'boolean',
            'show_countdown' => 'boolean',
            'show_event_detail' => 'boolean',
            'show_quote' => 'boolean',
            'show_video' => 'boolean',
            'slug_change_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pricingTier(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'pricing_tier_id');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(Rsvp::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(InvitationEvent::class)->orderBy('sort_order');
    }

    public function stories(): HasMany
    {
        return $this->hasMany(InvitationStory::class)->orderBy('order_position');
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class)->latest();
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function themeLabel(): string
    {
        return \App\Models\Theme::where('view_path', 'themes.'.$this->theme)->value('name') ?? ucfirst($this->theme);
    }

    public function getPersonalizedUrl(Guest $guest): string
    {
        return route('invitation.show', $this->slug).'?to='.urlencode($guest->name);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function currentTier(): string
    {
        if ($this->relationLoaded('pricingTier') && $this->pricingTier) {
            return $this->pricingTier->package_code;
        }

        if ($this->pricing_tier_id) {
            return Package::where('id', $this->pricing_tier_id)->value('package_code') ?? $this->tier ?? 'free';
        }

        return $this->tier ?? 'free';
    }

    public function package(): ?Package
    {
        if ($this->pricing_tier_id) {
            return Package::find($this->pricing_tier_id);
        }

        return Package::where('package_code', $this->currentTier())->first();
    }

    public function hasFeature(string $featureKey): bool
    {
        $package = $this->package();

        if (!$package) {
            return false;
        }

        return $package->features()->where('feature_key', $featureKey)->exists();
    }

    public function hasPremiumFeatures(): bool
    {
        return $this->currentTier() !== 'free';
    }

    public function maxGalleryPhotos(): int
    {
        if ($this->hasFeature('gallery_photos')) {
            $package = $this->package();
            $code = $package?->package_code;

            return match ($code) {
                'free' => 1,
                'silver' => 5,
                'gold' => 20,
                'platinum' => 999,
                default => 5,
            };
        }

        return 0;
    }

    public function canUseCustomMusic(): bool
    {
        return $this->hasFeature('custom_music') || $this->hasAddon('addon_custom_music');
    }

    public function canUseGift(): bool
    {
        return $this->hasFeature('digital_gift') || $this->hasAddon('addon_digital_gift');
    }

    public function maxGiftAccounts(): int
    {
        if ($this->hasFeature('unlimited_gift')) {
            return 999;
        }

        if ($this->hasFeature('multi_gift')) {
            return 3;
        }

        if ($this->hasFeature('digital_gift')) {
            return 1;
        }

        return $this->hasAddon('addon_digital_gift') ? 3 : 0;
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class)->withPivot('purchased_at')->withTimestamps();
    }

    public function hasAddon(string $featureKey): bool
    {
        return $this->addons()
            ->where('feature_key', $featureKey)
            ->where('addons.is_active', true)
            ->exists();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function whatsappLogs(): HasMany
    {
        return $this->hasMany(WhatsappLog::class);
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function trialRemainingDays(): int
    {
        if (!$this->expires_at) {
            return 0;
        }

        return max(0, now()->diffInDays($this->expires_at, false));
    }

    public function trialRemainingHours(): int
    {
        if (!$this->expires_at) {
            return 0;
        }

        $totalHours = now()->diffInHours($this->expires_at, false);

        return max(0, $totalHours % 24);
    }

    public function isTrialUrgent(): bool
    {
        if (!$this->expires_at) {
            return false;
        }

        return now()->diffInHours($this->expires_at, false) <= 24 && !$this->expires_at->isPast();
    }

    public function isTrialExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function getWhatsappTemplate(): string
    {
        if ($this->wa_template_enabled && $this->wa_message_template) {
            return $this->wa_message_template;
        }

        return "Yth. {nama_tamu},\n\nKami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara pernikahan kami:\n\n✨ {nama_mempelai_pria} & {nama_mempelai_wanita} ✨\n\nSilakan buka undangan digital Anda di:\n{tautan_undangan}\n\nMerupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir. 🙏";
    }

    public static function extractYoutubeId(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/live\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        return null;
    }

    public function firstEvent(): ?InvitationEvent
    {
        return $this->events()->orderBy('event_date')->orderBy('start_time')->first();
    }

    public function parseWhatsappTemplate(\App\Models\Guest $guest): string
    {
        $template = $this->getWhatsappTemplate();
        $firstEvent = $this->firstEvent();

        $replacements = [
            '{nama_tamu}' => $guest->name,
            '{nama_mempelai_pria}' => $this->groom_name,
            '{nama_mempelai_wanita}' => $this->bride_name,
            '{tautan_undangan}' => $guest->personalized_link,
            '{qrcode_link}' => $this->hasFeature('qr_checkin') ? $guest->personalized_link . '&qr=1' : '',
            '{tanggal_acara}' => $firstEvent?->event_date?->format('d F Y') ?? $this->event_date?->format('d F Y') ?? '',
            '{waktu_acara}' => $firstEvent?->start_time ?? $this->event_time ?? '',
            '{tempat_acara}' => $firstEvent?->place_name ?? $this->venue_name ?? '',
            '{alamat_acara}' => $firstEvent?->place_address ?? $this->venue_address ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }
}
