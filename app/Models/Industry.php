<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'image', 'description',
        'sub_items', 'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sub_items' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
