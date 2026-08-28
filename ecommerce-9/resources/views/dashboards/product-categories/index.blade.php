<x-app-layout title="Product Categories">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Categories') }}
            </h2>
            <a href="{{ route('product-categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'create_category')"
            >Add Category</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success and Errors Messages --}}
            <x-success-errors-message />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    {{-- Display Product Categories data in table view --}}
                    <table class="table-auto w-full !my-4" id="categories-table">
                        <thead class="">
                            <tr>
                                <th class="px-4 py-2 bg-gray-200 border border-black">ID</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Name</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Slug</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Products Count</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Products Stock</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="border px-4 py-2">{{ $category->id }}</td>
                                    <td class="border px-4 py-2">{{ $category->name }}</td>
                                    <td class="border px-4 py-2">{{ $category->slug }}</td>
                                    <td class="border px-4 py-2">{{ $category->products_count }}</td>
                                    <td class="border px-4 py-2">{{ $category->products_sum_stock ?? '0' }}</td>
                                    <td class="border px-4 py-2 flex flex-wrap gap-2 items-center">
                                        <a href="#!" 
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'edit_category{{ $category->id }}')"
                                        class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">Edit</a>
                                        <button type="button" 
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'delete_category{{ $category->id }}')"
                                        class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-700 cursor-pointer">Delete</button>
                                    </td>
                                </tr>
                                @push('scripts')
                                <x-modal name="edit_category{{ $category->id }}" max-width="lg" focusable>
                                    <form method="post" action="{{ route('product-categories.update', $category->id) }}" class="p-6">
                                        @csrf
                                        @method('PUT')
                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Edit Category') }}
                                        </h2>

                                        <div class="mt-6">
                                            <x-input-label for="name" value="{{ __('Category Name') }}" class="sr-only" />

                                            <x-text-input
                                                id="name"
                                                name="name"
                                                type="text"
                                                class="mt-1 block w-full"
                                                value="{{ old('name', $category->name) }}"
                                                placeholder="{{ __('Category Name') }}"
                                            />

                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-primary-button class="ms-3">
                                                {{ __('Update Category') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </x-modal>
                                <x-modal name="delete_category{{ $category->id }}" max-width="lg" focusable>
                                    <form method="post" action="{{ route('product-categories.destroy', $category) }}" class="p-6">
                                        @csrf
                                        @method('DELETE')
                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Delete ' . $category->name . ' Category') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ __('Are you sure you want to delete this category? This action cannot be undone.') }}
                                        </p>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-danger-button class="ms-3">
                                                {{ __('Delete Category') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </x-modal>
                                @endpush
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@push('styles')
    {{-- datatable js css cdn --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        .dataTables_filter{
            margin-bottom: 1rem;
        }
    </style>
@endpush
@push('scripts')
    <x-modal name="create_category" max-width="lg" focusable>
        <form method="post" action="{{ route('product-categories.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create New Category') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="name" value="{{ __('Category Name') }}" class="sr-only" />

                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Category Name') }}"
                    minlength="3"
                    maxlength="50"
                    value="{{ old('name') }}"
                    required
                />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Create Category') }}
                </x-primary-button>
            </div>
    </x-modal>
    {{-- datatable js cdn --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#categories-table').DataTable();
        });
    </script>
@endpush
</x-app-layout>