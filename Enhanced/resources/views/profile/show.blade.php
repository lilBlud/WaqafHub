<x-app-layout>
    <div class="w-full h-48 bg-waqaf-green relative overflow-hidden shadow-sm">
        <div class="absolute inset-0 opacity-20" style="background-image: repeating-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff), repeating-linear-gradient(45deg, #ffffff 25%, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff); background-position: 0 0, 20px 20px; background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 mb-10">
        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-6">
            
            <div class="flex items-center gap-6">
                <div class="w-28 h-28 bg-gray-300 rounded-full border-4 border-white shadow-md flex items-center justify-center text-4xl font-bold text-white uppercase flex-shrink-0 overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($user->name, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 leading-tight">{{ $user->name }}</h2>
                    <p class="text-gray-500 font-medium">{{ $location }}</p>
                    <p class="text-waqaf-green font-semibold text-sm">{{ $user->email }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-8 bg-gray-50 p-4 rounded-lg border border-gray-100 w-full md:w-auto justify-around">
                <div class="text-center px-4">
                    <span class="block text-2xl font-black text-gray-800">{{ $listings->count() }}</span>
                    <span class="text-[11px] text-gray-500 uppercase tracking-wider font-bold">Listed Items</span>
                </div>
                <div class="text-center border-l border-gray-200 px-4">
                    <span class="block text-2xl font-black text-gray-800">{{ max(1, ceil($user->created_at->floatDiffInDays(now()))) }}d</span>
                    <span class="text-[11px] text-gray-500 uppercase tracking-wider font-bold">Joined</span>
                </div>
                <div class="ml-2">
                    @if(Auth::id() !== $user->id)
                        <a href="{{ route('chat.index', $user->id) }}" class="bg-gray-300 text-gray-800 px-6 py-2.5 rounded-md shadow-sm hover:bg-gray-400 transition font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Chat
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mb-16">
        <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-200 pb-2 mb-6 uppercase tracking-wide">Listings</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($listings as $item)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition flex flex-col {{ $item->status == 'requested' ? 'opacity-70' : '' }}">
                    <div class="h-48 bg-gray-200 w-full relative">
                        @if(!empty($item->images))
                            <img src="{{ asset('storage/' . $item->images[0]) }}" class="w-full h-full object-cover">
                        @endif
                        @if($item->status == 'requested')
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-end justify-center pb-4">
                                <span class="text-white text-sm font-bold bg-black bg-opacity-75 px-4 py-1 rounded">Unavailable</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h4 class="font-bold text-gray-800 truncate mb-1">{{ $item->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $item->condition }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <p class="text-gray-500 font-medium">This user has no active listings.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>