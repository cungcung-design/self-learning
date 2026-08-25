<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::query()->create($request->validated());

        return back()->with('message', 'Your message has been sent successfully!');
    }
}
