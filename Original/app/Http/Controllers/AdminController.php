<?php

namespace App\Http\Controllers;

use App\Models\Item; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // 1. Show the Content Review Table
    public function reviewIndex()
    {
        // Security check: Kick out anyone who isn't an admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        // Grab all items that are waiting for approval
        $pendingItems = Item::where('status', 'pending')->latest()->get();

        return view('admin.review', compact('pendingItems'));
    }

    // 2. Approve an Item
    public function approve(Item $item)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $item->update(['status' => 'approved']);

        return back()->with('success', 'Item Listed!');
    }

    // 3. Decline/Reject an Item
    // 3. Decline/Reject an Item
    // 3. Decline/Reject an Item
    public function decline(Item $item)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $item->update(['status' => 'declined']);

        return back()->with('error', 'Item Removed!');
    }
}