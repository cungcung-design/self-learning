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
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where(function ($inner) use ($search) {
                    $inner->where('room_name', 'like', $search)
                        ->orWhere('room_type', 'like', $search);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_room', compact('rooms'));
    }

    public function create(): View
    {
        return view('admin.create_room');
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('room_image')) {
            $data['room_image'] = $this->images->store($request->file('room_image'), 'admin/img/rooms');
        }

        Room::query()->create($data);

        return redirect()
            ->route('admin.rooms.index')
            ->with('message', 'Room created successfully!');
    }

    public function edit(Room $room): View
    {
        return view('admin.edit_room', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('room_image')) {
            $data['room_image'] = $this->images->replace(
                $room->room_image,
                $request->file('room_image'),
                'admin/img/rooms'
            );
        }

        $room->update($data);

        return redirect()
            ->route('admin.rooms.index')
            ->with('message', 'Room updated successfully!');
    }

    public function destroy(Room $room): RedirectResponse
    {
        if ($room->bookings()->exists()) {
            return back()->with('error', 'This room cannot be deleted because it has bookings.');
        }

        $this->images->delete($room->room_image);
        $room->delete();

        return back()->with('message', 'Room deleted successfully!');
    }
}
