<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRoomsRequest;
use App\Models\Gallery;
use App\Models\Room;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly BookingService $bookings) {}

    public function index(SearchRoomsRequest $request): View
    {
        $roomsQuery = Room::query()->latest();

        if ($request->filled('room_type')) {
            $roomsQuery->where('room_type', $request->string('room_type'));
        }

        if ($request->hasDateRange()) {
            $startDate = $request->date('start_date');
            $endDate = $request->date('end_date');

            $roomsQuery->whereDoesntHave('bookings', function ($bookings) use ($startDate, $endDate) {
                $bookings->blocking()
                    ->whereDate('start_date', '<', $endDate->toDateString())
                    ->whereDate('end_date', '>', $startDate->toDateString());
            });
        }

        return view('home.index', [
            'rooms' => $roomsQuery->get(),
            'gallery' => Gallery::query()->latest()->get(),
            'filters' => $request->only(['start_date', 'end_date', 'room_type']),
            'searching' => $request->hasDateRange() || $request->filled('room_type'),
        ]);
    }

    public function redirectAuthenticated(): RedirectResponse
    {
        if (auth()->user()?->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home.public'));
    }

    public function showRoom(Request $request, Room $room): View
    {
        if (! $request->user()) {
            $request->session()->put('url.intended', $request->fullUrl());
        }

        $startDate = $request->date('start_date');
        $endDate = $request->date('end_date');
        $unavailable = false;

        if ($startDate && $endDate && $endDate->gt($startDate)) {
            $unavailable = $this->bookings->isUnavailable($room, $startDate, $endDate);
        }

        return view('home.room_details', [
            'room' => $room,
            'unavailable' => $unavailable,
        ]);
    }
}
