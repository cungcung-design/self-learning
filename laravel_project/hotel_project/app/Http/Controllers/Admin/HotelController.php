<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHotelRequest;
use App\Http\Requests\Admin\UpdateHotelRequest;
use App\Models\Amenity;
use App\Models\FeaturedCategory;
use App\Models\Hotel;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function index(Request $request): View
    {
        $hotels = Hotel::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', $search)
                        ->orWhere('location', 'like', $search);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_hotel', compact('hotels'));
    }

    public function create(): View
    {
        $featuredCategories = FeaturedCategory::query()->orderBy('name')->get();
        $amenities = Amenity::query()->orderBy('name')->get();

        return view('admin.create_hotel', compact('featuredCategories', 'amenities'));
    }

    public function store(StoreHotelRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'admin/img/hotels');
        }

        $hotel = Hotel::query()->create($data);

        if ($request->filled('featured_category_ids')) {
            $hotel->featuredCategories()->sync($request->input('featured_category_ids', []));
        }

        if ($request->filled('amenity_ids')) {
            $hotel->amenities()->sync($request->input('amenity_ids', []));
        }

        return redirect()
            ->route('admin.hotels.index')
            ->with('message', 'Hotel created successfully!');
    }

    public function edit(Hotel $hotel): View
    {
        $featuredCategories = FeaturedCategory::query()->orderBy('name')->get();
        $amenities = Amenity::query()->orderBy('name')->get();

        return view('admin.edit_hotel', compact('hotel', 'featuredCategories', 'amenities'));
    }

    public function update(UpdateHotelRequest $request, Hotel $hotel): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->replace(
                $hotel->image,
                $request->file('image'),
                'admin/img/hotels'
            );
        }

        $hotel->update($data);

        if ($request->filled('featured_category_ids')) {
            $hotel->featuredCategories()->sync($request->input('featured_category_ids', []));
        } else {
            $hotel->featuredCategories()->detach();
        }

        if ($request->filled('amenity_ids')) {
            $hotel->amenities()->sync($request->input('amenity_ids', []));
        } else {
            $hotel->amenities()->detach();
        }

        return redirect()
            ->route('admin.hotels.index')
            ->with('message', 'Hotel updated successfully!');
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        $this->images->delete($hotel->image);
        $hotel->featuredCategories()->detach();
        $hotel->amenities()->detach();
        $hotel->delete();

        return back()->with('message', 'Hotel deleted successfully!');
    }
}
