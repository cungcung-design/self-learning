<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()
            ->with('adventure.category')
            ->latest()
            ->get();

        return Inertia::render('User/Favorites/Favorite', [
            'favorites' => $favorites,
        ]);
    }

    public function store(Adventure $adventure)
    {
        Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'adventure_id' => $adventure->id,
        ]);

        return back();
    }

    public function destroy(Adventure $adventure)
    {
        Favorite::where([
            'user_id' => auth()->id(),
            'adventure_id' => $adventure->id,
        ])->delete();

        return back();
    }

    public function toggleFavorite(Request $request)
    {
        $favorite = Favorite::where('user_id', auth()->user()->id)
            ->where('adventure_id', $request->adventure_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => auth()->user()->id,
                'adventure_id' => $request->adventure_id,
            ]);
        }

        return redirect()->back();
    }
}
