<?php

namespace App\Http\Controllers;

use App\Models\FeaturedCategory;
use App\Models\Gallery;
use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('home.about_page');
    }

    public function gallery(): View
    {
        return view('home.gallery_page', [
            'gallery' => Gallery::query()->latest()->paginate(12),
        ]);
    }

    public function contact(): View
    {
        return view('home.contact_page');
    }

    public function featured(Request $request): View|JsonResponse
    {
        $categorySlug = trim((string) $request->query('category', ''));
        $categories = FeaturedCategory::query()->orderBy('name')->get();
        $activeCategory = $categories->firstWhere('slug', $categorySlug);

        $hotels = Hotel::query()
            ->active()
            ->with(['primaryImage', 'featuredCategories', 'rooms' => fn ($rooms) => $rooms->orderBy('room_price')])
            ->when($activeCategory, function ($query) use ($activeCategory) {
                $query->whereHas('featuredCategories', fn ($categories) => $categories->whereKey($activeCategory->id));
            })
            ->orderByDesc('rating')
            ->orderBy('name')
            ->get();

        $pageTitle = $activeCategory?->name ? $activeCategory->name.' Hotels' : 'Featured Hotels';

        if ($request->wantsJson()) {
            $count = $hotels->count();

            return response()->json([
                'title' => $pageTitle,
                'documentTitle' => $pageTitle.' — '.config('hotel.name'),
                'count' => $count,
                'mapCountLabel' => '• '.$count.' '.Str::plural('hotel', $count).' in this collection',
                'applyLabel' => $count.' '.Str::plural('stay', $count).' found',
                'html' => view('home.partials.featured-hotels', [
                    'hotels' => $hotels,
                ])->render(),
            ]);
        }

        return view('home.featured_listing', [
            'hotels' => $hotels,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'pageTitle' => $pageTitle,
        ]);
    }
}
