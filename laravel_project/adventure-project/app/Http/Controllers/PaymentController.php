<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReceiptMail;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function checkout(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->load('adventure');

        $payment = Payment::where('booking_id', $booking->id)->first();

        return Inertia::render('User/Payment/Checkout', [
            'booking' => $booking,
            'payment' => $payment,
        ]);
    }

    public function process(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method' => 'required|string|in:stripe,toyyibpay,paypal'
        ]);

        $booking->load('adventure');

        $payment = Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'payment_method' => $request->payment_method,
                'amount' => $booking->participants * $booking->adventure->price,
                'status' => 'pending'
            ]
        );

        return redirect()->route('payment.success', ['booking' => $booking->id]);
    }

    public function success(Booking $booking)
    {
        $payment = $booking->payment()->first();

        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        if ($payment) {
            $payment->update([
                'status' => 'paid',
                'transaction_id' => 'TXN' . strtoupper(uniqid()),
                'paid_at' => Carbon::now()
            ]);
        }

        $booking->load(['user', 'adventure', 'payment']);

        $booking->user->notify(new \App\Notifications\BookingStatusNotification($booking));

        Mail::to($booking->user->email)->send(new PaymentReceiptMail($booking));

        return redirect()->route('user.bookings.index')
            ->with('success', 'Payment successful! Booking confirmed.');
    }

    public function cancel(Booking $booking)
    {
        $payment = $booking->payment()->first();

        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        $booking->update(['payment_status' => 'failed']);

        return redirect()->route('user.bookings.index')
            ->with('error', 'Payment process was cancelled.');
    }
}
