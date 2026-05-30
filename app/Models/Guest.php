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

    public function getPersonalizedLinkAttribute(): string
    {
        return route('invitation.show', $this->invitation->slug).'?to='.urlencode($this->name);
    }

    public function getWhatsappMessageAttribute(): string
    {
        $link = $this->personalized_link;
        $bride = $this->invitation->bride_name;
        $groom = $this->invitation->groom_name;

        return "Yth. {$this->name},\n\nKami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara pernikahan kami:\n\n✨ {$bride} & {$groom} ✨\n\nSilakan buka undangan digital Anda di:\n{$link}\n\nMerupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir. 🙏";
    }
}
