<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Room;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $approvedBookings = Booking::query()
            ->with('room')
            ->where('status', Booking::STATUS_APPROVED)
            ->get();

        return view('admin.index', [
            'roomCount' => Room::query()->count(),
            'bookingCount' => Booking::query()->count(),
            'pendingBookingCount' => Booking::query()->where('status', Booking::STATUS_PENDING)->count(),
            'messageCount' => Contact::query()->count(),
            'checkInsToday' => Booking::query()
                ->where('status', Booking::STATUS_APPROVED)
                ->whereDate('start_date', today())
                ->count(),
            'estimatedRevenue' => $approvedBookings->sum(fn (Booking $booking) => $booking->totalAmount()),
            'recentBookings' => Booking::query()->with('room')->latest()->limit(5)->get(),
            'recentMessages' => Contact::query()->latest()->limit(5)->get(),
        ]);
    }
}
