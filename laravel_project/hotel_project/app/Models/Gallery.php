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
        foreach ($this->candidatePaths() as $path) {
            if (is_file(public_path($path))) {
                return asset($path);
            }
        }

        return asset('images/blog1.jpg');
    }

    public function imagePath(): ?string
    {
        foreach ($this->candidatePaths() as $path) {
            if (is_file(public_path($path))) {
                return $path;
            }
        }

        return $this->image ?: null;
    }

    /**
     * @return list<string>
     */
    private function candidatePaths(): array
    {
        $image = (string) $this->image;

        if ($image === '') {
            return [];
        }

        if (str_contains($image, '/')) {
            return [$image];
        }

        return [
            'admin/img/gallery/'.$image,
            'images/'.$image,
        ];
    }
}
