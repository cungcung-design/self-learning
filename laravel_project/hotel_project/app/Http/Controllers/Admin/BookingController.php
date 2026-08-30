<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\BookingStatusNotification;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookings) {}

    public function index(Request $request): View
    {
        $bookings = Booking::query()
            ->with(['room', 'user'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search)
                        ->orWhere('phone', 'like', $search);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_booking', compact('bookings'));
    }

    public function approve(Booking $booking): RedirectResponse
    {
        $this->bookings->updateStatus($booking, Booking::STATUS_APPROVED);

        return back()->with('message', 'Changes saved successfully');
    }

    public function reject(Booking $booking): RedirectResponse
    {
        $this->bookings->updateStatus($booking, Booking::STATUS_REJECTED);

        return back()->with('message', 'Changes saved successfully');
    }

    public function sendEmail(Booking $booking): RedirectResponse
    {
        $booking->loadMissing(['room', 'user']);

        if (! $booking->user && ! $booking->email) {
            return back()->with('error', 'Unable to save changes. Please try again.');
        }

        $this->bookings->notifyGuest($booking, new BookingStatusNotification($booking));

        return back()->with('message', 'Changes saved successfully');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('message', 'Changes saved successfully');
    }
}
