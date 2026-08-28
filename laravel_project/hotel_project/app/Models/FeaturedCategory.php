<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FeaturedCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'hotel_featured_category');
    }
}
