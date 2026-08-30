<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAmenityRequest;
use App\Http\Requests\Admin\UpdateAmenityRequest;
use App\Models\Amenity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AmenityController extends Controller
{
    public function index(Request $request): View
    {
        $amenities = Amenity::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where('name', 'like', $search);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_amenity', compact('amenities'));
    }

    public function create(): View
    {
        return view('admin.create_amenity');
    }

    public function store(StoreAmenityRequest $request): RedirectResponse
    {
        Amenity::query()->create($request->validated());

        return redirect()
            ->route('admin.amenities.index')
            ->with('message', 'Changes saved successfully');
    }

    public function edit(Amenity $amenity): View
    {
        return view('admin.edit_amenity', compact('amenity'));
    }

    public function update(UpdateAmenityRequest $request, Amenity $amenity): RedirectResponse
    {
        $amenity->update($request->validated());

        return redirect()
            ->route('admin.amenities.index')
            ->with('message', 'Changes saved successfully');
    }

    public function destroy(Amenity $amenity): RedirectResponse
    {
        $amenity->delete();

        return back()->with('message', 'Changes saved successfully');
    }
}
