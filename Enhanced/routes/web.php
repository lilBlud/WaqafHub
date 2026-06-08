<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;
use App\Models\Item;

// Public Routes
Route::get('/', function () {
    $demands = Item::with('user')->where('type', 'demand')->where('status', 'approved')->latest()->get();
    return view('welcome', compact('demands'));
});

// User Dashboard
Route::get('/dashboard', [ItemController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // Profile Management & Public View
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/{id}', [ProfileController::class, 'show'])->name('profile.show'); // PUBLIC PROFILE

    // Item Uploads & Requests (DONATIONS)
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::get('/my-activity', [ItemController::class, 'myListings'])->name('items.my-listings'); 
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::post('/items/{item}/request', [ItemController::class, 'requestItem'])->name('items.request'); 
    Route::post('/items/{item}/complete', [ItemController::class, 'completeItem'])->name('items.complete');
    
    // Delete and Cancel Routes
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::post('/items/{item}/cancel', [ItemController::class, 'cancelRequest'])->name('items.cancel');

    // Post a Demand Routes
    Route::get('/demands/create', [ItemController::class, 'createDemand'])->name('demands.create');
    Route::post('/demands', [ItemController::class, 'storeDemand'])->name('demands.store');

    // Admin Panel (Content Review)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/review', [AdminController::class, 'reviewIndex'])->name('admin.review');
        Route::post('/admin/items/{item}/approve', [AdminController::class, 'approve'])->name('admin.items.approve');
        Route::post('/admin/items/{item}/decline', [AdminController::class, 'decline'])->name('admin.items.decline');
    });

    // Chat Routes
    Route::get('/chat/{user?}', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat/{user}', [MessageController::class, 'store'])->name('chat.store');
    Route::delete('/chat/message/{message}', [MessageController::class, 'destroy'])->name('chat.destroy');
    Route::delete('/chat/user/{user}', [MessageController::class, 'destroyConversation'])->name('chat.destroy-conversation');

    // Notifications
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'unread'])->name('notifications.unread');
});

require __DIR__.'/auth.php';