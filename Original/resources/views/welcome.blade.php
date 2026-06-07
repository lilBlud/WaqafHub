<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IIUM Waqaf</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800 flex flex-col min-h-screen" x-data="{ 
    showLogin: {{ $errors->any() && !old('name') ? 'true' : 'false' }}, 
    showRegister: {{ $errors->any() && old('name') ? 'true' : 'false' }} 
}">

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
                        @auth
                            <a href="{{ route('dashboard') }}" class="hover:text-waqaf-green transition whitespace-nowrap">Dashboard</a>
                        @endauth
                        <a href="{{ route('dashboard', ['category' => 'Books']) }}" class="hover:text-waqaf-green transition whitespace-nowrap">Books</a>
                        <a href="{{ route('dashboard', ['category' => 'Clothes']) }}" class="hover:text-waqaf-green transition whitespace-nowrap">Clothes</a>
                        <a href="{{ route('dashboard', ['category' => 'Food']) }}" class="hover:text-waqaf-green transition whitespace-nowrap">Food</a>
                        <a href="{{ route('dashboard', ['category' => 'Electronics']) }}" class="hover:text-waqaf-green transition whitespace-nowrap">Electronics</a>
                        <a href="{{ route('dashboard', ['category' => 'Others']) }}" class="hover:text-waqaf-green transition whitespace-nowrap">Others</a>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 xl:gap-4 ml-4">
                    


                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="hidden sm:flex items-center gap-2 hover:opacity-80 transition cursor-pointer shrink-0">
                                <div class="w-9 h-9 rounded-lg bg-gray-200 flex items-center justify-center overflow-hidden border-2 border-gray-300 shadow-sm">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-bold text-gray-500 uppercase">{{ substr(Auth::user()->name, 0, 2) }}</span>
                                    @endif
                                </div>
                                <div class="hidden sm:block text-left leading-tight">
                                    <span class="block text-[10px] text-gray-400 font-bold uppercase">Go to Dashboard</span>
                                    <span class="block text-sm font-bold text-gray-700 truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                                </div>
                            </a>
                        @else
                            <button @click.prevent="showRegister = true" class="hidden sm:block text-sm font-bold text-gray-600 hover:text-waqaf-green transition shrink-0 whitespace-nowrap">Register</button>
                            <button @click.prevent="showLogin = true" class="hidden sm:block text-sm font-bold bg-waqaf-green text-white px-6 py-2.5 rounded-full hover:bg-green-700 transition shadow-sm shrink-0 whitespace-nowrap">Login</button>
                        @endauth
                    @endif

                    <a href="{{ route('items.create') }}" class="hidden md:flex bg-gray-800 text-white px-5 py-2.5 rounded-full font-bold hover:bg-gray-900 transition text-sm shadow-md items-center gap-1 shrink-0 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Donate
                    </a>

                    <div class="flex items-center lg:hidden shrink-0">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out relative">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-gray-200">
            <div class="pt-2 pb-3 space-y-1">
                @auth
                    <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Dashboard</a>
                @endauth
                <a href="{{ route('dashboard', ['category' => 'Books']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Books</a>
                <a href="{{ route('dashboard', ['category' => 'Clothes']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Clothes</a>
                <a href="{{ route('dashboard', ['category' => 'Food']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Food</a>
                <a href="{{ route('dashboard', ['category' => 'Electronics']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Electronics</a>
                <a href="{{ route('dashboard', ['category' => 'Others']) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Others</a>
                
                @guest
                    <button @click.prevent="showLogin = true" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-waqaf-green font-bold hover:bg-green-50 text-base transition">Login</button>
                    <button @click.prevent="showRegister = true" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 text-base font-medium transition">Register</button>
                @endguest
                <a href="{{ route('items.create') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-800 font-bold hover:bg-gray-50 text-base transition">Donate an Item</a>
            </div>

