<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImageController extends Controller
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function store(Request $request, Room $room): JsonResponse
    {
        $request->validate([
            'room_images' => ['required', 'array', 'max:10'],
            'room_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $uploaded = [];
        $maxSort = $room->roomImages()->max('sort_order') ?? 0;

        foreach ($request->file('room_images', []) as $index => $file) {
            if (!$file) {
                continue;
            }

            $path = $this->images->store($file, 'admin/img/rooms');

            $roomImage = $room->roomImages()->create([
                'image_url' => $path,
                'is_primary' => false,
                'sort_order' => $maxSort + $index + 1,
            ]);

            $uploaded[] = $roomImage;
        }

        if ($uploaded === []) {
            return response()->json(['message' => 'No valid images were uploaded.'], 422);
        }

        return response()->json([
            'message' => 'Images uploaded successfully.',
            'images' => $uploaded,
        ]);
    }

    public function destroy(RoomImage $roomImage): RedirectResponse
    {
        $room = $roomImage->room;
        $wasPrimary = $roomImage->is_primary;

        $this->images->delete($roomImage->image_url);
        $roomImage->delete();

        if ($wasPrimary) {
            $next = $room->roomImages()->orderByDesc('sort_order')->first();
            if ($next) {
                $next->update(['is_primary' => true]);
                $room->update(['room_image' => $next->image_url]);
            } else {
                $room->update(['room_image' => null]);
            }
        }

        return back()->with('message', 'Image deleted successfully.');
    }

    public function setPrimary(RoomImage $roomImage): RedirectResponse
    {
        $room = $roomImage->room;
        $room->roomImages()->update(['is_primary' => false]);
        $roomImage->update(['is_primary' => true]);
        $room->update(['room_image' => $roomImage->image_url]);

        return back()->with('message', 'Primary image updated successfully.');
    }

    public function reorder(Request $request, Room $room): \Symfony\Component\HttpFoundation\Response
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:room_images,id'],
        ]);

        $orderedIds = $request->input('order', []);
        $roomImages = $room->roomImages()->get()->keyBy('id');

        foreach ($orderedIds as $index => $id) {
            if (isset($roomImages[$id])) {
                $roomImages[$id]->update(['sort_order' => $index + 1]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Image order updated successfully.']);
        }

        return back()->with('message', 'Image order updated successfully.');
    }
}
