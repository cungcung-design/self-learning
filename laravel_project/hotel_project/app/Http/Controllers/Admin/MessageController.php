<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReplyContactRequest;
use App\Models\Contact;
use App\Notifications\ContactReplyNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = Contact::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = '%'.$request->string('q').'%';
                $query->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search)
                    ->orWhere('message', 'like', $search);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.view_message', compact('messages'));
    }

    public function reply(Contact $contact): View
    {
        return view('admin.reply_email', compact('contact'));
    }

    public function sendReply(ReplyContactRequest $request, Contact $contact): RedirectResponse
    {
        Notification::route('mail', $contact->email)
            ->notify(new ContactReplyNotification($contact, $request->validated()));

        return redirect()
            ->route('admin.messages.index')
            ->with('message', 'Reply sent successfully!');
    }
}
