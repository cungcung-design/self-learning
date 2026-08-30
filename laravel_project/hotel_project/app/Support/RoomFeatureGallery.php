<?php

namespace App\Support;

use App\Models\Room;

class RoomFeatureGallery
{
    /**
     * @return list<string>
     */
    public static function paths(Room $room): array
    {
        $theme = self::themeFor((string) $room->room_name);
        $offset = max(0, (int) $room->id);
        $name = strtolower((string) $room->room_name);
        $amenities = $room->relationLoaded('roomAmenities')
            ? $room->roomAmenities->pluck('slug')
            : $room->roomAmenities()->pluck('slug');
        $amenities = $amenities->map(fn ($slug) => strtolower((string) $slug));

        $gallery = [];
        $bedrooms = self::bedroomSets()[$theme] ?? self::bedroomSets()['standard'];
        $mainPool = array_values(array_unique(array_merge(
            $bedrooms,
            self::bedroomSets()['standard'],
            self::bedroomSets()['king'],
            self::bedroomSets()['family'],
        )));

        $start = count($mainPool) > 0 ? $offset % count($mainPool) : 0;
        $rotatedMains = array_merge(array_slice($mainPool, $start), array_slice($mainPool, 0, $start));
        foreach ($rotatedMains as $path) {
            if (count($gallery) >= 4) {
                break;
            }
            self::addUnique($gallery, is_file(public_path($path)) ? $path : null);
        }

        self::addUnique($gallery, self::pick(self::featurePaths('bath'), $offset));
        self::addUnique($gallery, self::pick(self::featurePaths('shower'), $offset));

        $hasTub = $amenities->contains('bathtub')
            || str_contains($name, 'suite')
            || str_contains($name, 'villa')
            || str_contains($name, 'royal');
        if ($hasTub) {
            self::addUnique($gallery, self::pick(self::featurePaths('tub'), $offset));
        }

        $hasView = $amenities->contains('balcony')
            || str_contains($name, 'ocean')
            || str_contains($name, 'bay')
            || str_contains($name, 'beach')
            || str_contains($name, 'harbour')
            || str_contains($name, 'view')
            || str_contains($name, 'villa')
            || str_contains($name, 'pool');
        if ($hasView) {
            self::addUnique($gallery, self::pick(self::viewPaths($theme), $offset));
        }

        $hasLiving = str_contains($name, 'suite')
            || str_contains($name, 'villa')
            || str_contains($name, 'studio')
            || str_contains($name, 'family')
            || str_contains($name, 'royal');
        if ($hasLiving) {
            self::addUnique($gallery, self::pick(self::featurePaths('living'), $offset));
        }

        $hasDesk = str_contains($name, 'business')
            || str_contains($name, 'executive')
            || str_contains($name, 'harbour')
            || str_contains($name, 'studio');
        if ($hasDesk) {
            self::addUnique($gallery, self::pick(self::featurePaths('desk'), $offset));
        }

        return array_values(array_filter($gallery));
    }

    public static function sync(Room $room): void
    {
        $gallery = self::paths($room);
        if ($gallery === []) {
            return;
        }

        $room->roomImages()->delete();
        foreach ($gallery as $index => $path) {
            $room->roomImages()->create([
                'image_url' => $path,
                'is_primary' => $index === 0,
                'sort_order' => $index + 1,
            ]);
        }

        $room->update(['room_image' => $gallery[0]]);
    }

