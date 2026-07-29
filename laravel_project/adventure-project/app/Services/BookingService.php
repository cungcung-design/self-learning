<?php

namespace App\Services;

use App\Models\AdventureSchedule;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function storeBooking(int $userId, array $data): Booking
    {
        return DB::transaction(function () use ($userId, $data) {
            $schedule = AdventureSchedule::findOrFail($data['schedule_id']);

            $remainingSeats = $schedule->capacity - $schedule->booked;

            if ($schedule->status === 'full' || $data['participants'] > $remainingSeats) {
                abort(422, 'Selected trip does not have enough remaining seats.');
            }

            $booking = Booking::create([
                'user_id' => $userId,
                'adventure_id' => $schedule->adventure_id,
                'schedule_id' => $schedule->id,
                'booking_date' => $schedule->trip_date,
                'participants' => $data['participants'],
                'total_price' => $schedule->adventure->price * $data['participants'],
                'status' => 'pending',
            ]);

            $schedule->increment('booked', $data['participants']);

            if ($schedule->booked >= $schedule->capacity) {
                $schedule->update(['status' => 'full']);
            }

            return $booking;
        });
    }
}
