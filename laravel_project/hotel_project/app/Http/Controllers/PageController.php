<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
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
}
