<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookings) {}

    public function index(Request $request): View
    {
        $bookings = Booking::query()
            ->with('room')
            ->ownedBy($request->user())
            ->latest()
            ->paginate(10);

        return view('home.my_bookings', compact('bookings'));
    }

    public function store(StoreBookingRequest $request, Room $room): RedirectResponse
    {
        $startDate = $request->date('start_date');
        $endDate = $request->date('end_date');

        if ($this->bookings->isUnavailable($room, $startDate, $endDate)) {
            return back()
                ->withInput()
                ->with('error', 'This room is already booked for these dates. Please try different dates.');
        }

        $this->bookings->create($room, $request->validated(), $request->user());

        return redirect()
            ->route('bookings.index')
            ->with('message', 'Your booking request was sent. We will confirm it by email shortly.');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorize('cancel', $booking);

        $this->bookings->cancel($booking);

        return back()->with('message', 'Your booking has been cancelled.');
    }
}
