<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdventureSchedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display user's bookings.
     */
    public function index()
    {
        $bookings = auth()->user()
            ->bookings()
            ->with(['adventure.category', 'schedule'])
            ->latest()
            ->get();

        return Inertia::render('User/Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request, BookingService $service)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:adventure_schedules,id',
            'participants' => 'required|integer|min:1',
        ]);

        $booking = $service->storeBooking(auth()->id(), $validated);

        return redirect()
            ->route('user.payment.checkout', $booking->id)
            ->with('success', 'Booking submitted successfully! Proceed to payment.');
    }

    /**
     * Delete a booking (user-facing cancel = delete).
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully.');
    }
}
