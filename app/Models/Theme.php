<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'view_path',
        'thumbnail',
        'is_premium',
        'is_active',
    ];
}
