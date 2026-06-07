<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Welcome Back!</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email Address" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-waqaf-green focus:ring-waqaf-green rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <div class="flex justify-between items-center">
                <x-input-label for="password" value="Password" class="text-gray-700 font-semibold" />
                @if (Route::has('password.request'))
                    <a class="underline text-xs text-gray-600 hover:text-waqaf-green rounded-md focus:outline-none" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-waqaf-green focus:ring-waqaf-green rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-waqaf-green shadow-sm focus:ring-waqaf-green" name="remember">
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-waqaf-green rounded-md focus:outline-none" href="{{ route('register') }}">
                Need an account?
            </a>

            <button type="submit" class="bg-waqaf-green text-white px-6 py-2.5 rounded-md font-bold hover:bg-green-700 transition">
                Log In
            </button>
        </div>
    </form>
</x-guest-layout>