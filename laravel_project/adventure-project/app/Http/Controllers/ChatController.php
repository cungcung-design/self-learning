<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $conversation = auth()->user()
            ->conversations()
            ->with('messages.user')
            ->first();

        return Inertia::render('Chat/Index', [
            'conversation' => $conversation,
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $conversation = Conversation::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return back();
    }
}
