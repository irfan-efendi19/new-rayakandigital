<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationScreen extends Model
{
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
}
