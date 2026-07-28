<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Inertia\Inertia;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('causer', 'subject')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Activities/Index', [
            'activities' => $activities
        ]);
    }
}
