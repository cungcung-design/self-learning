<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFeaturedCategoryRequest;
use App\Http\Requests\Admin\UpdateFeaturedCategoryRequest;
use App\Models\FeaturedCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeaturedCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = FeaturedCategory::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where('name', 'like', $search);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_featured_category', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.create_featured_category');
    }

    public function store(StoreFeaturedCategoryRequest $request): RedirectResponse
    {
        FeaturedCategory::query()->create($request->validated());

        return redirect()
            ->route('admin.featured_categories.index')
            ->with('message', 'Changes saved successfully');
    }

    public function edit(FeaturedCategory $featuredCategory): View
    {
        return view('admin.edit_featured_category', compact('featuredCategory'));
    }

    public function update(UpdateFeaturedCategoryRequest $request, FeaturedCategory $featuredCategory): RedirectResponse
    {
        $featuredCategory->update($request->validated());

        return redirect()
            ->route('admin.featured_categories.index')
            ->with('message', 'Changes saved successfully');
    }

    public function destroy(FeaturedCategory $featuredCategory): RedirectResponse
    {
        $featuredCategory->delete();

        return back()->with('message', 'Changes saved successfully');
    }
}
