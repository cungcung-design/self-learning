<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'location',
        'rating',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'rating' => 'decimal:2',
        ];
    }

    public function featuredCategories(): BelongsToMany
    {
        return $this->belongsToMany(FeaturedCategory::class, 'hotel_featured_category');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'hotel_amenity');
    }

    public function imageUrl(): string
    {
        if ($this->image && is_file(public_path($this->image))) {
            return asset($this->image);
        }

        return asset('images/room1.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
