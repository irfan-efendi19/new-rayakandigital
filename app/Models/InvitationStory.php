<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationStory extends Model
{
    protected $fillable = [
        'invitation_id',
        'story_date',
        'story_title',
        'story_description',
        'order_position',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
