<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    public const TYPES = ['regular', 'premium', 'deluxe', 'suite'];

    protected $fillable = [
        'room_name',
        'room_description',
        'room_price',
        'room_wifi',
        'room_type',
        'room_image',
    ];

    protected function casts(): array
    {
        return [
            'room_price' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function hasWifi(): bool
    {
        return strtolower((string) $this->room_wifi) === 'yes';
    }

    public function imageUrl(): string
    {
        if ($this->room_image && is_file(public_path($this->room_image))) {
            return asset($this->room_image);
        }

        return asset('images/room1.jpg');
    }
}
