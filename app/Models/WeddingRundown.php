<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingRundown extends Model
{
    protected $fillable = [
        'user_id',
        'time_start',
        'time_end',
        'activity_name',
        'person_in_charge',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'time_start' => 'datetime:H:i',
            'time_end' => 'datetime:H:i',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
