<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRoomsRequest;
use App\Models\Gallery;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(SearchRoomsRequest $request): View
    {
        $searching = $request->hasDateRange() || $request->filled('room_type');

        $roomsQuery = Room::query()
            ->ofType($request->input('room_type'))
            ->availableBetween(
                $request->hasDateRange() ? $request->date('start_date') : null,
                $request->hasDateRange() ? $request->date('end_date') : null,
            )
            ->latest();

        return view('home.index', [
            'rooms' => $searching ? $roomsQuery->get() : $roomsQuery->limit(6)->get(),
            'gallery' => Gallery::query()->latest()->limit(8)->get(),
            'filters' => $request->only(['start_date', 'end_date', 'room_type']),
            'searching' => $searching,
        ]);
    }

    public function redirectAuthenticated(): RedirectResponse
    {
        if (auth()->user()?->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home.public'));
    }
}
