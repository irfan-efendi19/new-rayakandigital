<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingAsset extends Model
{
    public const CATEGORIES = ['banner' => 'Banner promo', 'story' => 'Story Instagram', 'brochure' => 'Brosur digital'];

    protected $fillable = ['title', 'category', 'description', 'file_path', 'is_active'];

    protected $attributes = ['is_active' => true];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
