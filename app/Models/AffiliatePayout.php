<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliatePayout extends Model
{
    public const STATUSES = ['pending' => 'Menunggu persetujuan', 'approved' => 'Menunggu transfer', 'paid' => 'Sudah ditransfer', 'rejected' => 'Ditolak'];

    protected $fillable = ['affiliate_id', 'amount', 'status', 'bank_name', 'bank_account_number', 'bank_account_holder', 'processed_by', 'review_note', 'transfer_reference', 'paid_at'];

    protected $attributes = ['status' => 'pending'];

    protected $hidden = ['bank_account_number'];

    protected function casts(): array
    {
        return ['amount' => 'integer', 'bank_account_number' => 'encrypted', 'paid_at' => 'datetime'];
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }
}
