<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Adventure;
use App\Models\Payment;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $monthlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyRevenue[] = Payment::whereMonth('created_at', $month)
                ->where('status', 'paid')
                ->sum('amount');
        }

        $bookingStatus = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        $popularAdventures = Adventure::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        return Inertia::render('Admin/Reports/Index', [
            'monthlyRevenue' => $monthlyRevenue,
            'bookingStatus' => $bookingStatus,
            'popularAdventures' => $popularAdventures,
            'totalUsers' => User::count(),
            'totalBookings' => Booking::count(),
            'totalRevenue' => Payment::where('status', 'paid')->sum('amount'),
        ]);
    }
}
