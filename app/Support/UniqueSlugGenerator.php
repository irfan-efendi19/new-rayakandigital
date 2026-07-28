<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UniqueSlugGenerator
{
    /**
     * Generate a unique slug for the given model and column.
     *
     * If the base slug already exists, appends a random 5-character suffix.
     * Keeps retrying with new random suffixes until a unique slug is found.
     *
     * @param  class-string<Model>  $modelClass
     * @param  string  $value  The original text to slugify.
     * @param  string  $column  The database column name for the slug.
     * @param  int|null  $ignoreId  Record ID to exclude (for updates).
     */
    public static function generate(string $modelClass, string $value, string $column = 'slug', ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);

        $query = $modelClass::where($column, $baseSlug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if (! $query->exists()) {
            return $baseSlug;
        }

        // Slug exists, append random suffix and keep trying
        do {
            $candidateSlug = $baseSlug.'-'.Str::lower(Str::random(5));
        } while ($modelClass::where($column, $candidateSlug)->exists());

        return $candidateSlug;
    }
}
