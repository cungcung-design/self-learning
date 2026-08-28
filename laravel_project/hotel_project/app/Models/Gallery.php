<?php

namespace App\Models;

use App\Support\PublicImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
    ];

    public function imageUrl(): string
    {
        return PublicImage::url($this->image, 'images/blog1.jpg');
    }

    public function imagePath(): ?string
    {
        return PublicImage::existingPath($this->image) ?: ($this->image ?: null);
    }
}
