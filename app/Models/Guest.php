<?php

namespace App\Models;

use Database\Factories\GuestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Guest extends Model
{
    /** @use HasFactory<GuestFactory> */
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'slug',
        'phone',
        'address',
    ];

    protected static function booted(): void
    {
        static::creating(function (Guest $guest) {
            if (empty($guest->slug)) {
                $guest->slug = Str::slug($guest->name, '_');
            }
        });
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function whatsappLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WhatsappLog::class);
    }

    public function getPersonalizedLinkAttribute(): string
    {
        return route('invitation.show', $this->invitation->slug).'?to='.urlencode($this->name);
    }

    public function getWhatsappMessageAttribute(): string
    {
        return $this->invitation->parseWhatsappTemplate($this);
    }

    public function getWaStatusAttribute(): ?string
    {
        $latestLog = $this->relationLoaded('whatsappLogs')
            ? $this->whatsappLogs->first()
            : $this->whatsappLogs()->latest()->first();

        return $latestLog?->status;
    }
}
