<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'view_path',
        'thumbnail_portrait',
        'is_premium',
        'is_active',
        'theme_category_id',
    ];

    public function themeCategory(): BelongsTo
    {
        return $this->belongsTo(ThemeCategory::class);
    }
}
