<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adventure;
use App\Models\Booking;
use App\Models\User;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $confirmedBookings = Booking::with('adventure')->where('status', 'confirmed')->get();
        $totalRevenue = $confirmedBookings->sum(fn($b) => $b->participants * ($b->adventure->price ?? 0));

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'adventures' => Adventure::count(),
                'bookings'   => Booking::count(),
                'users'      => User::count(),
                'revenue'    => $totalRevenue,
            ]
        ]);
    }
}