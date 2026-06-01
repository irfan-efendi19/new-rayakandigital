<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'view_path',
        'thumbnail_portrait',
        'is_premium',
        'is_active',
    ];
}
