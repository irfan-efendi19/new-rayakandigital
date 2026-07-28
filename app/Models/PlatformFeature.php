<?php

namespace App\Models;

use App\Support\UniqueSlugGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
                $feature->feature_key = UniqueSlugGenerator::generate(static::class, $feature->feature_name, 'feature_key');
            }
        });

        static::updating(function (self $feature) {
            if ($feature->isDirty('feature_name') && ! $feature->isDirty('feature_key')) {
                $feature->feature_key = UniqueSlugGenerator::generate(static::class, $feature->feature_name, 'feature_key', $feature->id);
            }
        });
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_feature_pivots', 'feature_id', 'package_id');
    }
}
