<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    protected static function booted(): void
    {
        static::deleting(function (self $theme) {
            $theme->cleanupFiles();
        });
    }

    public function themeCategory(): BelongsTo
    {
        return $this->belongsTo(ThemeCategory::class);
    }

    public function cleanupFiles(): void
    {
        $viewPath = $this->view_path;

        if (! $viewPath) {
            return;
        }

        if (str_starts_with($viewPath, 'themes.custom.')) {
            $slug = Str::after($viewPath, 'themes.custom.');

            $bladePath = resource_path("views/themes/custom/{$slug}.blade.php");
            if (File::exists($bladePath)) {
                File::delete($bladePath);
            }

            $publicDir = public_path("themes/custom/{$slug}");
            if (File::isDirectory($publicDir)) {
                File::deleteDirectory($publicDir);
            }
        }

        if ($this->thumbnail_portrait) {
            Storage::disk('public')->delete($this->thumbnail_portrait);
        }
    }
}
