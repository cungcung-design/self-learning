<?php

namespace App\Models;

use App\Support\PublicImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'location',
        'contact_info',
        'check_in_time',
        'check_out_time',
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

    public function hotelImages(): HasMany
    {
        return $this->hasMany(HotelImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(HotelImage::class)->where('is_primary', true);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function imageUrl(): string
    {
        foreach ([$this->image, $this->primaryImage?->image_url] as $path) {
            if (! $path) {
                continue;
            }

            if (PublicImage::isRemote($path) || PublicImage::existingPath($path)) {
                $url = PublicImage::url($path, 'images/gallery1.jpg');
                $version = $this->updated_at?->timestamp;

                return $version ? $url.'?v='.$version : $url;
            }
        }

        return PublicImage::url(null, 'images/gallery1.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
