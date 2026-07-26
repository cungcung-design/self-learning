<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    // User bookings view
    public function index()
    {
        $bookings = auth()->user()
            ->bookings()
            ->with('adventure.category')
            ->latest()
            ->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings
        ]);
    }

    // Admin bookings management view
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'adventure.category'])
            ->latest()
            ->get();

        return Inertia::render('Admin/Bookings/Index', [
            'bookings' => $bookings
        ]);
    }

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

        return redirect()->route('user.payment.checkout', $booking->id);
    }

    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Booking cancelled successfully!');
    } 

    public function destroy(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully!');
    }
}