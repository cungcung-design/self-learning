<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        $bookings = Booking::with('adventure')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return Inertia::render(
            'Dashboard/Index',
            [

                'bookings' => $bookings,

                'user' => $user,

            ]
        );

    }
}
