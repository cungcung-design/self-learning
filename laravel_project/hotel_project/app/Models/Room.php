<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function roomImages(): HasMany
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(RoomImage::class)->where('is_primary', true);
    }

    public function hasWifi(): bool
    {
        return strtolower((string) $this->room_wifi) === 'yes';
    }

    public function typeLabel(): string
    {
        return ucfirst((string) $this->room_type);
    }

    public function imageUrl(): string
    {
        $primary = $this->primaryImage?->image_url;

        if ($primary && is_file(public_path($primary))) {
            return asset($primary);
        }

        if ($this->room_image && is_file(public_path($this->room_image))) {
            return asset($this->room_image);
        }

        return asset('images/room1.jpg');
    }

    public function scopeOfType(Builder $query, ?string $type): Builder
    {
        return $query->when($type, fn (Builder $rooms) => $rooms->where('room_type', $type));
    }

    public function scopeAvailableBetween(Builder $query, ?CarbonInterface $start, ?CarbonInterface $end): Builder
    {
        if (! $start || ! $end || ! $end->gt($start)) {
            return $query;
        }

        return $query->whereDoesntHave('bookings', function (Builder $bookings) use ($start, $end) {
            $bookings->blocking()
                ->whereDate('start_date', '<', $end->toDateString())
                ->whereDate('end_date', '>', $start->toDateString());
        });
    }
}
