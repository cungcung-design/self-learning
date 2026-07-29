<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->with('adventure')->latest()->take(5)->get();

        $totalBookings = $user->bookings()->count();
        $upcomingTrips = $user->bookings()->where('status', 'confirmed')->count();
        $favoritesCount = $user->favorites()->count();

        $upcomingAdventure = $user->bookings()
            ->where('status', 'confirmed')
            ->with('adventure')
            ->orderBy('booking_date', 'asc')
            ->first();

        return Inertia::render('User/Dashboard/Index', [
            'user' => $user,
            'stats' => [
                'total_bookings' => $totalBookings,
                'upcoming_trips' => $upcomingTrips,
                'favorites' => $favoritesCount,
            ],
            'upcomingAdventure' => $upcomingAdventure ? [
                'id' => $upcomingAdventure->id,
                'title' => $upcomingAdventure->adventure->title,
                'booking_date' => $upcomingAdventure->booking_date,
                'participants' => $upcomingAdventure->participants,
                'status' => $upcomingAdventure->status,
            ] : null,
        ]);
    }
}
