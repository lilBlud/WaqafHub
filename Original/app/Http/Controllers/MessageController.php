<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request, User $user = null)
    {
        $myId = Auth::id();

        // 1. Mark messages as read if a user is currently selected!
        if ($user) {
            Message::where('sender_id', $user->id)
                ->where('receiver_id', $myId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        // 2. Find everyone I have ever chatted with
        $contactIds = Message::where('sender_id', $myId)->pluck('receiver_id')
            ->merge(Message::where('receiver_id', $myId)->pluck('sender_id'))
            ->unique();
            
        $contacts = User::whereIn('id', $contactIds)->get();

        // 3. Calculate unread messages per contact
        $unreadCounts = Message::where('receiver_id', $myId)
            ->where('is_read', false)
            ->selectRaw('sender_id, count(*) as count')
            ->groupBy('sender_id')
            ->pluck('count', 'sender_id');

        foreach ($contacts as $contact) {
            $contact->unread_count = $unreadCounts->get($contact->id, 0);
        }

        // Sort contacts so those with unread messages bubble to the top!
        $contacts = $contacts->sortByDesc('unread_count');

        // 4. Load chat history
        $messages = [];
        if ($user) {
            $messages = Message::where(function($q) use ($myId, $user) {
                $q->where('sender_id', $myId)->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($myId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $myId);
            })->oldest()->get();
        }

        // 5. Check context
        $item = null;
        if ($request->has('item')) {
            $item = Item::find($request->item);
        }

        return view('message.index', compact('contacts', 'user', 'messages', 'item'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate(['message' => 'required|string']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'item_id' => $request->item_id,
            'content' => $request->message,
            'is_read' => false, // New messages start as unread
        ]);

        return back();
    }

    public function destroy(Message $message)
    {
        // Only allow deletion by sender or receiver
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $message->delete();

        return back()->with('success', 'Message deleted.');
    }

    public function destroyConversation(User $user)
    {
        $myId = Auth::id();

        // Delete all messages between current user and the specified user
        Message::where(function($q) use ($myId, $user) {
            $q->where('sender_id', $myId)->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($myId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $myId);
        })->delete();

        return back()->with('success', 'Conversation deleted.');
    }
}