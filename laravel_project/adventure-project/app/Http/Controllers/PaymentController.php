<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmedMail;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function checkout(Booking $booking)
    {
        // 0. Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        // 1. Eager load the adventure relationship so we can access its price
        $booking->load('adventure');

        // 2. Check if a payment record already exists for this booking to avoid duplicates
        $payment = Payment::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'amount' => $booking->participants * $booking->adventure->price,
                'status' => 'pending',
            ]
        );

        // 3. Pass both the booking (with its adventure) and payment details to Vue
        return Inertia::render('User/Payment/Checkout', [
            'booking' => $booking,
            'payment' => $payment,
        ]);
    }

    public function processPaymentCallback(Request $request, Booking $booking)
    {
        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'payment_id' => $request->input('transaction_id'),
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Payment verified and recorded successfully.');
    }

    public function process(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->update(['status' => 'confirmed']);
        $booking->payment()->update(['status' => 'paid']);

        $booking->load(['user', 'adventure']);

        Mail::to($booking->user->email)->send(new BookingConfirmedMail($booking));

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking confirmed successfully!');

    }
}
