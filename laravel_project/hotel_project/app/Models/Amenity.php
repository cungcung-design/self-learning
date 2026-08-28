<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'hotel_amenity');
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'room_amenity');
    }
}
