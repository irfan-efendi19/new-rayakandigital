<?php

namespace App\Models;

use App\Support\UniqueSlugGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThemeCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $category) {
            if (empty($category->slug)) {
                $category->slug = UniqueSlugGenerator::generate(static::class, $category->name);
            }
        });

        static::updating(function (self $category) {
            if ($category->isDirty('name') && ! $category->isDirty('slug')) {
                $category->slug = UniqueSlugGenerator::generate(static::class, $category->name, 'slug', $category->id);
            }
        });
    }

    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class);
    }
}
