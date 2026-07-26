<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated  = $request->validate([
        'adenture_id' => 'required|exists:adventures,id',
        'user_id' => 'required|exists:users,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
        ]);

        $review = new Review();
        $review->adventure_id = $validated['adenture_id'];
        $review->user_id = $validated['user_id'];
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
