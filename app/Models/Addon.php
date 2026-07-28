<?php

namespace App\Models;

use App\Support\UniqueSlugGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'icon_identifier',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $addon) {
            if (empty($addon->slug)) {
                $addon->slug = UniqueSlugGenerator::generate(static::class, $addon->name);
            }
        });

        static::updating(function (self $addon) {
            if ($addon->isDirty('name') && ! $addon->isDirty('slug')) {
                $addon->slug = UniqueSlugGenerator::generate(static::class, $addon->name, 'slug', $addon->id);
            }
        });
    }

    public function invitations(): BelongsToMany
    {
        return $this->belongsToMany(Invitation::class)
            ->withPivot(['purchased_price', 'status_active', 'activated_at'])
            ->withTimestamps();
    }
}
