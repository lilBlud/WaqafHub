<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="border-b-2 border-gray-200 pb-2 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 uppercase tracking-wider">Post a Demand Request</h2>
            <p class="text-sm text-gray-500 mt-1">Tell the community what item you are looking for.</p>
        </div>

        <form action="{{ route('demands.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6" novalidate>
            @csrf

            <div x-data="{ photoPreview: null }" class="bg-gray-200 border-2 border-dashed border-gray-400 p-6 rounded-md flex flex-col items-center justify-center text-center min-h-[300px] relative">
                <input type="file" name="images[]" class="hidden" x-ref="photo" accept="image/*" x-on:change="
                    const file = $event.target.files[0];
                    if(file) {
                        let reader = new FileReader();
                        reader.onload = (e) => { photoPreview = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                ">

                <div x-show="!photoPreview" class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-gray-800 mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <button x-on:click.prevent="$refs.photo.click()" class="bg-waqaf-green text-white px-6 py-2 rounded-md font-semibold cursor-pointer hover:bg-green-700 transition shadow-md">
                        Upload Reference Photo
                    </button>
                    <p class="mt-4 text-gray-700 text-sm font-medium">Optional: Add 1 photo of what you need.</p>
                </div>

                <div x-show="photoPreview" style="display: none;" class="w-full flex flex-col items-center justify-center h-full gap-4">
                    <div class="relative w-full max-w-md h-64 rounded-xl border border-gray-300 bg-white overflow-hidden shadow-sm flex items-center justify-center">
                        <img :src="photoPreview" alt="Uploaded reference" class="w-full h-full object-contain">
                    </div>
                    <p class="text-sm text-gray-600">This is your uploaded reference photo preview.</p>
                    <button x-on:click.prevent="$refs.photo.click()" class="bg-white text-waqaf-green border border-gray-300 px-4 py-1.5 rounded-md font-semibold cursor-pointer hover:bg-gray-100 transition shadow-sm text-sm">
                        Change Photo
                    </button>
                </div>
                <x-input-error :messages="$errors->get('images')" class="mt-2 text-red-600 font-bold" />
            </div>

            <div class="space-y-4">
                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="What do you need? (e.g. Maggi Kari, Law Book)" class="w-full border-gray-300 rounded focus:ring-waqaf-green focus:border-waqaf-green shadow-sm">
                    <x-input-error :messages="$errors->get('title')" class="mt-2 text-red-600" />
                </div>

                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <select name="category" class="w-full border-gray-300 rounded text-gray-600 focus:ring-waqaf-green focus:border-waqaf-green shadow-sm">
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select a Category</option>
                        <option value="Books" {{ old('category') == 'Books' ? 'selected' : '' }}>Books</option>
                        <option value="Clothes" {{ old('category') == 'Clothes' ? 'selected' : '' }}>Clothes</option>
                        <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food</option>
                        <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                    <x-input-error :messages="$errors->get('category')" class="mt-2 text-red-600" />
                </div>

                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Your Location</p>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Enter your location (e.g., Mahallah Uthman, Library)" class="w-full border-gray-300 rounded focus:ring-waqaf-green focus:border-waqaf-green shadow-sm text-gray-800">
                    <x-input-error :messages="$errors->get('location')" class="mt-2 text-red-600" />
                </div>

                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Description</p>
                    <textarea name="description" rows="4" placeholder="Why do you need this? Any specific details?" class="w-full border-gray-300 rounded focus:ring-waqaf-green focus:border-waqaf-green shadow-sm">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2 text-red-600" />
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-waqaf-green text-white px-8 py-2.5 rounded shadow hover:bg-green-700 transition font-semibold">Post Demand</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>