<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adventure;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $monthlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyRevenue[] = Booking::whereMonth('bookings.created_at', $month)
                ->whereYear('bookings.created_at', Carbon::now()->year)
                ->join('adventures', 'bookings.adventure_id', '=', 'adventures.id')
                ->sum(DB::raw('adventures.price * bookings.participants'));
        }

        return Inertia::render('Admin/Dashboard', [
            'adventures' => Adventure::count(),
            'bookings' => Booking::count(),
            'users' => User::count(),
            'revenue' => Booking::join('adventures', 'bookings.adventure_id', '=', 'adventures.id')
                ->sum(DB::raw('adventures.price * bookings.participants')) ?? 0,

            'revenueLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'revenueValues' => $monthlyRevenue,

            'bookingStats' => [
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'cancelled' => Booking::where('status', 'cancelled')->count(),
            ],

            'topAdventures' => Adventure::withCount('bookings')
                ->orderByDesc('bookings_count')
                ->take(3)
                ->get(),

            'recentBookings' => Booking::with(['user', 'adventure'])
                ->latest()
                ->take(3)
                ->get(),

            'latestReviews' => Review::with(['user', 'adventure'])
                ->latest()
                ->take(3)
                ->get(),

            'financialReports' => [
                'today' => Payment::where('status', 'paid')
                    ->whereDate('paid_at', Carbon::today())
                    ->sum('amount'),
                'week' => Payment::where('status', 'paid')
                    ->whereBetween('paid_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->sum('amount'),
                'month' => Payment::where('status', 'paid')
                    ->whereMonth('paid_at', Carbon::now()->month)
                    ->sum('amount'),
                'total' => Payment::where('status', 'paid')->sum('amount'),
            ],
        ]);
    }
}
