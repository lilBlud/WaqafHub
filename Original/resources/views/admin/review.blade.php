<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h2 class="text-2xl font-normal text-gray-800 mb-6">Content Review</h2>

        <div class="bg-gray-200 border-b-2 border-gray-300 rounded-t-md p-3 grid grid-cols-12 gap-4 text-sm text-gray-700">
            <div class="col-span-6 px-2">Description</div>
            <div class="col-span-2">Listed On</div>
            <div class="col-span-2">location</div>
            <div class="col-span-2 text-center">Action</div>
        </div>

        <div class="bg-[#4a9f76] rounded-b-md p-4 shadow-md space-y-4 min-h-[200px]">
            @forelse($pendingItems as $item)

                <div x-data="{ showApprove: false, showDecline: false }" class="grid grid-cols-12 gap-4 items-start border-b border-[#3c8762] pb-4 last:border-0 text-white text-sm">

                    <div class="col-span-6 flex gap-4 px-2">
                        <div class="w-24 h-32 flex-shrink-0 bg-white rounded overflow-hidden shadow-sm">
                            @if(!empty($item->images) && is_array($item->images) && !empty($item->images[0]))
                                <img src="{{ asset('storage/' . $item->images[0]) }}" alt="Item" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs uppercase tracking-wide">No Image</div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h3 class="font-normal text-lg mb-1">{{ $item->title }}</h3>
                            <div class="bg-white text-gray-800 p-3 rounded text-xs min-h-[5rem] w-full shadow-inner">
                                {{ $item->description }}
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 pt-1">
                        {{ $item->created_at->format('F j, Y') }}
                    </div>

                    <div class="col-span-2 pt-1">
                        {{ $item->location }}
                    </div>

                    <div class="col-span-2 flex flex-col gap-3 px-2">
                        <button @click="showApprove = true" class="border border-white text-white hover:bg-white hover:text-[#4a9f76] font-medium px-4 py-1.5 rounded-full transition w-full">Approve</button>
                        <button @click="showDecline = true" class="border border-white text-white hover:bg-white hover:text-[#4a9f76] font-medium px-4 py-1.5 rounded-full transition w-full">Decline</button>
                    </div>

                    <div x-show="showApprove" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60" style="display: none;">
                        <div class="bg-waqaf-green text-white p-8 rounded-lg shadow-2xl max-w-sm w-full text-center relative border-t-4 border-emerald-300">
                            <button @click="showApprove = false" class="absolute top-2 right-4 text-2xl font-bold hover:text-gray-200">&times;</button>
                            <div class="mb-4 text-3xl font-bold italic tracking-widest">WAQAFHUB</div>
                            <h2 class="text-xl font-bold mb-6">Are you sure you want to approve this item?</h2>
                            <div class="flex gap-4 justify-center">
                                <button @click="showApprove = false" class="bg-white text-waqaf-green font-bold py-2 px-6 rounded hover:bg-gray-100 w-1/2 transition shadow">Cancel</button>
                                <form action="{{ route('admin.items.approve', $item) }}" method="POST" class="w-1/2">
                                    @csrf
                                    <button type="submit" class="bg-white text-waqaf-green font-bold py-2 px-6 rounded hover:bg-gray-100 w-full transition shadow">Confirm</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="showDecline" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60" style="display: none;">
                        <div class="bg-waqaf-green text-white p-8 rounded-lg shadow-2xl max-w-sm w-full text-center relative border-t-4 border-emerald-300">
                            <button @click="showDecline = false" class="absolute top-2 right-4 text-2xl font-bold hover:text-gray-200">&times;</button>
                            <div class="mb-4 text-3xl font-bold italic tracking-widest">WAQAFHUB</div>
                            <h2 class="text-xl font-bold mb-6">Are you sure you want to remove this item?</h2>
                            <div class="flex gap-4 justify-center">
                                <button @click="showDecline = false" class="bg-white text-waqaf-green font-bold py-2 px-6 rounded hover:bg-gray-100 w-1/2 transition shadow">Cancel</button>
                                <form action="{{ route('admin.items.decline', $item) }}" method="POST" class="w-1/2">
                                    @csrf
                                    <button type="submit" class="bg-white text-waqaf-green font-bold py-2 px-6 rounded hover:bg-gray-100 w-full transition shadow">Confirm</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="text-white text-center py-10 font-medium">
                    <p class="text-xl mb-2">You don't have anything to do</p>
                    <p class="text-sm opacity-80">No items are currently pending review.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed inset-0 z-[100] flex items-center justify-center pointer-events-none">
            <div class="bg-waqaf-green text-white px-8 py-4 rounded-md shadow-2xl text-xl font-bold border-2 border-emerald-300 transform transition-all flex items-center gap-3 pointer-events-auto">
                <svg class="w-8 h-8 bg-white text-waqaf-green rounded-full p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    @endif
</x-app-layout>
