<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function processPayment(Booking $booking, array $data): Payment
    {
        return DB::transaction(function () use ($booking, $data) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'method' => $data['method'] ?? 'online',
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $booking->update(['status' => 'confirmed']);

            return $payment;
        });
    }
}
