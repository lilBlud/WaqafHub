@php
    $globalUnread = Auth::check() ? \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count() : 0;
    $adminPending = Auth::check() && Auth::user()->role === 'admin' ? \App\Models\Item::where('status', 'pending')->count() : 0;
@endphp

<nav x-data="{ open: false }" class="bg-white border-b-4 border-waqaf-green shadow-sm py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 w-full">
            
            <div class="flex items-center shrink-0">
                <div class="flex-shrink-0 pr-4 lg:pr-6 lg:border-r border-gray-200">
                    <a href="{{ url('/') }}">
                        <span class="text-2xl font-black text-waqaf-green tracking-widest uppercase drop-shadow-sm">waqafhub</span>
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-3 xl:space-x-5 text-sm font-semibold text-gray-600 ml-4 shrink-0">
                    <a href="{{ route('dashboard') }}" class="hover:text-waqaf-green transition whitespace-nowrap {{ request()->routeIs('dashboard') && !request()->has('category') ? 'text-waqaf-green border-b-2 border-waqaf-green pb-1' : '' }}">Dashboard</a>
                    
                    <a href="{{ route('chat.index') }}" class="flex items-center hover:text-waqaf-green transition whitespace-nowrap {{ request()->routeIs('chat.*') ? 'text-waqaf-green border-b-2 border-waqaf-green pb-1' : '' }}">
                        Inbox
                        @if($globalUnread > 0)
                            <span class="ml-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow-sm flex items-center justify-center">{{ $globalUnread }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('dashboard', ['category' => 'Books']) }}" class="hover:text-waqaf-green transition whitespace-nowrap {{ request('category') == 'Books' ? 'text-waqaf-green border-b-2 border-waqaf-green pb-1' : '' }}">Books</a>
                    <a href="{{ route('dashboard', ['category' => 'Clothes']) }}" class="hover:text-waqaf-green transition whitespace-nowrap {{ request('category') == 'Clothes' ? 'text-waqaf-green border-b-2 border-waqaf-green pb-1' : '' }}">Clothes</a>
                    <a href="{{ route('dashboard', ['category' => 'Food']) }}" class="hover:text-waqaf-green transition whitespace-nowrap {{ request('category') == 'Food' ? 'text-waqaf-green border-b-2 border-waqaf-green pb-1' : '' }}">Food</a>
                    <a href="{{ route('dashboard', ['category' => 'Electronics']) }}" class="hover:text-waqaf-green transition whitespace-nowrap {{ request('category') == 'Electronics' ? 'text-waqaf-green border-b-2 border-waqaf-green pb-1' : '' }}">Electronics</a>
                    <a href="{{ route('dashboard', ['category' => 'Others']) }}" class="hover:text-waqaf-green transition whitespace-nowrap {{ request('category') == 'Others' ? 'text-waqaf-green border-b-2 border-waqaf-green pb-1' : '' }}">Others</a>
                    
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.review') }}" class="flex items-center text-red-600 hover:text-red-800 transition whitespace-nowrap">
                            Admin&nbsp;Review
                            @if($adminPending > 0)
                                <span class="ml-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow-sm flex items-center justify-center">{{ $adminPending }}</span>
                            @endif
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 xl:gap-4 ml-4 flex-shrink min-w-0">
                


                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="hidden sm:flex items-center text-sm font-semibold text-gray-700 hover:text-waqaf-green focus:outline-none transition relative shrink-0">
                            <div class="relative mr-2">
                                <div class="w-9 h-9 rounded-lg bg-gray-200 flex items-center justify-center overflow-hidden border-2 border-gray-300 shadow-sm">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-bold text-gray-500 uppercase">{{ substr(Auth::user()->name, 0, 2) }}</span>
                                    @endif
                                </div>
                                @if($globalUnread > 0)
                                    <div class="absolute -top-1.5 -right-1.5 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full shadow-sm"></div>
                                @endif
                            </div>
                            <div class="text-left leading-tight">
                                <span class="block text-[10px] text-gray-400 font-bold uppercase">Welcome @if(Auth::check())<span class="text-[10px] text-gray-500 font-bold uppercase">&nbsp;•&nbsp;{{ Auth::user()->role === 'admin' ? 'Admin' : 'User' }}</span>@endif</span>
                                <span class="block text-sm truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile Settings') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('items.my-listings')">{{ __('My Activity') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('chat.index')">{{ __('Messages / Inbox') }} @if($globalUnread > 0) <span class="text-red-500 font-bold">({{ $globalUnread }})</span> @endif</x-dropdown-link>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50 hover:text-red-700">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                <a href="{{ route('items.create') }}" class="hidden md:flex bg-gray-800 text-white px-5 py-2.5 rounded-full font-bold hover:bg-gray-900 transition text-sm shadow-md items-center gap-1 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Donate
                </a>
                </a>

                <div class="flex items-center lg:hidden shrink-0">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out relative">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        @if($globalUnread > 0 && !isset($open))
                            <span class="absolute top-2 right-2 flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') && !request()->has('category') ? 'border-waqaf-green text-waqaf-green bg-green-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800' }} text-base font-medium transition">Dashboard</a>
            
            <a href="{{ route('chat.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('chat.*') ? 'border-waqaf-green text-waqaf-green bg-green-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800' }} text-base font-medium transition flex justify-between items-center">
                Inbox
                @if($globalUnread > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $globalUnread }}</span>
                @endif
            </a>

            <a href="{{ route('dashboard', ['category' => 'Books']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Books</a>
            <a href="{{ route('dashboard', ['category' => 'Clothes']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Clothes</a>
            <a href="{{ route('dashboard', ['category' => 'Food']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Food</a>
            <a href="{{ route('dashboard', ['category' => 'Electronics']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Electronics</a>
            <a href="{{ route('dashboard', ['category' => 'Others']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Others</a>
            
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.review') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-red-600 hover:bg-red-50 text-base font-bold transition">Admin Review</a>
            @endif

            <a href="{{ route('items.create') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-waqaf-green font-bold hover:bg-green-50 text-base transition">Donate an Item</a>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    (function(){
        const pollUrl = "{{ route('notifications.unread') }}";
        let lastUnread = {{ $globalUnread ?? 0 }};
        let lastPending = {{ $adminPending ?? 0 }};

        function showToast(message){
            let toast = document.getElementById('notif-toast');
            if(!toast){
                toast = document.createElement('div');
                toast.id = 'notif-toast';
                toast.className = 'fixed right-4 top-20 bg-white border border-gray-200 shadow-lg px-4 py-3 rounded-md z-50';
                document.body.appendChild(toast);
            }
            toast.textContent = message;
            toast.style.opacity = '1';
            setTimeout(()=>{ try{ toast.style.opacity = '0'; }catch(e){} }, 5000);
        }

        function updateBadges(count, pending){
            // Desktop inbox badge
            const inboxLink = document.querySelector('a[href="{{ route('chat.index') }}"]');
            if(inboxLink){
                let badge = inboxLink.querySelector('.dynamic-unread-badge');
                if(count > 0){
                    if(!badge){
                        badge = document.createElement('span');
                        badge.className = 'dynamic-unread-badge ml-1.5 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center justify-center';
                        inboxLink.appendChild(badge);
                    }
                    badge.textContent = count;
                } else if(badge){
                    badge.remove();
                }
            }

            // Admin review badge
            const adminLink = document.querySelector('a[href="{{ route('admin.review') }}"]');
            if(adminLink){
                let badge = adminLink.querySelector('.dynamic-admin-badge');
                if(pending > 0){
                    if(!badge){
                        badge = document.createElement('span');
                        badge.className = 'dynamic-admin-badge ml-1.5 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center justify-center';
                        adminLink.appendChild(badge);
                    }
                    badge.textContent = pending;
                } else if(badge){
                    badge.remove();
                }
            }

            // Avatar dot
            const avatarContainer = document.querySelector('.relative > .w-9');
            if(avatarContainer){
                let dot = avatarContainer.parentElement.querySelector('.dynamic-unread-dot');
                if(count > 0){
                    if(!dot){
                        dot = document.createElement('div');
                        dot.className = 'dynamic-unread-dot absolute -top-1.5 -right-1.5 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full shadow-sm';
                        avatarContainer.parentElement.appendChild(dot);
                    }
                } else if(dot){
                    dot.remove();
                }
            }
        }

        function notifyBrowser(title, body){
            if(!('Notification' in window)) return;
            if(Notification.permission === 'granted'){
                new Notification(title, { body });
            } else if(Notification.permission !== 'denied'){
                Notification.requestPermission().then(permission => {
                    if(permission === 'granted') new Notification(title, { body });
                });
            }
        }

        async function poll(){
            try{
                const res = await fetch(pollUrl, { credentials: 'same-origin' });
                if(!res.ok) return;
                const data = await res.json();
                const unread = parseInt(data.unread_messages || 0, 10);
                const pending = parseInt(data.pending_items || 0, 10);
                
                if(unread > lastUnread){
                    const diff = unread - lastUnread;
                    showToast(`You have ${diff} new message${diff>1?'s':''}`);
                    notifyBrowser('New Messages', `You have ${diff} new message${diff>1?'s':''}`);
                }
                
                if(pending > lastPending){
                    const diff = pending - lastPending;
                    showToast(`${diff} item${diff>1?'s':''} waiting for review`);
                    notifyBrowser('Items Pending Review', `${diff} item${diff>1?'s':''} waiting for your review`);
                }
                
                lastUnread = unread;
                lastPending = pending;
                updateBadges(unread, pending);
            }catch(e){
                console.error('Notification poll error', e);
            }
        }

        // initial badge update
        document.addEventListener('DOMContentLoaded', ()=>{
            updateBadges(lastUnread, lastPending);
            setInterval(poll, 30000); // every 30s
        });
    })();
</script>
@endpush