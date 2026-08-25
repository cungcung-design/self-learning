<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $user->isAdmin() || $booking->belongsToUser($user);
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $booking->belongsToUser($user)
            && $booking->isPending()
            && $booking->start_date?->gte(now()->startOfDay());
    }

    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }
}
