<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use App\Models\Favorite;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function index()
  {
    $adventures = Adventure::with('category')->latest()->take(6)->get();

    // Attach is_favorited flag if user is logged in
    if (auth()->check()) {
        $userFavIds = Favorite::where('user_id', auth()->id())
            ->whereIn('adventure_id', $adventures->pluck('id'))
            ->pluck('adventure_id')
            ->toArray();

        $adventures = $adventures->map(function ($adventure) use ($userFavIds) {
            $adventure->is_favorited = in_array($adventure->id, $userFavIds);
            return $adventure;
        });
    }

return Inertia::render('User/Home', [
      'adventures' => $adventures
    ]);
  }
}
