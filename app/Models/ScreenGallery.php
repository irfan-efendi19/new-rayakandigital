<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class ScreenGallery extends Model
{
    protected $fillable = [
        'invitation_id',
        'image_path',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    protected static function booted()
    {
        static::saved(fn ($gallery) => Cache::forget("live_screen_output_{$gallery->invitation_id}"));
        static::deleted(fn ($gallery) => Cache::forget("live_screen_output_{$gallery->invitation_id}"));
    }
}
