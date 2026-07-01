<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddonTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_order_id',
        'invitation_id',
        'addon_id',
        'amount',
        'payment_status',
        'snap_token',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function addon(): BelongsTo
    {
        return $this->belongsTo(Addon::class);
    }
}
