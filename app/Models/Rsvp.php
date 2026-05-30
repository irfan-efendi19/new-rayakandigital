<?php

namespace App\Models;

use Database\Factories\RsvpFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    /** @use HasFactory<RsvpFactory> */
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'guest_id',
        'guest_name',
        'attendance',
        'pax',
    ];

    protected function casts(): array
    {
        return [
            'pax' => 'integer',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function attendanceLabel(): string
    {
        return match ($this->attendance) {
            'attending' => 'Hadir',
            'not_attending' => 'Tidak Hadir',
            'uncertain' => 'Mungkin Hadir',
            default => 'Belum Konfirmasi',
        };
    }
}
