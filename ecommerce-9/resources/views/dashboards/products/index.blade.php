<x-app-layout title="Products">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Add Product</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-success-errors-message />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap gap-2 mb-4">
                        {{-- order by --}}
                        <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-2">
                            <select name="order_by" class="border px-4 py-2 rounded">
                                <option value="">Order By</option>
                                <option value="name" {{ request('order_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('order_by') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="stock" {{ request('order_by') == 'stock' ? 'selected' : '' }}>Stock</option>
                            </select>
                            <select name="order_direction" class="border px-4 py-2 rounded">
                                <option value="">Order Direction</option>
                                <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('order_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                            <div class="relative">
                                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="border px-4 py-2 rounded">
                                {{-- reset x button inside input --}}
                                @if(request('search') || request('order_by') || request('order_direction'))
                                <a href="{{ route('products.index') }}" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ea3323" viewBox="0 -960 960 960"><path d="M480-424 364-308q-11 11-28 11t-28-11-11-28 11-28l116-116-116-115q-11-11-11-28t11-28 28-11 28 11l116 116 115-116q11-11 28-11t28 11q12 12 12 28.5T651-595L535-480l116 116q11 11 11 28t-11 28q-12 12-28.5 12T595-308z"/></svg>
                                </a>
                                @endif
                            </div>
                            {{-- <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button> --}}
                        </form>
                        @push('scripts')
                            <script>
                                // Submit the form when the select value changes
                                document.querySelectorAll('select[name="order_by"], select[name="order_direction"]').forEach(select => {
                                    select.addEventListener('change', function() {
                                        this.form.submit();
                                    });
                                });
                                //auto submit the form when the user finish typing in the search input
                                document.querySelector('input[name="search"]').addEventListener('input', function() {
                                    clearTimeout(this.delay);
                                    this.delay = setTimeout(() => {
                                        this.form.submit();
                                    }, 500); // Adjust the delay as needed
                                });
                            </script>
                        @endpush
                        {{-- reset form --}}
                        {{-- @if(request('search'))
                            <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Reset</a>
                        @endif --}}
                    </div>
                    {{-- Display Products data in table view --}}
                    <div class="overflow-x-auto">
                    <table class="table-auto w-full overflow-x-auto" id="products-table">
                        <thead class="">
                            <tr>
                                <th class="px-4 py-2 bg-gray-200 border border-black">ID</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Name</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Description</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Category</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Price</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Image</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Stock</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="border px-4 py-2">{{ $product->id }}</td>
                                    <td class="border px-4 py-2">{{ $product->name }}</td>
                                    <td class="border px-4 py-2">
                                        <p class="line-clamp-2"> {{ $product->description }}</p>
                                    </td>
                                    <td class="border px-4 py-2">{{ $product->productCategory->name ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">
                                        @if ($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">{{ $product->stock }}</td>
                                    <td class="border px-4 py-2 flex flex-wrap gap-2 items-center">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">Edit</a>
                                        {{-- Delete button --}}
                                       <button type="button" 
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'delete_product{{ $product->id }}')"
                                        class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-700 cursor-pointer">Delete</button>
                                    </td>
                                </tr>
                            @push('scripts')
                            {{-- Delete Product Modal --}}
                            <x-modal name="delete_product{{ $product->id }}" max-width="lg" focusable>
                                    <form method="post" action="{{ route('products.destroy', $product->id) }}" class="p-6">
                                        @csrf
                                        @method('DELETE')
                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Delete ' . $product->name . ' Product') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ __('Are you sure you want to delete this product? This action cannot be undone.') }}
                                        </p>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-danger-button class="ms-3">
                                                {{ __('Delete Product') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </x-modal>
                                @endpush
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>