<?php

namespace App\Models;

use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
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
        'wa_template_enabled',
        'wa_message_template',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'expires_at' => 'datetime',
            'trial_started_at' => 'datetime',
            'is_active' => 'boolean',
            'gallery_photos' => 'array',
            'wa_template_enabled' => 'boolean',
            'slug_change_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(Rsvp::class);
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
        return match ($this->theme) {
            'elegant' => 'Elegant Rose',
            'modern' => 'Modern Dark',
            'garden' => 'Garden Green',
            default => 'Elegant Rose',
        };
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
        return $this->user ? $this->user->currentTier() : ($this->attributes['tier'] ?? 'free');
    }

    public function package(): ?Package
    {
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

    public function addons(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
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

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
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

    public function parseWhatsappTemplate(\App\Models\Guest $guest): string
    {
        $template = $this->getWhatsappTemplate();

        $replacements = [
            '{nama_tamu}' => $guest->name,
            '{nama_mempelai_pria}' => $this->groom_name,
            '{nama_mempelai_wanita}' => $this->bride_name,
            '{tautan_undangan}' => $guest->personalized_link,
            '{qrcode_link}' => $this->hasFeature('qr_checkin') ? $guest->personalized_link . '&qr=1' : '',
            '{tanggal_acara}' => $this->event_date?->format('d F Y') ?? '',
            '{waktu_acara}' => $this->event_time ?? '',
            '{tempat_acara}' => $this->venue_name ?? '',
            '{alamat_acara}' => $this->venue_address ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }
}
