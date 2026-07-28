<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adventure extends Model // Renamed from adventures
{
    protected $fillable = [
        'category_id', 'title', 'description', 'location',
        'price', 'difficulty', 'duration', 'max_people', 'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class); // Changed from Category::class
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
