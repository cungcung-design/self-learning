<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdventureAvailabilityController;
use App\Http\Controllers\AdventureController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Booking Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::patch('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');

    // Adventure Management (Admin CRUD)
    Route::get('/adventures', [AdventureController::class, 'adminIndex'])->name('adventures.index');
    Route::get('/adventures/{adventure}', [AdventureController::class, 'adminShow'])->name('adventures.show');
    Route::resource('adventures', AdventureController::class)->except(['index', 'show']);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [\App\Http\Controllers\Admin\ReportExportController::class, 'excel'])->name('reports.excel');
    Route::get('/reports/export/pdf', [\App\Http\Controllers\Admin\ReportExportController::class, 'pdf'])->name('reports.pdf');

    // Activity Logs
    Route::get('/activities', [\App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activities.index');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Invoice Download
    Route::get('/bookings/{booking}/invoice', [AdminBookingController::class, 'downloadInvoice'])->name('bookings.invoice');
});

// Payment Gateway Callback (public, no auth required)
Route::post('/payment/callback/{booking}', [PaymentController::class, 'processPaymentCallback'])->name('payment.callback');

// =====================
// User Route Group
// =====================
Route::middleware(['auth', 'client'])->prefix('user')->name('user.')->group(function () {
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
    Route::post('/adventures/{adventure}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{adventure}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{adventure}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Payment
    Route::get('/payment/{booking}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/{booking}/pay', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{booking}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{booking}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/invoice/{booking}', [InvoiceController::class, 'download'])->name('invoice.download');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
});

// 5. Breeze Authentication Routes (login, register, password reset, etc.)
require __DIR__.'/auth.php';
