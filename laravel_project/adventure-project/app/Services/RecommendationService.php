<?php

namespace App\Services;

use App\Models\Adventure;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    public function getTopAdventures(int $limit = 5)
    {
        return Adventure::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take($limit)
            ->get();
    }

    public function getRecommendedForUser(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        $bookedCategoryIds = Booking::where('user_id', $userId)
            ->join('adventures', 'bookings.adventure_id', '=', 'adventures.id')
            ->join('categories', 'adventures.category_id', '=', 'categories.id')
            ->pluck('categories.id')
            ->unique()
            ->toArray();

        if (empty($bookedCategoryIds)) {
            return Adventure::with('category')->latest()->take(6)->get();
        }

        return Adventure::whereIn('category_id', $bookedCategoryIds)
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('adventure_id')
                    ->from('bookings')
                    ->where('user_id', $userId);
            })
            ->with('category')
            ->latest()
            ->take(6)
            ->get();
    }
}
