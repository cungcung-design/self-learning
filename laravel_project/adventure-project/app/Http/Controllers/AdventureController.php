<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdventureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Public listing - shows all adventures with filtering & pagination
        $query = Adventure::query()->with('category');

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Minimum price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Maximum price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Duration
        if ($request->filled('duration')) {
            $query->where('duration', '>=', $request->duration);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $adventures = $query->paginate(9)->withQueryString();

        // Attach is_favorited flag if user is logged in
        if (auth()->check()) {
            $userFavIds = Favorite::where('user_id', auth()->id())
                ->whereIn('adventure_id', collect($adventures->items())->pluck('id'))
                ->pluck('adventure_id')
                ->toArray();

            $adventures->getCollection()->transform(function ($adventure) use ($userFavIds) {
                $adventure->is_favorited = in_array($adventure->id, $userFavIds);

                return $adventure;
            });
        }

        return Inertia::render('User/Adventures/Index', [
            'adventures' => $adventures,
            'categories' => Category::orderBy('name')->get(),
            'filters' => $request->only([
                'search',
                'category',
                'min_price',
                'max_price',
                'duration',
                'sort',
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Adventures/Create', [
            'categories' => Category::all(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'location' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'description' => 'nullable',
            'difficulty' => 'nullable',
            'duration' => 'nullable',
            'max_people' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('adventures', 'public');
        }

        Adventure::create($validated);

        return redirect()->route('adventures.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adventure $adventure)
    {
        $adventure->load([
            'category',
            'reviews.user',
        ]);

        // Check if authenticated user has favorited this adventure
        if (auth()->check()) {
            $adventure->is_favorited = Favorite::where('user_id', auth()->id())
                ->where('adventure_id', $adventure->id)
                ->exists();
        } else {
            $adventure->is_favorited = false;
        }

        // Get related adventures (same category, excluding current)
        $related = Adventure::with('category')
            ->where('category_id', $adventure->category_id)
            ->where('id', '!=', $adventure->id)
            ->latest()
            ->take(3)
            ->get();

        return Inertia::render('User/Adventures/AdventureDetail', [
            'adventure' => $adventure,
            'related' => $related,
        ]);
    }

    /**
     * Admin: Display adventure listing.
     */
    public function adminIndex()
    {
        $adventures = Adventure::with('category')->latest()->paginate(10);

        return Inertia::render('Admin/Adventures/Index', [
            'adventures' => $adventures,
        ]);
    }

    /**
     * Admin: Display adventure details.
     */
    public function adminShow(Adventure $adventure)
    {
        $adventure->load('category');

        return Inertia::render('Admin/Adventures/Show', [
            'adventure' => $adventure,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adventure $adventure)
    {
        return Inertia::render('Admin/Adventures/Edit', [
            'adventure' => $adventure,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adventure $adventure)
    {
        // Fixed: Added all editable fields so they don't get lost on update
        $validated = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'location' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'difficulty' => 'nullable',
            'duration' => 'nullable',
            'max_people' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($adventure->image) {
                Storage::disk('public')->delete($adventure->image);
            }
            $validated['image'] = $request->file('image')->store('adventures', 'public');
        }

        $adventure->update($validated);

        return redirect()->route('adventures.index')->with('success', 'Adventure updated successfully!');
    }

    public function destroy(Adventure $adventure)
    {
        if ($adventure->image) {
            Storage::disk('public')->delete($adventure->image);
        }

        $adventure->delete();

        return redirect()->route('adventures.index')->with('success', 'Adventure deleted successfully.');
    }
}
