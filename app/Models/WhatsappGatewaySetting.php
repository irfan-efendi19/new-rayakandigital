<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappGatewaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name',
        'api_url',
        'api_token',
        'device_id',
        'delay_seconds',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'api_url' => 'encrypted',
            'api_token' => 'encrypted',
            'device_id' => 'encrypted',
            'delay_seconds' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
