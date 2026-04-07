<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
