<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodConfig extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'active_method',
        'manual_bank_name',
        'manual_account_number',
        'manual_account_name',
        'admin_whatsapp_number',
        'midtrans_client_key',
        'midtrans_server_key',
        'midtrans_environment',
        'doku_client_id',
        'doku_secret_key',
        'doku_private_key',
        'doku_environment',
    ];

    protected function casts(): array
    {
        return [
            'midtrans_environment' => 'string',
            'doku_environment' => 'string',
        ];
    }

    public static function getActive(): ?self
    {
        return static::first();
    }

    public function isManualBank(): bool
    {
        return $this->active_method === 'manual_bank';
    }

    public function isMidtrans(): bool
    {
        return $this->active_method === 'midtrans';
    }

    public function isDoku(): bool
    {
        return $this->active_method === 'doku';
    }
}
