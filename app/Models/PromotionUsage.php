<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionUsage extends Model
{
    protected $fillable = ['promotion_id', 'user_id', 'email', 'order_id', 'discount_applied', 'confirmed_at', 'released_at'];

    protected function casts(): array
    {
        return ['discount_applied' => 'decimal:2', 'confirmed_at' => 'datetime', 'released_at' => 'datetime'];
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
