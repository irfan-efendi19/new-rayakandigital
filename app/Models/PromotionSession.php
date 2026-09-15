<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionSession extends Model
{
    protected $fillable = ['promotion_id', 'user_id', 'visitor_key', 'expires_at'];

    protected function casts(): array
    {
        return ['expires_at' => 'immutable_datetime'];
    }
}
