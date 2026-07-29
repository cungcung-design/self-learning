<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adventure;
use App\Models\AdventureSchedule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdventureScheduleController extends Controller
{
    /**
     * Display schedules for a specific adventure.
     */
    public function index(Adventure $adventure)
    {
        $schedules = $adventure->schedules()->orderByDesc('trip_date')->paginate(10);

        return Inertia::render('Admin/Schedules/Index', [
            'adventure' => $adventure,
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create(Adventure $adventure)
    {
        return Inertia::render('Admin/Schedules/Create', [
            'adventure' => $adventure,
        ]);
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request, Adventure $adventure)
    {
        $validated = $request->validate([
            'trip_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,full,cancelled',
        ]);

        $adventure->schedules()->create($validated);

        return redirect()->route('admin.adventures.schedules.index', $adventure->id)
            ->with('success', 'Schedule created successfully.');
    }

    /**
     * Show the form for editing a schedule.
     */
    public function edit(Adventure $adventure, AdventureSchedule $schedule)
    {
        if ($schedule->adventure_id !== $adventure->id) {
            abort(404);
        }

        return Inertia::render('Admin/Schedules/Edit', [
            'adventure' => $adventure,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Update the specified schedule.
     */
    public function update(Request $request, Adventure $adventure, AdventureSchedule $schedule)
    {
        if ($schedule->adventure_id !== $adventure->id) {
            abort(404);
        }

        $validated = $request->validate([
            'trip_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,full,cancelled',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.adventures.schedules.index', $adventure->id)
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy(Adventure $adventure, AdventureSchedule $schedule)
    {
        if ($schedule->adventure_id !== $adventure->id) {
            abort(404);
        }

        $schedule->delete();

        return back()->with('success', 'Schedule deleted successfully.');
    }
}
