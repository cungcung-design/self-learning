<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->with('adventure')->latest()->take(5)->get();

        return Inertia::render('User/Dashboard', [
            'bookings' => $bookings,
        ]);
    }
}

