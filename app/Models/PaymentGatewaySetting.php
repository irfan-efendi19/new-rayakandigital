<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name',
        'client_key',
        'server_key',
        'webhook_secret',
        'environment',
        'is_active',
    ];

    protected $casts = [
        'client_key' => 'encrypted',
        'server_key' => 'encrypted',
        'webhook_secret' => 'encrypted',
        'is_active' => 'boolean',
    ];
}
