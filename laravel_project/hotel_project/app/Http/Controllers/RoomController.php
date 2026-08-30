<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRoomsRequest;
use App\Models\Room;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(private readonly BookingService $bookings) {}

    public function index(SearchRoomsRequest $request): View
    {
        $rooms = Room::query()
            ->ofType($request->input('room_type'))
            ->availableBetween(
                $request->hasDateRange() ? $request->date('start_date') : null,
                $request->hasDateRange() ? $request->date('end_date') : null,
            )
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('home.rooms', [
            'rooms' => $rooms,
            'filters' => $request->only(['start_date', 'end_date', 'room_type']),
            'searching' => $request->hasDateRange() || $request->filled('room_type'),
        ]);
    }

    public function show(Request $request, Room $room): View
    {
        if (! $request->user()) {
            $request->session()->put('url.intended', $request->fullUrl());
        }

        $startDate = $request->date('start_date');
        $endDate = $request->date('end_date');
        $unavailable = false;
        $nights = 1;

        if ($startDate && $endDate && $endDate->gt($startDate)) {
            $unavailable = $this->bookings->isUnavailable($room, $startDate, $endDate);
            $nights = max(1, (int) $startDate->diffInDays($endDate));
        }

        return view('home.room_details', [
            'room' => $room->load(['roomImages', 'roomAmenities', 'hotel']),
            'unavailable' => $unavailable,
            'nights' => $nights,
            'filters' => $request->only(['start_date', 'end_date']),
        ]);
    }
}
