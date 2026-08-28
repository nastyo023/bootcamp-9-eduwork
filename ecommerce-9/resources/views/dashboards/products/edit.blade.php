<x-app-layout title="Products">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Croppie CSS --}}
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
                
                {{-- Form for creating a new product --}}
                <form method="POST" action="{{ route('products.update', $product->id) }}" id="productForm">
                    @method('PUT')
                    @csrf
                    {{-- Product Name input field --}}
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Product Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" placeholder="Enter product name" min="3" max="255" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    {{-- Product Description textarea field --}}
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Product Description')" />
                        <textarea id="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3" name="description" placeholder="Enter product description" required>{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Product Price')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" step="1" name="price" :value="old('price', $product->price)" placeholder="Enter product price" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    {{-- Product Price input field --}}
                    <div class="mb-4">
                        <x-input-label for="stock" :value="__('Product Stock')" />
                        <x-text-input id="stock" class="block mt-1 w-full" type="number" step="1" name="stock" :value="old('stock', $product->stock)" placeholder="Enter product stock" required />
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>

                    {{-- Product Category select field --}}
                    <div class="mb-4">
                        <x-input-label for="product_category_id" :value="__('Product Category')" />
                        <select id="product_category_id" name="product_category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3">
                            <option value="" disabled selected>Select a category</option>
                            @foreach($productCategories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
                    </div>

                    {{-- Product current image --}}
                    <div class="mb-4">
                        <x-input-label for="current_image" :value="__('Current Product Image')" />
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="Current Product Image" class="w-auto max-h-[200px] border rounded mt-2" />
                        @else
                            <p class="mt-2 text-gray-600">No image uploaded yet.</p>
                        @endif
                    </div>

                    {{-- Product Image file input field with Croppie --}}
                    <div class="mb-4">
                        <x-input-label for="imageInput" :value="__('Product Image')" />
                        <input id="imageInput" class="block mt-1 w-full" type="file" accept="image/*" />
                        <input type="hidden" name="image" id="croppedImage" />
                        
                        {{-- Image Preview --}}
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="previewImage" src="" alt="Preview" class="w-auto max-h-[200px] border rounded mt-2" />
                        </div>
                        
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    {{-- Form action buttons --}}
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Update Product') }}
                        </x-primary-button>
                        <x-secondary-button class="ml-4" onclick="window.location='{{ route('products.index') }}'">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Cropping Modal --}}
    <div id="cropperModal" class="hidden fixed z-50 inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Crop Image (1:1 Ratio)</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
            
            {{-- Croppie Container --}}
            <div id="image-cropper" class="border rounded mb-4" style="width: 100%; height: 400px;"></div>
            
            {{-- Zoom Slider --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Zoom</label>
                <input type="range" id="zoomSlider" min="0" max="2" step="0.1" value="1" class="w-full" onchange="updateZoom(this.value)">
            </div>
            
            {{-- Modal Action Buttons --}}
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <button type="button" onclick="cropImage()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Crop & Save
                </button>
            </div>
        </div>
    </div>

    {{-- Croppie JS Library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    
    <script>
        let croppieInstance = null;
        const validationErrors = {};
        
        // Form validation function
        function validateForm() {
            validationErrors.name = null;
            validationErrors.description = null;
            validationErrors.price = null;
            validationErrors.stock = null;
            validationErrors.product_category_id = null;
            validationErrors.image = null;
            
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();
            const price = document.getElementById('price').value.trim();
            const stock = document.getElementById('stock').value.trim();
            const category = document.getElementById('product_category_id').value;
            const croppedImage = document.getElementById('croppedImage').value;
            
            // Validate product name
            if (!name) {
                validationErrors.name = 'Product name is required';
            } else if (name.length < 3) {
                validationErrors.name = 'Product name must be at least 3 characters';
            } else if (name.length > 100) {
                validationErrors.name = 'Product name cannot exceed 100 characters';
            }
            
            // Validate description
            if (!description) {
                validationErrors.description = 'Product description is required';
            } else if (description.length < 10) {
                validationErrors.description = 'Product description must be at least 10 characters';
            }
            
            // Validate price
            if (!price) {
                validationErrors.price = 'Product price is required';
            } else if (isNaN(price)) {
                validationErrors.price = 'Product price must be a valid number';
            } else if (parseFloat(price) <= 0) {
                validationErrors.price = 'Product price must be greater than 0';
            }
            
            // Validate stock
            if (!stock) {
                validationErrors.stock = 'Product stock is required';
            } else if (isNaN(stock)) {
                validationErrors.stock = 'Product stock must be a valid number';
            } else if (parseInt(stock) < 0) {
                validationErrors.stock = 'Product stock cannot be negative';
            }
            
            // Validate category
            if (!category) {
                validationErrors.product_category_id = 'Please select a product category';
            }
            
            displayValidationErrors();
            return Object.values(validationErrors).every(error => error === null);
        }
        
        // Display validation errors
        function displayValidationErrors() {
            const errorFields = ['name', 'description', 'price', 'stock', 'product_category_id'];
            
            errorFields.forEach(field => {
                const element = document.getElementById(field);
                const errorElement = element.parentElement.querySelector('x-input-error');
                
                if (validationErrors[field]) {
                    element.classList.add('border-red-500');
                    if (errorElement) {
                        errorElement.textContent = validationErrors[field];
                        errorElement.style.display = 'block';
                    } else {
                        const newError = document.createElement('div');
                        newError.className = 'text-red-500 text-sm mt-1';
                        newError.textContent = validationErrors[field];
                        element.parentElement.appendChild(newError);
                    }
                } else {
                    element.classList.remove('border-red-500');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                }
            });
        }
        
        // Clear validation error on input change
        // Clear validation error on input change
        function clearValidationError(fieldName) {
            const element = document.getElementById(fieldName);
            element.classList.remove('border-red-500');
            validationErrors[fieldName] = null;
            const errorElement = element.parentElement.querySelector('x-input-error');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }
        
        // Add event listeners to clear errors on input
        document.getElementById('name').addEventListener('input', function() { clearValidationError('name'); });
        document.getElementById('description').addEventListener('input', function() { clearValidationError('description'); });
        document.getElementById('price').addEventListener('input', function() { clearValidationError('price'); });
        document.getElementById('stock').addEventListener('input', function() { clearValidationError('stock'); });
        document.getElementById('product_category_id').addEventListener('change', function() { clearValidationError('product_category_id'); });
        
        // Get submit button
        const submitButton = document.querySelector('button[type="submit"]');
        
        // Form submission validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default submission first
            
            if (!validateForm()) {
                // Disable submit button
                submitButton.disabled = true;
                submitButton.style.opacity = '0.5';
                submitButton.style.cursor = 'not-allowed';
                
                // Show alert message
                alert('Please fix all validation errors before submitting.');
                
                // Scroll to top to show errors
                window.scrollTo({ top: 0, behavior: 'smooth' });
                
                // Re-enable submit button so user can try again
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.style.opacity = '1';
                    submitButton.style.cursor = 'pointer';
                }, 500);
                return false;
            }
            
            // If validation passes, submit the form
            submitButton.disabled = true;
            submitButton.style.opacity = '0.6';
            submitButton.textContent = 'Updating...';
            this.submit();
        });
        
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    initializeCropper(event.target.result);
                    openModal();
                };
                reader.readAsDataURL(file);
            }
        });
        
        function initializeCropper(imageData) {
            const container = document.getElementById('image-cropper');
            
            // Destroy previous instance if exists
            if (croppieInstance) {
                croppieInstance.destroy();
            }
            
            // Initialize Croppie with 1:1 ratio
            croppieInstance = new Croppie(container, {
                url: imageData,
                viewport: {
                    width: 300,
                    height: 300,
                    type: 'square'
                },
                boundary: {
                    width: '100%',
                    height: 400
                },
                showZoomer: true,
                enableZoom: true,
                enableResize: false,
                mouseWheelZoom: true
            });
            
            // Reset zoom slider
            document.getElementById('zoomSlider').value = 1;
        }
        
        function updateZoom(value) {
            if (croppieInstance) {
                croppieInstance.setZoom(value);
            }
        }
        
        function openModal() {
            document.getElementById('cropperModal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('cropperModal').classList.add('hidden');
        }
        
        function cropImage() {
            if (croppieInstance) {
                croppieInstance.result({
                    type: 'base64',
                    size: 'viewport',
                    format: 'jpeg',
                    quality: 0.95
                }).then(function(base64) {
                    // Store the cropped image in the hidden input
                    document.getElementById('croppedImage').value = base64;
                    
                    // Display preview
                    document.getElementById('previewImage').src = base64;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    
                    // Clear image validation error
                    const imageElement = document.getElementById('image');
                    if (imageElement) {
                        clearValidationError('image');
                    }
                    
                    // Close modal
                    closeModal();
                });
            }
        }
        
        // Close modal when clicking outside of it
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('cropperModal');
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
</x-app-layout>