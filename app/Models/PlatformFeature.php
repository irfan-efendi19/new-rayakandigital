<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class PlatformFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'feature_key',
        'feature_name',
        'group_name',
        'description',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $feature) {
            if (empty($feature->feature_key)) {
                $feature->feature_key = Str::slug($feature->feature_name);
            }
        });

        static::updating(function (self $feature) {
            if ($feature->isDirty('feature_name') && !$feature->isDirty('feature_key')) {
                $feature->feature_key = Str::slug($feature->feature_name);
            }
        });
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_feature_pivots', 'feature_id', 'package_id');
    }
}
