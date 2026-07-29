<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Adventure extends Model
{
    use LogsActivity;

    protected $fillable = [
        'category_id', 'title', 'description', 'location',
        'price', 'difficulty', 'duration', 'max_people', 'image',
        'google_maps_url',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function schedules()
    {
        return $this->hasMany(AdventureSchedule::class);
    }

    public function images()
    {
        return $this->hasMany(AdventureImage::class)
            ->orderBy('sort_order');
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
