<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateTier extends Model
{
    protected $fillable = ['name', 'commission_rate'];

    protected $attributes = [];

    protected function casts(): array
    {
        return ['commission_rate' => 'decimal:2'];
    }
}
