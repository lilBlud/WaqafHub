<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="border-b-2 border-gray-200 pb-2 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 uppercase tracking-wider">List Your Item</h2>
        </div>

        <form 
            x-data="{ 
                photoFiles: [], 
                photoPreviews: [], 
                
                handleFileChange(event) {
                    const newFiles = Array.from(event.target.files);
                    
                    if(this.photoFiles.length + newFiles.length > 5) {
                        alert('You can only upload a maximum of 5 photos total.');
                        event.target.value = ''; 
                        return;
                    }

                    newFiles.forEach(file => {
                        this.photoFiles.push(file); 
                        
                        let reader = new FileReader();
                        reader.onload = (e) => { this.photoPreviews.push(e.target.result); };
                        reader.readAsDataURL(file);
                    });
                    
                    event.target.value = '';
                },
                
                removePhoto(index) {
                    this.photoFiles.splice(index, 1);
                    this.photoPreviews.splice(index, 1);
                },

                syncInputBeforeSubmit() {
                    const dataTransfer = new DataTransfer();
                    this.photoFiles.forEach(file => dataTransfer.items.add(file));
                    this.$refs.photo.files = dataTransfer.files;
                }
            }" 
            x-on:submit="syncInputBeforeSubmit()"
            action="{{ route('items.store') }}" 
            method="POST" 
            enctype="multipart/form-data" 
            class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <div class="bg-gray-200 border-2 border-dashed border-gray-400 p-6 rounded-md flex flex-col items-center justify-center text-center min-h-[300px] relative">
                
                <input type="file" name="images[]" class="hidden" x-ref="photo" accept="image/*" multiple x-on:change="handleFileChange($event)">

                <div x-show="photoPreviews.length === 0" class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-gray-800 mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <button x-on:click.prevent="$refs.photo.click()" class="bg-waqaf-green text-white px-6 py-2 rounded-md font-semibold cursor-pointer hover:bg-green-700 transition shadow-md">
                        Select Photos
                    </button>
                    <p class="mt-4 text-gray-700 text-sm font-medium">Up to 5 photos total.</p>
                </div>

                <div x-show="photoPreviews.length > 0" style="display: none;" class="w-full flex flex-col items-center h-full justify-center gap-4">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 w-full mb-4">
                        <template x-for="(preview, index) in photoPreviews" :key="index">
                            <div class="relative h-24 w-full rounded-md bg-no-repeat bg-center shadow-sm border border-gray-300"
                                 x-bind:style="'background-image: url(\'' + preview + '\'); background-position: center center; background-size: contain;'">
                                 <button x-on:click.prevent="removePhoto(index)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700 shadow-md">
                                     &times;
                                 </button>
                            </div>
                        </template>
                    </div>
                    
                    <button x-show="photoFiles.length < 5" x-on:click.prevent="$refs.photo.click()" class="bg-white text-waqaf-green border border-gray-300 px-4 py-1.5 rounded-md font-semibold cursor-pointer hover:bg-gray-100 transition shadow-sm text-sm">
                        Add More Photos
                    </button>
                    <p x-show="photoFiles.length === 5" class="text-sm font-bold text-waqaf-green mt-auto">Maximum 5 photos reached.</p>
                </div>

                <x-input-error :messages="$errors->get('images')" class="mt-2 text-red-600 font-bold" />
            </div>

            <div class="space-y-4">
                
                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Listing Title" class="w-full border-gray-300 rounded focus:ring-waqaf-green focus:border-waqaf-green shadow-sm" required>
                    <x-input-error :messages="$errors->get('title')" class="mt-2 text-red-600" />
                </div>

                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <select name="category" class="w-full border-gray-300 rounded text-gray-600 focus:ring-waqaf-green focus:border-waqaf-green shadow-sm" required>
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
                    <p class="text-sm font-semibold text-gray-700 mb-2">Location</p>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Enter your location (e.g., Mahallah Uthman, Library)" class="w-full border-gray-300 rounded focus:ring-waqaf-green focus:border-waqaf-green shadow-sm text-gray-800" required>
                    <x-input-error :messages="$errors->get('location')" class="mt-2 text-red-600" />
                </div>

                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Condition</p>
                    <div class="flex flex-wrap gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="condition" value="Brand New" class="peer sr-only" {{ old('condition') == 'Brand New' ? 'checked' : '' }} required>
                            <span class="px-4 py-1.5 rounded-full border border-gray-400 bg-white text-sm peer-checked:bg-waqaf-green peer-checked:text-white peer-checked:border-waqaf-green transition block">Brand New</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="condition" value="Like New" class="peer sr-only" {{ old('condition') == 'Like New' ? 'checked' : '' }} required>
                            <span class="px-4 py-1.5 rounded-full border border-gray-400 bg-white text-sm peer-checked:bg-waqaf-green peer-checked:text-white peer-checked:border-waqaf-green transition block">Like New</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="condition" value="Lightly Used" class="peer sr-only" {{ old('condition') == 'Lightly Used' ? 'checked' : '' }} required>
                            <span class="px-4 py-1.5 rounded-full border border-gray-400 bg-white text-sm peer-checked:bg-waqaf-green peer-checked:text-white peer-checked:border-waqaf-green transition block">Lightly Used</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="condition" value="Heavily Used" class="peer sr-only" {{ old('condition') == 'Heavily Used' ? 'checked' : '' }} required>
                            <span class="px-4 py-1.5 rounded-full border border-gray-400 bg-white text-sm peer-checked:bg-waqaf-green peer-checked:text-white peer-checked:border-waqaf-green transition block">Heavily Used</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('condition')" class="mt-2 text-red-600" />
                </div>

                <div class="bg-gray-200 p-4 rounded-md border border-gray-300">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Description</p>
                    <textarea name="description" rows="3" placeholder="Write description" class="w-full border-gray-300 rounded focus:ring-waqaf-green focus:border-waqaf-green shadow-sm" required>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2 text-red-600" />
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-waqaf-green text-white px-8 py-2.5 rounded shadow hover:bg-green-700 transition font-semibold">List Item</button>
                </div>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-60">
            <div class="bg-waqaf-green text-white p-8 rounded-lg shadow-2xl max-w-sm w-full text-center relative border-t-4 border-emerald-300">
                <div class="mb-4 text-3xl font-bold italic tracking-widest">WAQAFHUB</div>
                <h2 class="text-2xl font-bold mb-4 uppercase">Thank You!</h2>
                <p class="mb-8 text-sm">{{ session('success') }}</p>
                <button @click="show = false" class="bg-white text-waqaf-green px-8 py-2 rounded-md font-bold hover:bg-gray-100 transition shadow">Close</button>
            </div>
        </div>
    @endif
</x-app-layout>