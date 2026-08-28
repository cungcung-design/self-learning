<?php

namespace App\Support;

class PublicImage
{
    public static function url(?string $path, string $fallback = 'images/room4.jpg'): string
    {
        if (self::isRemote($path)) {
            return $path;
        }

        return asset(self::path($path, $fallback));
    }

    public static function path(?string $path, string $fallback = 'images/room4.jpg'): string
    {
        return self::existingPath($path)
            ?? (is_file(public_path($fallback)) ? $fallback : 'images/room4.jpg');
    }

    public static function existingPath(?string $path): ?string
    {
        if (self::isRemote($path)) {
            return null;
        }

        foreach (self::candidates($path) as $candidate) {
            if (is_file(public_path($candidate))) {
                return $candidate;
            }
        }

        return null;
    }

    public static function isRemote(?string $path): bool
    {
        if (! is_string($path) || $path === '') {
            return false;
        }

        return str_starts_with($path, 'http://')
            || str_starts_with($path, 'https://')
            || str_starts_with($path, '//');
    }

    /**
     * @return list<string>
     */
    private static function candidates(?string $path): array
    {
        if (! is_string($path) || trim($path) === '') {
            return [];
        }

        $path = str_replace('\\', '/', trim($path));
        $path = preg_replace('#^public/#', '', $path) ?? $path;
        $path = ltrim($path, '/');
        $filename = basename($path);

        return array_values(array_unique(array_filter([
            $path,
            'images/'.$filename,
            'admin/img/'.$filename,
            'admin/img/rooms/'.$filename,
            'admin/img/hotels/'.$filename,
            'admin/img/gallery/'.$filename,
            'storage/'.$path,
        ])));
    }
}
