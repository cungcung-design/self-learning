<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Contact;
use App\Notifications\SendEmailNotification;

class UserController extends Controller
{
    public function room_details($id)
    {
        $room = Room::findOrFail($id);

        return view('home.room_details', compact('room'));
    }

    public function add_booking(Request $request, $id)
    {
        Room::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $isBooked = Booking::where('room_id', $id)
            ->whereNotIn('status', ['rejected'])
            ->where('start_date', '<', $end_date)
            ->where('end_date', '>', $start_date)
            ->exists();

        if ($isBooked) {
            return redirect()->route('home')->with('error', 'This room is already booked for these dates. Please try different dates.');
        }

        $booking = new Booking;
        $booking->room_id = $id;
        $booking->name = $request->input('name');
        $booking->email = $request->input('email');
        $booking->phone = $request->input('phone');
        $booking->start_date = $start_date;
        $booking->end_date = $end_date;
        $booking->status = 'pending';

        // Optional: do not attach logged-in user to booking.
        // This prevents auth-related session issues from affecting booking persistence.
        try {
            $booking->save();
        } catch (\Throwable $e) {
            \Log::error('Booking save failed: ' . $e->getMessage(), [
                'room_id' => $id,
                'user_id' => Auth::check() ? Auth::id() : null,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'request' => $request->all(),
            ]);

            return redirect()->route('home')
                ->with('error', 'Booking could not be saved. Please try again.');
        }

        if (Auth::check()) {
            try {

                return redirect()->route('home')->with('message', 'Room booked successfully!');
            } catch (\Throwable $e) {
                // IMPORTANT: never break the booking flow due to mail issues.
                // Some exception/redirect edge-cases can look like the user got logged out.
                \Log::error('Email notification failed: ' . $e->getMessage(), [
                    'user_id' => Auth::id(),
                    'room_id' => $id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);

                return redirect()->route('home')->with('message', 'Room booked successfully!');
            }
        }

        return redirect()->route('home')->with('message', 'Room booked successfully!');

    }



public function contact(Request $request)
{
    $contact = new Contact;

    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->phone = $request->phone;
    $contact->message = $request->message;

    $contact->save();

    return redirect()->back()->with('message', 'Contact saved successfully!');
}

}
