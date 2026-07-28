<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use Carbon\Carbon;

class AdventureAvailabilityController extends Controller
{
    /**
     * Return available dates for a given adventure.
     */
    public function index(Adventure $adventure)
    {
        $dates = [];
        $today = Carbon::today();

        // Generate availability for the next 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = $today->copy()->addDays($i);
            $bookedCount = $adventure->bookings()
                ->whereDate('booking_date', $date)
                ->whereIn('status', ['pending', 'confirmed'])
                ->sum('participants');

            $remaining = $adventure->max_people - $bookedCount;

            $status = 'available';
            if ($remaining <= 0) {
                $status = 'full';
            } elseif ($remaining <= ceil($adventure->max_people * 0.2)) {
                $status = 'almost_full';
            }

            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'remaining' => max(0, $remaining),
                'status' => $status,
            ];
        }

        return response()->json($dates);
    }
}
