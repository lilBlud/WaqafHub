<x-guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an Account</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Full Name" class="text-gray-700 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-waqaf-green focus:ring-waqaf-green rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email Address" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-waqaf-green focus:ring-waqaf-green rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="matric_number" value="Matric Number" class="text-gray-700 font-semibold" />
            <x-text-input id="matric_number" class="block mt-1 w-full border-gray-300 focus:border-waqaf-green focus:ring-waqaf-green rounded-md shadow-sm" type="text" name="matric_number" :value="old('matric_number')" required placeholder="e.g. 2112345" />
            <x-input-error :messages="$errors->get('matric_number')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="text-gray-700 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-waqaf-green focus:ring-waqaf-green rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" class="text-gray-700 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-waqaf-green focus:ring-waqaf-green rounded-md shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-waqaf-green rounded-md focus:outline-none" href="{{ route('login') }}">
                Already registered?
            </a>

            <button type="submit" class="bg-waqaf-green text-white px-6 py-2.5 rounded-md font-bold hover:bg-green-700 transition">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>