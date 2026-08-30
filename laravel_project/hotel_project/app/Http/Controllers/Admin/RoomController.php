<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Http\Requests\Admin\UpdateRoomRequest;
use App\Models\Room;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function index(Request $request): View
    {
        $rooms = Room::query()
            ->with(['hotel', 'primaryImage'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where(function ($inner) use ($search) {
                    $inner->where('room_name', 'like', $search)
                        ->orWhere('room_type', 'like', $search);
                });
            })
            ->when($request->filled('hotel_id'), function ($query) use ($request) {
                $query->where('hotel_id', $request->integer('hotel_id'));
            })
            ->when($request->filled('room_type'), function ($query) use ($request) {
                $query->where('room_type', $request->string('room_type'));
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('is_available', $request->boolean('status'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_room', [
            'rooms' => $rooms,
            'hotels' => \App\Models\Hotel::query()->orderBy('name')->get(),
        ]);
    }

    public function show(Room $room): View
    {
        return view('admin.show_room', [
            'room' => $room->load(['hotel', 'roomImages', 'roomAmenities']),
        ]);
    }

    public function create(): View
    {
        return view('admin.create_room', [
            'hotels' => \App\Models\Hotel::query()->orderBy('name')->get(),
            'amenities' => \App\Models\Amenity::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['room_images'], $data['amenity_ids'], $data['room_image']);

        $room = Room::query()->create($data);

        if ($request->filled('amenity_ids')) {
            $room->roomAmenities()->sync($request->input('amenity_ids', []));
        }

        if ($request->hasFile('room_images')) {
            $primaryIndex = (int) $request->input('primary_image_index', 0);
            foreach ($request->file('room_images') as $index => $file) {
                if (!$file) {
                    continue;
                }

                $path = $this->images->store($file, 'admin/img/rooms');
                $isPrimary = $index === $primaryIndex;

                $room->roomImages()->create([
                    'image_url' => $path,
                    'is_primary' => $isPrimary,
                    'sort_order' => $index + 1,
                ]);

                if ($isPrimary) {
                    $room->update(['room_image' => $path]);
                }
            }
        }

        return redirect()
            ->route('admin.rooms.index')
            ->with('message', 'Room added successfully');
    }

    public function edit(Room $room): View
    {
        return view('admin.edit_room', [
            'room' => $room->load(['roomImages', 'roomAmenities']),
            'hotels' => \App\Models\Hotel::query()->orderBy('name')->get(),
            'amenities' => \App\Models\Amenity::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        $data = $request->validated();
        unset($data['room_images'], $data['amenity_ids'], $data['delete_image_ids'], $data['primary_image_id']);

        if (! is_string($data['room_image'] ?? null)) {
            unset($data['room_image']);
        }

        if ($request->hasFile('room_image')) {
            $oldPath = $room->room_image;
            $data['room_image'] = $this->images->store($request->file('room_image'), 'admin/img/rooms');

            $primary = $room->roomImages()->where('is_primary', true)->first()
                ?? $room->roomImages()->orderBy('sort_order')->first();

            if ($primary) {
                $oldPrimaryPath = $primary->image_url;
                $primary->update([
                    'image_url' => $data['room_image'],
                    'is_primary' => true,
                ]);
                $room->roomImages()->where('id', '!=', $primary->id)->update(['is_primary' => false]);
                $this->images->delete($oldPrimaryPath);
            } else {
                $room->roomImages()->create([
                    'image_url' => $data['room_image'],
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            $this->images->delete($oldPath);
        }

        $room->update($data);

        if ($request->filled('amenity_ids')) {
            $room->roomAmenities()->sync($request->input('amenity_ids', []));
        } else {
            $room->roomAmenities()->detach();
        }

        if ($request->filled('delete_image_ids')) {
            foreach ($request->input('delete_image_ids', []) as $imageId) {
                $image = $room->roomImages()->find($imageId);
                if ($image) {
                    $this->images->delete($image->image_url);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('room_images')) {
            $maxSort = $room->roomImages()->max('sort_order') ?? 0;
            $hasPrimary = $room->roomImages()->where('is_primary', true)->exists();
            foreach ($request->file('room_images') as $index => $file) {
                if (!$file) {
                    continue;
                }

                $path = $this->images->store($file, 'admin/img/rooms');
                $isPrimary = ! $hasPrimary && $index === 0;
                $room->roomImages()->create([
                    'image_url' => $path,
                    'is_primary' => $isPrimary,
                    'sort_order' => $maxSort + $index + 1,
                ]);

                if ($isPrimary) {
                    $room->update(['room_image' => $path]);
                    $hasPrimary = true;
                }
            }
        }

        if ($request->filled('primary_image_id')) {
            $primary = $room->roomImages()->find($request->input('primary_image_id'));
            if ($primary) {
                $room->roomImages()->update(['is_primary' => false]);
                $primary->update(['is_primary' => true]);
                $room->update(['room_image' => $primary->image_url]);
            }
        }

        return redirect()
            ->route('admin.rooms.index')
            ->with('message', 'Room updated successfully');
    }

    public function destroy(Room $room): RedirectResponse
    {
        if ($room->bookings()->exists()) {
            return back()->with('error', 'This room cannot be deleted because it has bookings.');
        }

        foreach ($room->roomImages as $image) {
            $this->images->delete($image->image_url);
        }

        $this->images->delete($room->room_image);
        $room->roomImages()->delete();
        $room->roomAmenities()->detach();
        $room->delete();

        return back()->with('message', 'Room deleted successfully');
    }
}
