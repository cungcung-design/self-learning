<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdventureAvailabilityController;
use App\Http\Controllers\AdventureController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 1. Your Custom Homepage Route (Must be at the top)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Adventure public/resource routes
Route::resource('adventures', AdventureController::class);

// Public availability endpoint for calendar (used on both guest & authenticated pages)
Route::get('/adventures/{adventure}/availability', [AdventureAvailabilityController::class, 'index'])->name('adventures.availability');

// 3. Authenticated User Dashboard (redirect based on role)
Route::middleware('auth')->group(function () {
    // Generic dashboard redirect based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');
});

// =====================
// Admin Route Group
// =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Booking Management
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
    Route::patch('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Adventure Management (Admin CRUD)
    Route::resource('adventures', AdventureController::class)->except(['show']);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
});

// =====================
// User Route Group
// =====================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::post('/bookings', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
    Route::delete('/bookings/{booking}', [UserBookingController::class, 'destroy'])->name('bookings.destroy');

    // Profile
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Favorites
    Route::post('/favorites', [FavoriteController::class, 'toggleFavorite'])->name('favorites.store');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // Payment
    Route::get('/payment/{booking}', [PaymentController::class, 'checkout'])->name('payment.checkout');

    Route::get('/payment/{booking}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');

    Route::post('/payment/{booking}/pay', [PaymentController::class, 'process'])->name('payment.process');
});

// 5. Breeze Authentication Routes (login, register, password reset, etc.)
require __DIR__.'/auth.php';
