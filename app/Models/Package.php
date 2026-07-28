<?php

namespace App\Models;

use App\Support\UniqueSlugGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_code',
        'package_name',
        'price',
        'slashed_price',
        'active_period_days',
        'description',
        'is_visible',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'slashed_price' => 'decimal:2',
        'is_visible' => 'boolean',
        'is_popular' => 'boolean',
        'active_period_days' => 'integer',
    ];

    protected $appends = ['slug'];

    protected static function booted(): void
    {
        static::creating(function (self $package) {
            if (empty($package->package_code)) {
                $package->package_code = UniqueSlugGenerator::generate(static::class, $package->package_name, 'package_code');
            }
        });

        static::updating(function (self $package) {
            if ($package->isDirty('package_name') && ! $package->isDirty('package_code')) {
                $package->package_code = UniqueSlugGenerator::generate(static::class, $package->package_name, 'package_code', $package->id);
            }
        });
    }

    public function getSlugAttribute(): string
    {
        return $this->package_code;
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(PlatformFeature::class, 'package_feature_pivots', 'package_id', 'feature_id');
    }
}
