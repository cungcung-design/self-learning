<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Review;
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
        $reviewsCount = $user->reviews()->count();

        $upcomingAdventure = $user->bookings()
            ->where('status', 'confirmed')
            ->with('adventure')
            ->orderBy('booking_date', 'asc')
            ->first();

        $recentBookings = $user->bookings()
            ->with('adventure')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($b) => [
                'id' => $b->id,
                'title' => $b->adventure->title ?? 'Adventure',
                'location' => $b->adventure->location ?? '',
                'date' => $b->booking_date,
                'status' => $b->status,
            ]);

        $recommendedAdventures = \App\Models\Adventure::with('category')
            ->inRandomOrder()
            ->take(4)
            ->get()
            ->map(fn($a) => [
                'id' => $a->id,
                'title' => $a->title,
                'price' => $a->price,
                'rating' => number_format($a->reviews()->avg('rating') ?? 4.5, 1),
                'image' => $a->image,
            ]);

        return Inertia::render('User/Dashboard/Index', [
            'user' => $user,
            'stats' => [
                'total_bookings' => $totalBookings,
                'upcoming_trips' => $upcomingTrips,
                'favorites' => $favoritesCount,
                'reviews' => $reviewsCount,
            ],
            'upcomingAdventure' => $upcomingAdventure ? [
                'id' => $upcomingAdventure->id,
                'title' => $upcomingAdventure->adventure->title,
                'location' => $upcomingAdventure->adventure->location,
                'booking_date' => $upcomingAdventure->booking_date,
                'participants' => $upcomingAdventure->participants,
                'status' => $upcomingAdventure->status,
                'image' => $upcomingAdventure->adventure->image,
                'duration' => $upcomingAdventure->adventure->duration,
            ] : null,
            'recentBookings' => $recentBookings,
            'recommendedAdventures' => $recommendedAdventures,
        ]);
    }
}
