<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
use App\Models\Contact;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.public');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact.show');

Route::get('/home', [HomeController::class, 'redirectAuthenticated'])
    ->middleware('auth')
    ->name('home');

Route::get('/dashboard', [HomeController::class, 'redirectAuthenticated'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::post('/rooms/{room}/bookings', [BookingController::class, 'store'])
    ->middleware(['auth', 'throttle:bookings'])
    ->name('bookings.store');

Route::middleware('auth')->group(function () {
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

Route::middleware(['auth', 'admin'])->prefix('panel')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/rooms', [AdminRoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [AdminRoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [AdminRoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/email', [AdminBookingController::class, 'sendEmail'])->name('bookings.email');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{contact}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::post('/messages/{contact}/reply', [MessageController::class, 'sendReply'])->name('messages.send');
});

Route::get('/room_details/{room}', function (Room $room) {
    return redirect()->route('rooms.show', $room);
});

Route::redirect('/create_room', '/panel/rooms/create');
Route::redirect('/view_room', '/panel/rooms');
Route::redirect('/view_booking', '/panel/bookings');
Route::redirect('/view_gallery', '/panel/gallery');
Route::redirect('/view_message', '/panel/messages');

Route::get('/edit_room/{room}', function (Room $room) {
    return redirect()->route('admin.rooms.edit', $room);
});

Route::get('/reply_email/{contact}', function (Contact $contact) {
    return redirect()->route('admin.messages.reply', $contact);
});
