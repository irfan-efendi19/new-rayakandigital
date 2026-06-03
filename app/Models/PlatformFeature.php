<?php

namespace App\Models;

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

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_feature_pivots', 'feature_id', 'package_id');
    }
}