    /**
     * @return array<string, list<string>>
     */
    private static function bedroomSets(): array
    {
        return [
            'ocean' => [
                'images/rooms/ocean-1.jpg',
                'images/rooms/ocean-3.jpg',
                'images/rooms/family-2.jpg',
            ],
            'family' => [
                'images/rooms/family-2.jpg',
                'images/rooms/twin-1.jpg',
                'images/rooms/family-1.jpg',
            ],
            'twin' => [
                'images/rooms/twin-1.jpg',
                'images/rooms/family-1.jpg',
                'images/rooms/family-2.jpg',
            ],
            'suite' => [
                'images/rooms/ocean-3.jpg',
                'images/rooms/family-2.jpg',
                'images/rooms/king-1.jpg',
            ],
            'garden' => [
                'images/rooms/ocean-1.jpg',
                'images/rooms/family-1.jpg',
                'images/rooms/family-2.jpg',
            ],
            'villa' => [
                'images/rooms/ocean-4.jpg',
                'images/rooms/ocean-1.jpg',
                'images/rooms/ocean-3.jpg',
            ],
            'business' => [
                'images/rooms/family-1.jpg',
                'images/rooms/family-2.jpg',
                'images/rooms/king-1.jpg',
            ],
            'heritage' => [
                'images/rooms/ocean-3.jpg',
                'images/rooms/king-1.jpg',
                'images/rooms/family-2.jpg',
            ],
            'wellness' => [
                'images/rooms/ocean-1.jpg',
                'images/rooms/king-1.jpg',
                'images/rooms/family-1.jpg',
            ],
            'king' => [
                'images/rooms/king-1.jpg',
                'images/rooms/family-1.jpg',
                'images/rooms/family-2.jpg',
            ],
            'standard' => [
                'images/rooms/family-1.jpg',
                'images/rooms/king-1.jpg',
                'images/rooms/family-2.jpg',
            ],
        ];
    }

    /**
     * @return list<string>
     */
    private static function featurePaths(string $feature): array
    {
        return match ($feature) {
            'bath' => [
                'images/rooms/features/bath-1.jpg',
                'images/rooms/features/bath-2.jpg',
            ],
            'shower' => [
                'images/rooms/features/shower-1.jpg',
            ],
            'tub' => [
                'images/rooms/features/bath-3.jpg',
            ],
            'living' => [
                'images/rooms/suite-1.jpg',
                'images/rooms/garden-1.jpg',
                'images/rooms/king-2.jpg',
                'images/rooms/features/living-1.jpg',
                'images/rooms/features/living-4.jpg',
                'images/rooms/features/view-2.jpg',
            ],
            default => [
                'images/rooms/features/desk-1.jpg',
                'images/rooms/features/desk-2.jpg',
                'images/rooms/features/desk-3.jpg',
            ],
        };
    }

    /**
     * @return list<string>
     */
    private static function viewPaths(string $theme): array
    {
        return match ($theme) {
            'ocean' => [
                'images/rooms/villa-1.jpg',
                'images/rooms/ocean-2.jpg',
            ],
            'villa' => [
                'images/rooms/villa-1.jpg',
                'images/rooms/ocean-2.jpg',
                'images/rooms/features/view-1.jpg',
            ],
            'garden' => [
                'images/rooms/garden-1.jpg',
                'images/rooms/ocean-2.jpg',
                'images/rooms/features/view-1.jpg',
            ],
            'business' => [
                'images/rooms/business-1.jpg',
                'images/rooms/features/desk-1.jpg',
            ],
            default => [
                'images/rooms/business-1.jpg',
                'images/rooms/features/view-1.jpg',
                'images/rooms/villa-1.jpg',
            ],
        };
    }

    private static function themeFor(string $name): string
    {
        $name = strtolower($name);

        return match (true) {
            str_contains($name, 'ocean') || str_contains($name, 'bay') || str_contains($name, 'beach') => 'ocean',
            str_contains($name, 'family') => 'family',
            str_contains($name, 'twin') || str_contains($name, 'budget') => 'twin',
            str_contains($name, 'villa') => 'villa',
            str_contains($name, 'garden') || str_contains($name, 'pool') => 'garden',
            str_contains($name, 'suite') || str_contains($name, 'royal') => 'suite',
            str_contains($name, 'harbour') || str_contains($name, 'business') || str_contains($name, 'studio') => 'business',
            str_contains($name, 'heritage') || str_contains($name, 'colonial') => 'heritage',
            str_contains($name, 'wellness') || str_contains($name, 'detox') => 'wellness',
            str_contains($name, 'king') || str_contains($name, 'deluxe') => 'king',
            default => 'standard',
        };
    }

    /**
     * @param  list<string|null>  $items
     */
    private static function pick(array $items, int $offset): ?string
    {
        $items = array_values(array_filter($items, fn ($path) => is_string($path) && is_file(public_path($path))));
        if ($items === []) {
            return null;
        }

        return $items[$offset % count($items)];
    }

    /**
     * @param  list<string>  $gallery
     */
    private static function addUnique(array &$gallery, ?string $path): void
    {
        if ($path && ! in_array($path, $gallery, true)) {
            $gallery[] = $path;
        }
    }
}
