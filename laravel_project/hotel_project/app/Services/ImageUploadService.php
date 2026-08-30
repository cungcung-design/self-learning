<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageUploadService
{
    public function store(UploadedFile $file, string $directory): string
    {
        $directory = trim($directory, '/');
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $destination = public_path($directory);

        if (! File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $file->move($destination, $filename);

        return $directory.'/'.$filename;
    }

    public function replace(?string $existingPath, UploadedFile $file, string $directory): string
    {
        $this->delete($existingPath);

        return $this->store($file, $directory);
    }

    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if (! str_starts_with($normalized, 'admin/img/hotels/')
            && ! str_starts_with($normalized, 'admin/img/rooms/')
            && ! str_starts_with($normalized, 'admin/img/gallery/')) {
            return;
        }

        $fullPath = public_path($normalized);

        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }
}
