<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Message;

class NotificationController extends Controller
{
    public function unread(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $unread = Message::where('receiver_id', $user->id)->where('is_read', false)->count();
        
        // Count pending items for admin review (if user is admin)
        $pending = 0;
        if ($user->role === 'admin') {
            $pending = \App\Models\Item::where('status', 'pending')->count();
        }

        return response()->json([
            'unread_messages' => $unread,
            'pending_items' => $pending,
        ]);
    }
}
