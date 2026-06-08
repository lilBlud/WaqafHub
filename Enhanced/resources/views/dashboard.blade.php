<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-end mb-6 border-b-2 border-gray-200 pb-2">
            <h2 class="text-2xl font-semibold text-gray-800 uppercase tracking-wider">Available Items</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($items as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition duration-300 flex flex-col">
                    
                    <div class="h-48 bg-gray-200 w-full relative">
                        @if(!empty($item->images) && is_array($item->images))
                            <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                        @endif
                        
                        <span class="absolute top-2 right-2 bg-waqaf-green text-white text-xs font-bold px-2 py-1 rounded shadow">
                            {{ $item->category }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">{{ $item->title }}</h3>
                        
                        @if($item->user)
                            <div class="flex items-center gap-2 mb-3 bg-gray-50 p-2 rounded border border-gray-100">
                                <div class="w-6 h-6 bg-gray-300 rounded-full flex flex-shrink-0 items-center justify-center text-[10px] font-bold text-white uppercase">{{ substr($item->user->name, 0, 1) }}</div>
                                <a href="{{ route('profile.show', $item->user->id) }}" class="text-xs font-bold text-gray-700 hover:text-waqaf-green hover:underline truncate" title="View Profile">{{ $item->user->name }}</a>
                            </div>
                        @endif

                        <div class="flex flex-col text-xs text-gray-500 mb-3 space-y-1">
                            <span class="flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 text-waqaf-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                                {{ $item->location }}
                            </span>
                            <span class="flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 text-waqaf-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                {{ $item->condition }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mb-4 h-10 overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            {{ $item->description }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100">
                            @if($item->user_id == auth()->id())
                                <button type="button" disabled class="w-full border-2 border-gray-300 text-gray-500 font-bold py-2 rounded bg-gray-100 cursor-not-allowed">
                                    Your Item
                                </button>
                            @elseif($item->user_requests_count > 0 || ($item->status == 'requested' && $item->requested_by == auth()->id()))
                                <button type="button" disabled class="w-full border-2 border-gray-300 text-gray-500 font-bold py-2 rounded bg-gray-100 cursor-not-allowed">
                                    Requested
                                </button>
                            @else
                                <form action="{{ route('items.request', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to request this item?');">
                                    @csrf
                                    <button type="submit" class="w-full border-2 border-waqaf-green text-waqaf-green font-bold py-2 rounded hover:bg-waqaf-green hover:text-white transition shadow-sm">
                                        Request Item
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center text-center text-gray-500 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-xl font-semibold text-gray-700 mb-1">No items available yet.</p>
                    <p class="text-sm">Check back later or list an item yourself!</p>
                </div>
            @endforelse
        </div>
    </div>

    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-60">
            <div class="{{ session('success') ? 'bg-waqaf-green border-emerald-300' : 'bg-red-600 border-red-400' }} text-white p-8 rounded-lg shadow-2xl max-w-sm w-full text-center relative border-t-4">
                <div class="mb-4 text-3xl font-bold italic tracking-widest">WAQAFHUB</div>
                <h2 class="text-2xl font-bold mb-4 uppercase">{{ session('success') ? 'Thank You!' : 'Oops!' }}</h2>
                <p class="mb-8 text-sm">{{ session('success') ?? session('error') }}</p>
                <button @click="show = false" class="bg-white {{ session('success') ? 'text-waqaf-green' : 'text-red-600' }} px-8 py-2 rounded-md font-bold hover:bg-gray-100 transition shadow">Close</button>
            </div>
        </div>
    @endif
</x-app-layout>