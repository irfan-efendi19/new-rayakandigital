<?php

namespace App\Models;

use App\Support\UniqueSlugGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ScreenPreset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail_image',
        'html_content',
        'zip_path',
        'storage_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $preset) {
            if (empty($preset->slug)) {
                $preset->slug = UniqueSlugGenerator::generate(static::class, $preset->name);
            }
        });

        static::updating(function (self $preset) {
            if ($preset->isDirty('name') && ! $preset->isDirty('slug')) {
                $preset->slug = UniqueSlugGenerator::generate(static::class, $preset->name, 'slug', $preset->id);
            }
        });

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
        // Hapus folder storage baru (PRD: screen-templates/{slug})
        if ($this->storage_path && Storage::disk('public')->exists($this->storage_path)) {
            Storage::disk('public')->deleteDirectory($this->storage_path);
        }

        if ($this->thumbnail_image) {
            Storage::disk('public')->delete($this->thumbnail_image);
        }
    }
}
