<?php

namespace App\Models;

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
        $path = str_starts_with((string) $this->image, 'admin/')
            ? $this->image
            : 'admin/img/gallery/'.$this->image;

        if (is_file(public_path($path))) {
            return asset($path);
        }

        return asset('images/gallery1.jpg');
    }

    public function imagePath(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'admin/')
            ? $this->image
            : 'admin/img/gallery/'.$this->image;
    }
}
