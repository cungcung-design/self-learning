<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Public Homepage
Route::get('/', [AdminController::class, 'home'])
    ->name('home_public');


// Login Home Route
Route::get('/home', [AdminController::class, 'index'])
    ->middleware('auth')
    ->name('home');

// User room details page should remain at /room_details/{id}



// User can view room details
Route::get('/room_details/{id}', [UserController::class, 'room_details'])
    ->name('room_details');


// User booking
Route::post('/add_booking/{id}', [UserController::class, 'add_booking'])
    ->name('add_booking')
    ->middleware('auth');


// Contact form
Route::post('/contact', [UserController::class, 'contact'])
    ->name('contact');



// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {


    // Room Management

    Route::get('/create_room', [AdminController::class, 'create_room'])
        ->name('create_room');

    Route::post('/add_room', [AdminController::class, 'add_room'])
        ->name('add_room');

    Route::get('/view_room', [AdminController::class, 'view_room'])
        ->name('view_room');

    Route::get('/edit_room/{id}', [AdminController::class, 'edit_room'])
        ->name('edit_room');

    Route::post('/update_room/{id}', [AdminController::class, 'update_room'])
        ->name('update_room');

    Route::get('/delete_room/{id}', [AdminController::class, 'delete_room'])
        ->name('delete_room');



    // Booking Management

    Route::get('/view_booking', [AdminController::class, 'view_booking'])
        ->name('view_booking');

    Route::get('/delete_booking/{id}', [AdminController::class, 'delete_booking'])
        ->name('delete_booking');

    Route::get('/approve_booking/{id}', [AdminController::class, 'approve_booking'])
        ->name('approve_booking');

    Route::get('/reject_booking/{id}', [AdminController::class, 'reject_booking'])
        ->name('reject_booking');



    // Gallery Management

    Route::get('/view_gallery', [AdminController::class, 'view_gallery'])
        ->name('view_gallery');

    Route::post('/upload_gallery', [AdminController::class, 'upload_gallery'])
        ->name('upload_gallery');

    Route::get('/delete_gallery/{id}', [AdminController::class, 'delete_gallery'])
        ->name('delete_gallery');



    // Message Management

    Route::get('/view_message', [AdminController::class, 'view_message'])
        ->name('view_message');

    Route::get('/reply_email/{id}', [AdminController::class, 'reply_email'])
        ->name('reply_email');

    Route::post('/send_email/{id}', [AdminController::class, 'send_email'])
        ->name('send_email');

});