<?php

namespace App\Models;

use App\Support\PublicImage;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    public const TYPES = ['regular', 'premium', 'deluxe', 'suite'];

    protected $fillable = [
        'hotel_id',
        'room_name',
        'room_description',
        'room_price',
        'room_wifi',
        'room_type',
        'room_image',
        'max_guests',
        'beds',
        'bed_type',
        'room_size',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'room_price' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
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

    public function roomAmenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'room_amenity');
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
        foreach ([$this->room_image, $this->primaryImage?->image_url] as $path) {
            if (! $path) {
                continue;
            }

            if (PublicImage::isRemote($path) || PublicImage::existingPath($path)) {
                $url = PublicImage::url($path);
                $version = $this->updated_at?->timestamp;

                return $version ? $url.'?v='.$version : $url;
            }
        }

        return PublicImage::url(null);
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
