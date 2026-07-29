<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['user', 'messages.user'])
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Chat/Index', [
            'conversations' => $conversations,
        ]);
    }

    public function show(Conversation $conversation)
    {
        $conversation->load('messages.user');

        return Inertia::render('Admin/Chat/Show', [
            'conversation' => $conversation,
        ]);
    }

    public function reply(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Reply sent successfully.');
    }
}
