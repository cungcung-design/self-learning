<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Models\Gallery;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function index(): View
    {
        return view('admin.view_gallery', [
            'galleries' => Gallery::query()->latest()->get(),
        ]);
    }

    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        Gallery::query()->create([
            'image' => $this->images->store($request->file('image'), 'admin/img/gallery'),
        ]);

        return back()->with('message', 'Image uploaded successfully!');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->images->delete($gallery->imagePath());
        $gallery->delete();

        return back()->with('message', 'Image deleted successfully!');
    }
}
