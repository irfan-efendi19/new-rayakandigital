<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InvitationEvent extends Model
{
    protected $fillable = [
        'invitation_id',
        'event_title',
        'event_date',
        'start_time',
        'end_time',
        'is_until_finished',
        'place_name',
        'place_address',
        'google_maps_url',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_until_finished' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class, 'event_guest', 'event_id', 'guest_id')
            ->withTimestamps();
    }
}
