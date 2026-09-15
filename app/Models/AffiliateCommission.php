<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateCommission extends Model
{
    protected $fillable = ['affiliate_id', 'order_id', 'sale_amount', 'rate', 'amount', 'status'];

    protected $attributes = ['status' => 'earned'];

    protected function casts(): array
    {
        return ['sale_amount' => 'integer', 'rate' => 'decimal:2', 'amount' => 'integer'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
