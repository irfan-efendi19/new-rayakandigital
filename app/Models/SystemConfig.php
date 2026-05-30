<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'demo_duration_days',
        'demo_grace_period_days',
        'whatsapp_number',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
    ];

    protected $casts = [
        'demo_duration_days' => 'integer',
        'demo_grace_period_days' => 'integer',
    ];
}
