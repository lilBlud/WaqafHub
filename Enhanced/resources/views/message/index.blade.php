<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-100px)]">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 h-full flex overflow-hidden">

            <div class="w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
                <div class="p-4 border-b border-gray-200 bg-white">
                    <h2 class="text-xl font-bold text-gray-800 uppercase tracking-wider">Inbox</h2>
                </div>
                <div class="overflow-y-auto flex-1 p-2">
                    @forelse($contacts as $contact)
                        <div class="flex items-center gap-2 mb-1 rounded-lg p-3 transition {{ isset($user) && $user->id == $contact->id ? 'bg-waqaf-green text-white shadow' : 'hover:bg-gray-200 text-gray-700' }} group">
                            <a href="{{ route('chat.index', $contact->id) }}" class="flex-1 font-bold">{{ $contact->name }}</a>
                            <div class="flex items-center gap-1">
                                @if($contact->unread_count > 0)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $contact->unread_count }}</span>
                                @endif
                                <form action="{{ route('chat.destroy-conversation', $contact->id) }}" method="POST" onsubmit="return confirm('Delete all messages with {{ $contact->name }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="transition p-1">
                                        <svg class="w-4 h-4 {{ isset($user) && $user->id == $contact->id ? 'text-white hover:text-red-200' : 'text-gray-400 hover:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center mt-4 italic">No conversations yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="w-2/3 flex flex-col bg-white">
                @if(isset($user))
                    <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center shadow-sm z-10">
                        <h3 class="font-bold text-lg text-gray-800">
                            <a href="{{ route('profile.show', $user->id) }}" class="hover:text-waqaf-green hover:underline">{{ $user->name }}</a>
                        </h3>
                        @if(isset($item))
                            <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold border border-emerald-200 truncate max-w-xs">
                                Regarding: {{ $item->title }}
                            </span>
                        @endif
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-100" id="chat-box">
                        @forelse($messages as $msg)
                            <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="flex items-start gap-1">
                                    <div class="{{ $msg->sender_id == Auth::id() ? 'bg-waqaf-green text-white' : 'bg-white text-gray-800 border border-gray-200' }} px-4 py-2 rounded-lg max-w-md shadow-sm">
                                        <p class="text-sm">{{ $msg->content }}</p>
                                        <span class="text-[10px] opacity-70 mt-1 block {{ $msg->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">{{ $msg->created_at->format('h:i A') }}</span>
                                    </div>
                                    <form action="{{ route('chat.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="transition p-1">
                                            <svg class="w-3 h-3 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <p class="text-sm">Start the conversation!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 border-t border-gray-200 bg-white shadow-inner">
                        <form action="{{ route('chat.store', $user->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            @if(isset($item))
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                            @endif
                            <input type="text" name="message" required placeholder="Type your message..." class="flex-1 border-gray-300 rounded focus:ring-waqaf-green focus:border-waqaf-green shadow-sm" autocomplete="off" autofocus>
                            <button type="submit" class="bg-waqaf-green text-white px-6 py-2 rounded font-bold hover:bg-green-700 transition shadow-sm">Send</button>
                        </form>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                        <svg class="w-20 h-20 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <h3 class="text-xl font-medium text-gray-500">Select a conversation</h3>
                        <p class="text-sm">Or click 'Contact' on an item to start a new chat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chatBox = document.getElementById("chat-box");
            if(chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>
</x-app-layout>
