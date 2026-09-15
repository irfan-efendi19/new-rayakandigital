<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateLink extends Model
{
    public const DESTINATIONS = ['home' => 'Beranda', 'undangan-web' => 'Paket undangan', 'themes.index' => 'Katalog tema'];

    protected $fillable = ['affiliate_id', 'slug', 'label', 'destination'];

    protected $attributes = ['destination' => 'home', 'clicks' => 0];

    protected function casts(): array
    {
        return ['clicks' => 'integer'];
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function getUrlAttribute(): string
    {
        return route('referral.visit', $this->slug);
    }
}
