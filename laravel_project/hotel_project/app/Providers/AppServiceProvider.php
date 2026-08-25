<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Contact;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFour();

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('bookings', function (Request $request) {
            return Limit::perMinute(10)->by((string) ($request->user()?->id ?: $request->ip()));
        });

        View::composer('admin.sidebar', function ($view) {
            $view->with('pendingBookingCount', Booking::query()->where('status', Booking::STATUS_PENDING)->count());
            $view->with('openMessageCount', Contact::query()->count());
        });
    }
}
