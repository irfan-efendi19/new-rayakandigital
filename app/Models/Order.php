<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'invitation_id',
        'package_type',
        'payment_method_used',
        'gross_amount',
        'unique_code',
        'payment_status',
        'payment_gateway_used',
        'is_manual_whatsapp',
        'verified_by',
        'snap_token',
        'doku_va_number',
        'doku_channel_code',
        'doku_expired_at',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount' => 'decimal:2',
            'unique_code' => 'integer',
            'is_manual_whatsapp' => 'boolean',
            'doku_expired_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getInvoiceIdAttribute(): string
    {
        $id = $this->id;
        $date = $this->created_at ? $this->created_at->format('Ymd') : now()->format('Ymd');

        return 'RD-'.$date.'-'.str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    public function getTotalWithCodeAttribute(): string
    {
        return number_format((float) $this->gross_amount + $this->unique_code, 0, ',', '.');
    }

    public function getTotalWithCodeRawAttribute(): float
    {
        return (float) $this->gross_amount + $this->unique_code;
    }

    public static function generateUniqueCode(): int
    {
        return random_int(100, 999);
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeVerifying($query)
    {
        return $query->where('payment_status', 'verifying');
    }

    public function scopeManualBank($query)
    {
        return $query->where('payment_method_used', 'manual_bank');
    }

    public function scopeMidtrans($query)
    {
        return $query->where('payment_method_used', 'midtrans');
    }

    public function scopeDoku($query)
    {
        return $query->where('payment_method_used', 'doku');
    }
}
