<?php

namespace App\Models;

use App\Support\PublicImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelImage extends Model
{
    protected $fillable = [
        'hotel_id',
        'image_url',
        'is_primary',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function imageUrl(): string
    {
        return PublicImage::url($this->image_url, 'images/gallery1.jpg');
    }
}
