<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'adventure_id' => 'required|exists:adventures,id',
            'booking_date' => 'required|date',
            'participants' => 'required|integer|min:1',
        ]);

        $booking = $request->user()->bookings()->create([
            'adventure_id' => $request->adventure_id,
            'booking_date' => $request->booking_date,
            'participants' => $request->participants,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking created successfully via API',
            'booking' => $booking,
        ], 201);
    }
}
