<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
            ->with('adventure.category')
            ->latest()
            ->get();

        return Inertia::render('User/Bookings/Index', [
            'bookings' => $bookings
        ]);
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'adventure_id' => 'required|exists:adventures,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'participants' => 'required|integer|min:1',
        ]);

        $booking = Booking::create([
            'user_id'      => auth()->id(),
            'adventure_id' => $validated['adventure_id'],
            'booking_date' => $validated['booking_date'],
            'participants' => $validated['participants'],
            'status'       => 'pending',
        ]);

        return redirect()
            ->route('user.payment.checkout', $booking->id)
            ->with('success', 'Booking submitted successfully! Proceed to payment.');
    }

    /**
     * Delete a booking (user-facing cancel = delete).
     */
    public function destroy(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully.');
    }

}
