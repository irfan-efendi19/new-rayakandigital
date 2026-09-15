<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    protected $fillable = [
        'title', 'code', 'discount_type', 'discount_value', 'max_discount_amount',
        'min_order_amount', 'package_ids', 'timer_type', 'start_time', 'end_time',
        'evergreen_duration_minutes', 'usage_limit', 'per_user_limit', 'is_active',
    ];

    protected $attributes = [
        'discount_type' => 'PERCENTAGE', 'timer_type' => 'STATIC',
        'min_order_amount' => 0, 'used_count' => 0, 'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2', 'max_discount_amount' => 'decimal:2',
            'min_order_amount' => 'decimal:2', 'package_ids' => 'array',
            'start_time' => 'immutable_datetime', 'end_time' => 'immutable_datetime',
            'evergreen_duration_minutes' => 'integer', 'usage_limit' => 'integer',
            'per_user_limit' => 'integer', 'used_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Promotion $promotion) {
            $promotion->usages()->delete();
            $promotion->sessions()->delete();
            Order::where('promotion_id', $promotion->id)->update(['promotion_id' => null]);
        });
    }

    public function setCodeAttribute(?string $code): void
    {
        $this->attributes['code'] = filled($code) ? mb_strtoupper(trim($code)) : null;
    }

    public function usages(): HasMany
    {
        return $this->hasMany(PromotionUsage::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(PromotionSession::class);
    }

    public function discountFor(int $amount): int
    {
        $discount = $this->discount_type === 'PERCENTAGE'
            ? (int) floor($amount * min(100, (float) $this->discount_value) / 100)
            : (int) $this->discount_value;

        if ($this->max_discount_amount !== null) {
            $discount = min($discount, (int) $this->max_discount_amount);
        }

        return max(0, min($amount, $discount));
    }
}
