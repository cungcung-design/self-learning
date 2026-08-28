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
            ->with(['featuredCategories', 'hotelImages', 'rooms'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', $search)
                        ->orWhere('location', 'like', $search);
                });
            })
            ->when($request->filled('location'), function ($query) use ($request) {
                $query->where('location', 'like', '%'.$request->string('location').'%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('featuredCategories', function ($inner) use ($request) {
                    $inner->where('slug', $request->string('category'));
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_hotel', compact('hotels'));
    }

    public function show(Hotel $hotel): View
    {
        return view('admin.show_hotel', compact('hotel'));
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

        if ($request->hasFile('hotel_images')) {
            $primaryIndex = (int) $request->input('primary_image_index', 0);
            foreach ($request->file('hotel_images') as $index => $file) {
                if (!$file) {
                    continue;
                }

                $path = $this->images->store($file, 'admin/img/hotels');
                $isPrimary = $index === $primaryIndex;

                $hotel->hotelImages()->create([
                    'image_url' => $path,
                    'is_primary' => $isPrimary,
                    'sort_order' => $index + 1,
                ]);

                if ($isPrimary && !$request->hasFile('image')) {
                    $hotel->update(['image' => $path]);
                }
            }
        }

        return redirect()
            ->route('admin.hotels.index')
            ->with('message', 'Hotel created successfully!');
    }

    public function edit(Hotel $hotel): View
    {
        $featuredCategories = FeaturedCategory::query()->orderBy('name')->get();
        $amenities = Amenity::query()->orderBy('name')->get();
        $hotel->load(['hotelImages', 'featuredCategories', 'amenities']);

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

        if ($request->filled('delete_image_ids')) {
            foreach ($request->input('delete_image_ids', []) as $imageId) {
                $image = $hotel->hotelImages()->find($imageId);
                if ($image) {
                    $this->images->delete($image->image_url);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('hotel_images')) {
            $maxSort = $hotel->hotelImages()->max('sort_order') ?? 0;
            foreach ($request->file('hotel_images') as $index => $file) {
                if (!$file) {
                    continue;
                }

                $path = $this->images->store($file, 'admin/img/hotels');
                $hotel->hotelImages()->create([
                    'image_url' => $path,
                    'is_primary' => false,
                    'sort_order' => $maxSort + $index + 1,
                ]);
            }
        }

        if ($request->filled('primary_image_id')) {
            $primary = $hotel->hotelImages()->find($request->input('primary_image_id'));
            if ($primary) {
                $hotel->hotelImages()->update(['is_primary' => false]);
                $primary->update(['is_primary' => true]);
                $hotel->update(['image' => $primary->image_url]);
            }
        }

        return redirect()
            ->route('admin.hotels.index')
            ->with('message', 'Hotel updated successfully!');
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        $this->images->delete($hotel->image);
        $hotel->hotelImages()->each(function ($image) {
            $this->images->delete($image->image_url);
        });
        $hotel->hotelImages()->delete();
        $hotel->featuredCategories()->detach();
        $hotel->amenities()->detach();
        $hotel->delete();

        return back()->with('message', 'Hotel deleted successfully!');
    }
}
