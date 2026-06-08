<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="border-b-2 border-gray-200 pb-2 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 uppercase tracking-wider">My Activity</h2>
        </div>

        <h3 class="text-xl font-bold text-waqaf-green mb-4 border-l-4 border-waqaf-green pl-3">Items I Donated</h3>
        <div class="bg-white rounded-lg shadow-md p-6 mb-10 border border-gray-200">
            @if($donations->isEmpty())
                <p class="text-gray-500 italic">You haven't donated any items yet.</p>
            @else
                <div class="space-y-4">
                    @foreach($donations as $item)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden">
                                    @if(!empty($item->images))
                                        <img src="{{ asset('storage/' . $item->images[0]) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-xs text-gray-400">No Img</div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $item->title }}</h4>
                                    <p class="text-xs text-gray-500">Listed on {{ $item->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                @if($item->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Pending Review</span>
                                @elseif($item->requests_count > 0)
                                    <div class="flex flex-col items-end gap-2">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold animate-pulse">{{ $item->requests_count }} Pending Request{{ $item->requests_count === 1 ? '' : 's' }}</span>
                                        
                                        @if($item->latestRequest && $item->latestRequest->user)
                                            <div class="text-xs text-gray-600">
                                                Latest request from: <a href="{{ route('profile.show', $item->latestRequest->user->id) }}" class="font-bold text-waqaf-green hover:underline" title="View Profile">{{ $item->latestRequest->user->name }}</a>
                                            </div>
                                        @endif

                                        <div class="flex gap-2 mt-1">
                                            @if($item->latestRequest && $item->latestRequest->user)
                                                <a href="{{ route('chat.index', ['user' => $item->latestRequest->user->id, 'item' => $item->id]) }}" 
                                                   class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded hover:bg-blue-700 transition shadow-sm font-semibold flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                    Chat Latest Requestor
                                                </a>
                                            @endif
                                            <form action="{{ route('items.complete', $item->id) }}" method="POST" onsubmit="return confirm('Have you successfully given this item to the requestor?');">
                                                @csrf
                                                <button type="submit" class="text-sm bg-waqaf-green text-white px-4 py-1.5 rounded hover:bg-green-700 transition shadow-sm font-semibold h-full flex items-center">
                                                    Mark Completed
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @elseif($item->status == 'approved')
                                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold">Live on Board</span>
                                @elseif($item->status == 'completed')
                                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-bold border border-gray-300">Successfully Donated</span>
                                @elseif($item->status == 'declined')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Declined by Admin</span>
                                @endif

                                @if(in_array($item->status, ['pending', 'approved', 'declined']))
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');" class="border-l border-gray-200 pl-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete Listing">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <h3 class="text-xl font-bold text-blue-600 mb-4 border-l-4 border-blue-600 pl-3">Items I Requested</h3>
        <div class="bg-white rounded-lg shadow-md p-6 mb-10 border border-gray-200">
            @if($requests->isEmpty())
                <p class="text-gray-500 italic">You haven't requested any items yet.</p>
            @else
                <div class="space-y-4">
                    @foreach($requests as $request)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden">
                                    @if($request->item && !empty($request->item->images))
                                        <img src="{{ asset('storage/' . $request->item->images[0]) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-xs text-gray-400">No Img</div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $request->item?->title }}</h4>
                                    <p class="text-xs text-gray-500">Requested on {{ $request->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end gap-2">
                                @if($request->item && $request->item->status == 'completed')
                                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold border border-emerald-300">Item Received</span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">Waiting for Meetup</span>
                                    
                                    @if($request->item && $request->item->user)
                                        <div class="text-xs text-gray-600 mt-1">
                                            Donor: <a href="{{ route('profile.show', $request->item->user->id) }}" class="font-bold text-blue-600 hover:underline" title="View Profile">{{ $request->item->user->name }}</a>
                                        </div>
                                    @endif

                                    <div class="flex gap-2 mt-1">
                                        @if($request->item && $request->item->user)
                                            <a href="{{ route('chat.index', ['user' => $request->item->user->id, 'item' => $request->item->id]) }}" 
                                               class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded hover:bg-blue-700 transition shadow-sm font-semibold flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                Chat Donor
                                            </a>
                                        @endif
                                        @if($request->item)
                                            <form action="{{ route('items.cancel', $request->item->id) }}" method="POST" onsubmit="return confirm('Cancel this request?');">
                                                @csrf
                                                <button type="submit" class="text-sm border-2 border-red-500 text-red-500 px-4 py-1.5 rounded hover:bg-red-50 transition shadow-sm font-semibold h-full">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <h3 class="text-xl font-bold text-purple-600 mb-4 border-l-4 border-purple-600 pl-3">Items I Needed (Demands)</h3>
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            @if($myDemands->isEmpty())
                <p class="text-gray-500 italic">You haven't posted any demands yet.</p>
            @else
                <div class="space-y-4">
                    @foreach($myDemands as $item)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden">
                                    @if(!empty($item->images))
                                        <img src="{{ asset('storage/' . $item->images[0]) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-xs text-gray-400">No Img</div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $item->title }}</h4>
                                    <p class="text-xs text-gray-500">Posted on {{ $item->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                @if($item->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Pending Review</span>
                                @elseif($item->status == 'approved')
                                    <div class="flex gap-2 items-center">
                                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold">Live on Frontpage</span>
                                        
                                        <form action="{{ route('items.complete', $item->id) }}" method="POST" onsubmit="return confirm('Has someone donated this to you? This will remove it from the homepage.');">
                                            @csrf
                                            <button type="submit" class="text-sm bg-purple-600 text-white px-4 py-1.5 rounded hover:bg-purple-700 transition shadow-sm font-semibold h-full flex items-center">
                                                Mark Fulfilled
                                            </button>
                                        </form>
                                    </div>
                                @elseif($item->status == 'completed')
                                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-bold border border-gray-300">Demand Fulfilled</span>
                                @elseif($item->status == 'declined')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Declined by Admin</span>
                                @endif

                                @if(in_array($item->status, ['pending', 'approved', 'declined']))
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this demand?');" class="border-l border-gray-200 pl-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete Demand">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>