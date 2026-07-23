<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Gallery;
use App\Models\Contact;
use Notification;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AdminController extends Controller
{
    /**
     * Handle user redirection based on role (Admin vs User)
     */
   public function index()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            
            if ($usertype === 'admin') {
                return view('admin.index');
            } 
            
            elseif ($usertype === 'user') {
                $rooms = Room::all();
                $gallery = Gallery::all();

                return view('home.index', compact('rooms', 'gallery'));
            }
            else{
                return redirect('')->back();
            }
        }
        
        return redirect('/');
    }

    /**
     * Show the public home page
     */
    public function home()
    {
        $rooms = Room::all();
        $gallery = Gallery::all();
        return view('home.index', compact('rooms', 'gallery'));
    }

    /**
     * Show the "Create Room" page for Admins
     */
    public function create_room()
    {
        // Extra security to ensure only admins can view this page
        if (! Auth::check() || Auth::user()->usertype !== 'admin') {
            return redirect('login')->with('error', 'Unauthorized access.');
        }

        return view('admin.create_room');
    }

    /**
     * Save a new room to the database
     */
    public function add_room(Request $request)
    {
        if (! Auth::check() || Auth::user()->usertype !== 'admin') {
            return redirect('login')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'room_name' => 'required|string|max:255',
            'room_description' => 'nullable|string',
            'room_price' => 'required|numeric|min:0',
            'room_wifi' => 'required|string',
            'room_type' => 'required|string',
            'room_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $room = new Room;
        $room->room_name = $request->room_name;
        $room->room_description = $request->room_description;
        $room->room_price = $request->room_price;
        $room->room_wifi = $request->room_wifi;
        $room->room_type = $request->room_type;

        // Handle Image Upload
        if ($request->hasFile('room_image')) {
            $file = $request->file('room_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $destinationDir = public_path('admin/img/rooms');

            // Create directory if it doesn't exist
            if (! File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true);
            }

            $file->move($destinationDir, $filename);
            $room->room_image = 'admin/img/rooms/'.$filename;
        }

        $room->save();

        return redirect()->back()->with('message', 'Room created successfully!');
    }

    /**
     * View all rooms in the Admin Panel
     */
    public function view_room()
    {
        if (! Auth::check() || Auth::user()->usertype !== 'admin') {
            return redirect('login')->with('error', 'Unauthorized access.');
        }

        $rooms = Room::all();   
        return view('admin.view_room', compact('rooms'));
    }

    /**
     * Show the "Edit Room" page
     */
    public function edit_room($id)
    {
        if (! Auth::check() || Auth::user()->usertype !== 'admin') {
            return redirect('login')->with('error', 'Unauthorized access.');
        }

        $room = Room::findOrFail($id);
        return view('admin.edit_room', compact('room'));
    }

    /**
     * Update an existing room in the database
     */
    public function update_room(Request $request, $id)
    {
        if (! Auth::check() || Auth::user()->usertype !== 'admin') {
            return redirect('login')->with('error', 'Unauthorized access.');
        }

        // FIXED: Using $room instead of $roomData
        $room = Room::findOrFail($id);

        $request->validate([
            'room_name' => 'required|string|max:255',
            'room_description' => 'nullable|string',
            'room_price' => 'required|numeric|min:0',
            'room_wifi' => 'required|string',
            'room_type' => 'required|string',
            'room_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $room->room_name = $request->room_name;
        $room->room_description = $request->room_description;
        $room->room_price = $request->room_price;
        $room->room_wifi = $request->room_wifi;
        $room->room_type = $request->room_type;

        // Handle Image Update
        if ($request->hasFile('room_image')) {
            $file = $request->file('room_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $destinationDir = public_path('admin/img/rooms');
            
            // BONUS: Delete the OLD image from the server to save space
            if ($room->room_image && File::exists(public_path($room->room_image))) {
                File::delete(public_path($room->room_image));
            }
            
            $file->move($destinationDir, $filename);
            
            $room->room_image = 'admin/img/rooms/'.$filename;
        }

        $room->save();

        return redirect()->back()->with('message', 'Room updated successfully!');
    }

    /**
     * Delete a room from the database
     */
    public function delete_room($id)
    {
        if (! Auth::check() || Auth::user()->usertype !== 'admin') {
            return redirect('login')->with('error', 'Unauthorized access.');
        }

        $room = Room::findOrFail($id);

        // FIXED: Removed the extra spaces in the property name
        // Delete the room image file if it exists
        if ($room->room_image && File::exists(public_path($room->room_image))) {
            File::delete(public_path($room->room_image));
        }   
        
        $room->delete();

        return redirect()->back()->with('message', 'Room deleted successfully!');
    }

    public function view_booking()
    {
        // Eager load room relationship to avoid N+1 and prevent null relation surprises
        $bookings = Booking::with('room')->get();
        return view('admin.view_booking', compact('bookings'));
    }
    public function delete_booking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->back()->with('message', 'Booking deleted successfully!');
    }
  public function approve_booking($id)
  {
    $booking = Booking::findOrFail($id);
    $booking->status = 'approved';
    $booking->save();
    
    return redirect()->back()->with('message', 'Booking approved successfully!');   
  }

    public function reject_booking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'rejected';
        $booking->save();
        
        return redirect()->back()->with('message', 'Booking rejected successfully!');   
    }

    public function view_gallery()
    {

        $galleries = Gallery::all();
        return view('admin.view_gallery', compact('galleries'));
    }
    public function upload_gallery(Request $request)
    {
        $gallery = new Gallery;
        $image = $request->image;   
        if($image){
            $imageName = time() . '.' . $image->getClientOriginalExtension();
$image->move(public_path('admin/img/gallery'), $imageName);
            $gallery->image = $imageName;
            $gallery->image = $imageName;
            $gallery->save();
        }
        return redirect()->back()->with('message', 'Image uploaded successfully!');
    }

    public function delete_gallery($id)
    {
        $gallery = Gallery::findOrFail($id);

        $gallery->delete();

        return redirect()->back()->with('message', 'Image deleted successfully!');
    }

    public function view_message()
    {
        $message = Contact::all();
        return view('admin.view_message', compact('message'));
    }
    public function reply_email($id)
    {
        $message = Contact::findOrFail($id);
        return view('admin.reply_email', compact('message'));
    }

    public function send_email($id)
    {
        $booking = Booking::findOrFail($id);
        $user = $booking->user;

        if (!$user) {
            return redirect()->back()->with('error', 'No user account linked to this booking.');
        }

        $user->notify(new SendEmailNotification());

        return redirect()->back()->with('message', 'Email sent successfully!');
    }
}
