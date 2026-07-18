<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ScreenPreset extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail_image',
        'html_content',
        'zip_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $preset) {
            $preset->cleanupFiles();
        });
    }

    public function invitationScreens(): HasMany
    {
        return $this->hasMany(InvitationScreen::class, 'selected_theme', 'slug');
    }

    public function cleanupFiles(): void
    {
        $slug = $this->slug;

        $publicDir = public_path("screen-presets/{$slug}");
        if (File::isDirectory($publicDir)) {
            File::deleteDirectory($publicDir);
        }

        if ($this->thumbnail_image) {
            Storage::disk('public')->delete($this->thumbnail_image);
        }
    }
}
