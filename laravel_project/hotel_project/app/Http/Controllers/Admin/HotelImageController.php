<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelImageController extends Controller
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function store(Request $request, Hotel $hotel): JsonResponse
    {
        $request->validate([
            'hotel_images' => ['required', 'array', 'max:10'],
            'hotel_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $uploaded = [];
        $maxSort = $hotel->hotelImages()->max('sort_order') ?? 0;

        foreach ($request->file('hotel_images', []) as $index => $file) {
            if (!$file) {
                continue;
            }

            $path = $this->images->store($file, 'admin/img/hotels');

            $hotelImage = $hotel->hotelImages()->create([
                'image_url' => $path,
                'is_primary' => false,
                'sort_order' => $maxSort + $index + 1,
            ]);

            $uploaded[] = $hotelImage;
        }

        if ($uploaded === []) {
            return response()->json(['message' => 'No valid images were uploaded.'], 422);
        }

        return response()->json([
            'message' => 'Images uploaded successfully.',
            'images' => $uploaded,
        ]);
    }

    public function destroy(HotelImage $hotelImage): RedirectResponse
    {
        $hotel = $hotelImage->hotel;
        $wasPrimary = $hotelImage->is_primary;

        $this->images->delete($hotelImage->image_url);
        $hotelImage->delete();

        if ($wasPrimary) {
            $next = $hotel->hotelImages()->orderByDesc('sort_order')->first();
            if ($next) {
                $next->update(['is_primary' => true]);
                $hotel->update(['image' => $next->image_url]);
            } else {
                $hotel->update(['image' => null]);
            }
        }

        return back()->with('message', 'Image deleted successfully.');
    }

    public function setPrimary(HotelImage $hotelImage): RedirectResponse
    {
        $hotel = $hotelImage->hotel;
        $hotel->hotelImages()->update(['is_primary' => false]);
        $hotelImage->update(['is_primary' => true]);
        $hotel->update(['image' => $hotelImage->image_url]);

        return back()->with('message', 'Primary image updated successfully.');
    }

    public function reorder(Request $request, Hotel $hotel): \Symfony\Component\HttpFoundation\Response
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:hotel_images,id'],
        ]);

        $orderedIds = $request->input('order', []);
        $hotelImages = $hotel->hotelImages()->get()->keyBy('id');

        foreach ($orderedIds as $index => $id) {
            if (isset($hotelImages[$id])) {
                $hotelImages[$id]->update(['sort_order' => $index + 1]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Image order updated successfully.']);
        }

        return back()->with('message', 'Image order updated successfully.');
    }
}
