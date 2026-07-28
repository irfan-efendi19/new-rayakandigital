<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class InvitationScreen extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'selected_theme',
        'custom_title',
        'show_wishes_wall',
    ];

    protected $casts = [
        'show_wishes_wall' => 'boolean',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * Preset tema yang dipilih untuk layar sapa ini.
     */
    public function preset(): BelongsTo
    {
        return $this->belongsTo(ScreenPreset::class, 'selected_theme', 'slug');
    }

    /**
     * Alias method untuk preset() agar kompatibel dengan penamaan camelCase Laravel / PRD.
     */
    public function screenPreset(): BelongsTo
    {
        return $this->preset();
    }

    protected static function booted()
    {
        static::saved(fn ($screen) => Cache::forget("live_screen_output_{$screen->invitation_id}"));
        static::deleted(fn ($screen) => Cache::forget("live_screen_output_{$screen->invitation_id}"));
    }
}
