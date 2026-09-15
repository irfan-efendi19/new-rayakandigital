<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    use HasFactory;

    protected $attributes = [
        'affiliate_discount_rate' => 20,
    ];

    protected $fillable = [
        'demo_duration_days',
        'demo_grace_period_days',
        'wa_blast_quota_limit',
        'whatsapp_number',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'affiliate_commission_rate',
        'affiliate_discount_rate',
        'affiliate_minimum_payout',
    ];

    protected $casts = [
        'demo_duration_days' => 'integer',
        'demo_grace_period_days' => 'integer',
        'wa_blast_quota_limit' => 'integer',
        'affiliate_commission_rate' => 'decimal:2',
        'affiliate_discount_rate' => 'decimal:2',
        'affiliate_minimum_payout' => 'integer',
    ];
}
