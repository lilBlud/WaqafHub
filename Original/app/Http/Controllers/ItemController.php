<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::whereIn('status', ['approved', 'requested'])
            ->where('type', 'donate')
            ->with(['user', 'requests'])
            ->withCount(['requests as user_requests_count' => function ($query) {
                $query->where('user_id', Auth::id())->where('status', 'pending');
            }])
            ->latest();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $items = $query->get();
        return view('dashboard', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'required|string',
            'condition' => 'required|string',
            'description' => 'required|string',
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('items', 'public');
            }
        }

        Item::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'condition' => $request->condition,
            'description' => $request->description,
            'images' => $imagePaths,
            'status' => 'pending',
            'type' => 'donate',
        ]);

        return back()->with('success', 'Your item will be listed after reviewed by Admin');
    }

    public function requestItem(Item $item)
    {
        if ($item->user_id === Auth::id()) {
            return back()->with('error', 'You cannot request an item that you listed yourself.');
        }

        if (!in_array($item->status, ['approved', 'requested'])) {
            return back()->with('error', 'This item is not available for request.');
        }

        if ($item->status === 'requested' && $item->requested_by === Auth::id()) {
            return back()->with('error', 'You have already requested this item.');
        }

        $existingRequest = ItemRequest::where('item_id', $item->id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You have already requested this item.');
        }

        ItemRequest::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        // Send automatic message to the donor
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $item->user_id,
            'item_id' => $item->id,
            'content' => "Hi, is the {$item->category} - {$item->title} item available?",
            'is_read' => false,
        ]);

        return back()->with('success', 'Item successfully requested! The donor will be notified.');
    }

    public function myListings()
    {
        $donations = Item::where('user_id', Auth::id())
            ->where('type', 'donate')
            ->withCount(['requests' => function ($query) {
                $query->where('status', 'pending');
            }])
            ->with(['latestRequest.user'])
            ->latest()
            ->get();

        $myDemands = Item::where('user_id', Auth::id())->where('type', 'demand')->latest()->get();
        $requests = ItemRequest::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('item.user')
            ->latest()
            ->get();

        return view('items.my-listings', compact('donations', 'myDemands', 'requests'));
    }

    public function createDemand()
    {
        return view('items.create-demand');
    }

    public function storeDemand(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'images' => 'nullable|array|max:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('items', 'public');
            }
        }

        Item::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'condition' => 'Any',
            'description' => $request->description,
            'images' => $imagePaths,
            'status' => 'pending',
            'type' => 'demand',
        ]);

        return redirect()->route('dashboard')->with('success', 'Your Demand request has been submitted for Admin review!');
    }

    public function completeItem(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        ItemRequest::where('item_id', $item->id)
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);

        $item->update(['status' => 'completed']);

        return back()->with('success', 'Item marked as completed! Thank you for donating.');
    }

    // ==========================================
    // RESTORED: Delete and Cancel Logic
    // ==========================================
    public function destroy(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $item->delete();

        return back()->with('success', 'Listing successfully deleted.');
    }

    public function cancelRequest(Item $item)
    {
        $request = ItemRequest::where('item_id', $item->id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($request) {
            $request->update(['status' => 'cancelled']);
            return back()->with('success', 'Your request has been cancelled.');
        }

        if ($item->status === 'requested' && $item->requested_by === Auth::id()) {
            $item->update(['status' => 'approved', 'requested_by' => null]);
            return back()->with('success', 'Your request has been cancelled.');
        }

        return back()->with('error', 'Unauthorized.');
    }
}
