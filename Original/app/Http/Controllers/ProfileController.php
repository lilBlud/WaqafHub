<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $path;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // THESE ARE THE TWO LINES THAT WENT MISSING!
        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // ==========================================
    // NEW: Public Profile View
    // ==========================================
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Get their active donations (Approved or Requested, but not fully completed)
        $listings = Item::where('user_id', $id)
            ->where('type', 'donate')
            ->whereIn('status', ['approved', 'requested'])
            ->latest()
            ->get();
        
        // Try to guess their location based on their most recent item
        $lastItem = Item::where('user_id', $id)->latest()->first();
        $location = $lastItem ? $lastItem->location : 'WaqafHub Member';

        return view('profile.show', compact('user', 'listings', 'location'));
    }
}