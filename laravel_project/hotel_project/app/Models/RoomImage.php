<?php

namespace App\Models;

use App\Support\PublicImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomImage extends Model
{
    protected $fillable = [
        'room_id',
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

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function imageUrl(): string
    {
        return PublicImage::url($this->image_url);
    }

    public function featureLabel(): string
    {
        $path = strtolower((string) $this->image_url);
        $file = basename($path);

        return match (true) {
            str_contains($path, '/features/shower') => 'Shower',
            str_contains($path, '/features/tub') => 'Bathtub',
            str_contains($path, '/features/bath-3') => $this->is_primary ? 'Main bedroom' : 'Bathtub',
            str_contains($path, '/features/bath') => 'Bathroom',
            str_contains($path, '/features/view-2') => 'Living area',
            str_contains($path, '/features/view') => 'Room view',
            str_contains($path, '/features/living') => 'Living area',
            str_contains($path, '/features/desk') => 'Workspace',
            in_array($file, ['ocean-2.jpg', 'villa-1.jpg', 'business-1.jpg', 'heritage-1.jpg', 'view-1.jpg', 'view-3.jpg'], true) => 'Room view',
            in_array($file, ['suite-1.jpg', 'garden-1.jpg', 'king-2.jpg'], true) => 'Living area',
            $this->is_primary => 'Main bedroom',
            default => 'Sleeping area',
        };
    }
}
