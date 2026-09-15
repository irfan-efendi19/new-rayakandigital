<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Affiliate extends Model
{
    public const STATUSES = ['pending' => 'Menunggu verifikasi', 'approved' => 'Aktif', 'rejected' => 'Ditolak', 'suspended' => 'Ditangguhkan'];

    public const TYPES = ['wo' => 'Wedding Organizer', 'mua' => 'Makeup Artist', 'creator' => 'Creator', 'other' => 'Mitra lainnya'];

    protected $fillable = ['user_id', 'affiliate_tier_id', 'business_name', 'partner_type', 'phone', 'status', 'commission_rate', 'bank_name', 'bank_account_number', 'bank_account_holder', 'review_note', 'reviewed_by', 'reviewed_at'];

    protected $attributes = ['status' => 'pending'];

    protected $hidden = ['bank_account_number'];

    protected function casts(): array
    {
        return ['commission_rate' => 'decimal:2', 'bank_account_number' => 'encrypted', 'reviewed_at' => 'datetime'];
    }

    public function scopeEligible(Builder $query): void
    {
        $query->where('status', 'approved')->whereHas('user', fn ($query) => $query->where('is_banned', false));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(AffiliateTier::class, 'affiliate_tier_id');
    }

    public function links(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
    }

    public function promotion(): HasOne
    {
        return $this->hasOne(Promotion::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(AffiliateCommission::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(AffiliatePayout::class);
    }
}