</div>
    </nav>

    <div class="w-full bg-waqaf-green py-20 shadow-md relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10 relative">
            <h1 class="text-white text-4xl sm:text-5xl font-black tracking-widest uppercase drop-shadow-md">Welcome to waqafhub</h1>
            <p class="text-green-100 mt-3 text-lg font-medium tracking-wide">Connecting the community through giving and sharing.</p>
        </div>
    </div>

    <main class="flex-grow">
        <div class="mt-10 border-b border-gray-200 pb-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-wide">Community Demands</h2>
                <a href="{{ route('demands.create') }}" class="bg-waqaf-green text-white px-5 py-2 rounded-md text-sm font-bold shadow hover:bg-green-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Post a Demand
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($demands as $demand)
                    <div class="bg-waqaf-green rounded-xl p-1.5 shadow-md flex flex-col transform hover:-translate-y-1 hover:shadow-xl transition duration-300">
                        <h4 class="text-white text-center text-sm font-bold my-2 truncate px-2">{{ $demand->title }}</h4>
                        <div class="bg-white rounded-lg p-3 flex-grow flex flex-col">
                            <div class="flex gap-3 mb-3">
                                <div class="w-1/2 bg-gray-100 h-32 flex items-center justify-center text-xs text-gray-400 rounded-md overflow-hidden border border-gray-200">
                                    @if(!empty($demand->images) && is_array($demand->images) && !empty($demand->images[0]))
                                        <img src="{{ asset('storage/' . $demand->images[0]) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="px-2 text-center">No Image</div>
                                    @endif
                                </div>
                                <div class="w-1/2 flex flex-col">
                                    <div class="flex items-center gap-2 mb-2 bg-gray-50 p-1.5 rounded border border-gray-100">
                                        <div class="w-6 h-6 bg-gray-300 rounded-md flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-white uppercase overflow-hidden">
                                            @if($demand->user->avatar)
                                                <img src="{{ asset('storage/' . $demand->user->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($demand->user->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-[10px] font-bold leading-tight truncate text-gray-800">{{ $demand->user->name }}</p>
                                        </div>
                                    </div>
                                    <p class="text-[11px] leading-tight text-gray-600 overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                                        {{ $demand->description }}
                                    </p>
                                </div>
                            </div>
                            
                            @auth
                                <a href="{{ route('chat.index', ['user' => $demand->user->id, 'item' => $demand->id]) }}" class="mt-auto w-full bg-waqaf-green text-white text-center font-bold py-2 rounded-md hover:bg-green-700 transition block text-sm shadow-sm">Chat to Fulfill</a>
                            @else
                                <button @click.prevent="showLogin = true" class="mt-auto w-full bg-gray-800 text-white text-center font-bold py-2 rounded-md hover:bg-gray-900 transition block text-sm shadow-sm">Log in to Contact</button>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center text-gray-500 shadow-sm">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-xl font-bold text-gray-700 mb-2">No items in demand right now.</p>
                        <p class="text-sm">Click 'Post a Demand' if you are looking for something specific!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t-8 border-waqaf-green">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div>
                    <span class="text-3xl font-black text-waqaf-green tracking-widest uppercase mb-4 block">IIUM WAQAF</span>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        IIUM Waqaf is a web-based platform designed to simplify and organize the process of item donation and requests within the community. Connect, share, and make a difference today.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block">Explore</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="{{ url('/') }}" class="hover:text-waqaf-green transition flex items-center gap-2"><span class="text-waqaf-green">›</span> Home</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-waqaf-green transition flex items-center gap-2"><span class="text-waqaf-green">›</span> Available Items</a></li>
                        <li><a href="{{ route('demands.create') }}" class="hover:text-waqaf-green transition flex items-center gap-2"><span class="text-waqaf-green">›</span> Post a Demand</a></li>
                        <li><a href="{{ route('items.create') }}" class="hover:text-waqaf-green transition flex items-center gap-2"><span class="text-waqaf-green">›</span> Donate an Item</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block">Contact Us</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-waqaf-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>International Islamic University Malaysia (IIUM)<br>Gombak, 53100 Selangor</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-waqaf-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>support@iiumwaqaf.edu.my</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} IIUM Waqaf. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <div x-show="showLogin" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm" x-transition>
        <div @click.away="showLogin = false" class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative border-t-8 border-waqaf-green">
            <button @click="showLogin = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl font-bold transition">&times;</button>
            
            <div class="text-center mb-8">
                <span class="text-2xl font-black text-waqaf-green tracking-widest uppercase block mb-2">IIUM WAQAF</span>
                <h2 class="text-xl font-bold text-gray-800">Welcome Back</h2>
                <p class="text-sm text-gray-500 mt-1">Log in to manage your items and requests.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full border-gray-300 bg-gray-50 rounded-lg focus:ring-waqaf-green focus:border-waqaf-green shadow-inner">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full border-gray-300 bg-gray-50 rounded-lg focus:ring-waqaf-green focus:border-waqaf-green shadow-inner">
                </div>
                
                <x-input-error :messages="$errors->get('email')" class="text-center text-red-600 font-bold text-sm" />
                
                <button type="submit" class="w-full bg-waqaf-green text-white py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-md mt-4">Log In</button>
                
                <div class="text-center text-sm mt-6 pt-6 border-t border-gray-100">
                    <span class="text-gray-600">Don't have an account?</span>
                    <button type="button" @click="showLogin = false; showRegister = true" class="text-waqaf-green font-bold hover:text-green-800 transition ml-1">Register here</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showRegister" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm" x-transition>
        <div @click.away="showRegister = false" class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full relative border-t-8 border-waqaf-green">
            <button @click="showRegister = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl font-bold transition">&times;</button>
            
            <div class="text-center mb-8">
                <span class="text-2xl font-black text-waqaf-green tracking-widest uppercase block mb-2">IIUM WAQAF</span>
                <h2 class="text-xl font-bold text-gray-800">Join the Community</h2>
                <p class="text-sm text-gray-500 mt-1">Create an account to donate or request items.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" required class="w-full border-gray-300 bg-gray-50 rounded-lg focus:ring-waqaf-green focus:border-waqaf-green shadow-inner">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full border-gray-300 bg-gray-50 rounded-lg focus:ring-waqaf-green focus:border-waqaf-green shadow-inner">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full border-gray-300 bg-gray-50 rounded-lg focus:ring-waqaf-green focus:border-waqaf-green shadow-inner">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full border-gray-300 bg-gray-50 rounded-lg focus:ring-waqaf-green focus:border-waqaf-green shadow-inner">
                </div>
                
                <x-input-error :messages="$errors->all()" class="text-center text-red-600 font-bold text-sm" />
                
                <button type="submit" class="w-full bg-waqaf-green text-white py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-md mt-4">Create Account</button>
                
                <div class="text-center text-sm mt-6 pt-6 border-t border-gray-100">
                    <span class="text-gray-600">Already have an account?</span>
                    <button type="button" @click="showRegister = false; showLogin = true" class="text-waqaf-green font-bold hover:text-green-800 transition ml-1">Log In</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>