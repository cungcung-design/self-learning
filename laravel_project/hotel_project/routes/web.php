<?php

use App\Http\Controllers\Admin\AmenityController as AdminAmenityController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeaturedCategoryController as AdminFeaturedCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomImageController as AdminRoomImageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
use App\Models\Amenity;
use App\Models\Contact;
use App\Models\FeaturedCategory;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.public');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact.show');
Route::get('/featured-listings', [PageController::class, 'featured'])->name('featured.index');

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

    Route::post('/rooms/{room}/images', [AdminRoomImageController::class, 'store'])->name('rooms.images.store');
    Route::delete('/rooms/images/{roomImage}', [AdminRoomImageController::class, 'destroy'])->name('rooms.images.destroy');
    Route::post('/rooms/images/{roomImage}/primary', [AdminRoomImageController::class, 'setPrimary'])->name('rooms.images.primary');
    Route::post('/rooms/images/reorder', [AdminRoomImageController::class, 'reorder'])->name('rooms.images.reorder');

    Route::get('/hotels', [AdminHotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/create', [AdminHotelController::class, 'create'])->name('hotels.create');
    Route::post('/hotels', [AdminHotelController::class, 'store'])->name('hotels.store');
    Route::get('/hotels/{hotel}/edit', [AdminHotelController::class, 'edit'])->name('hotels.edit');
    Route::put('/hotels/{hotel}', [AdminHotelController::class, 'update'])->name('hotels.update');
    Route::delete('/hotels/{hotel}', [AdminHotelController::class, 'destroy'])->name('hotels.destroy');

    Route::get('/featured-categories', [AdminFeaturedCategoryController::class, 'index'])->name('featured_categories.index');
    Route::get('/featured-categories/create', [AdminFeaturedCategoryController::class, 'create'])->name('featured_categories.create');
    Route::post('/featured-categories', [AdminFeaturedCategoryController::class, 'store'])->name('featured_categories.store');
    Route::get('/featured-categories/{featuredCategory}/edit', [AdminFeaturedCategoryController::class, 'edit'])->name('featured_categories.edit');
    Route::put('/featured-categories/{featuredCategory}', [AdminFeaturedCategoryController::class, 'update'])->name('featured_categories.update');
    Route::delete('/featured-categories/{featuredCategory}', [AdminFeaturedCategoryController::class, 'destroy'])->name('featured_categories.destroy');

    Route::get('/amenities', [AdminAmenityController::class, 'index'])->name('amenities.index');
    Route::get('/amenities/create', [AdminAmenityController::class, 'create'])->name('amenities.create');
    Route::post('/amenities', [AdminAmenityController::class, 'store'])->name('amenities.store');
    Route::get('/amenities/{amenity}/edit', [AdminAmenityController::class, 'edit'])->name('amenities.edit');
    Route::put('/amenities/{amenity}', [AdminAmenityController::class, 'update'])->name('amenities.update');
    Route::delete('/amenities/{amenity}', [AdminAmenityController::class, 'destroy'])->name('amenities.destroy');

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
Route::redirect('/create_hotel', '/panel/hotels/create');
Route::redirect('/view_hotel', '/panel/hotels');
Route::redirect('/create_featured_category', '/panel/featured-categories/create');
Route::redirect('/view_featured_category', '/panel/featured-categories');
Route::redirect('/create_amenity', '/panel/amenities/create');
Route::redirect('/view_amenity', '/panel/amenities');

Route::get('/edit_room/{room}', function (Room $room) {
    return redirect()->route('admin.rooms.edit', $room);
});

Route::get('/edit_hotel/{hotel}', function (Hotel $hotel) {
    return redirect()->route('admin.hotels.edit', $hotel);
});

Route::get('/edit_featured_category/{featuredCategory}', function (FeaturedCategory $featuredCategory) {
    return redirect()->route('admin.featured_categories.edit', $featuredCategory);
});

Route::get('/edit_amenity/{amenity}', function (Amenity $amenity) {
    return redirect()->route('admin.amenities.edit', $amenity);
});

Route::get('/reply_email/{contact}', function (Contact $contact) {
    return redirect()->route('admin.messages.reply', $contact);
});
