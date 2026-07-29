<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adventure;

class AdventureController extends Controller
{
    public function index()
    {
        $adventures = Adventure::with(['category', 'images'])
            ->latest()
            ->paginate(10);

        return response()->json($adventures);
    }
}
