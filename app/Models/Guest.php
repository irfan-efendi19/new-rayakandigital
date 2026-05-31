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
                $guest->slug = static::resolveDuplicateSlug(
                    $guest->invitation_id,
                    Str::slug($guest->name)
                );
            }
        });

        static::updating(function (Guest $guest) {
            if ($guest->isDirty('name') && ! $guest->isDirty('slug')) {
                $guest->slug = static::resolveDuplicateSlug(
                    $guest->invitation_id,
                    Str::slug($guest->name),
                    $guest->id
                );
            }
        });
    }

    protected static function resolveDuplicateSlug(int $invitationId, string $slug, ?int $excludeId = null): string
    {
        $baseSlug = $slug;
        $counter = 1;

        while (true) {
            $query = static::where('invitation_id', $invitationId)
                ->where('slug', $slug);

            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }

            if (! $query->exists()) {
                return $slug;
            }

            $counter++;
            $slug = $baseSlug . '-' . $counter;
        }
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
        return route('invitation.show', $this->invitation->slug).'?to='.urlencode($this->slug);
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
