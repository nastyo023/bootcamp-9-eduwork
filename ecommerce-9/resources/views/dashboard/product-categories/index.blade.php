<x-app-layout title="Product Categories">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Product Categories') }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">Kelola kategori produk untuk klasifikasi katalog toko kamu.</p>
            </div>
            <button 
                type="button" 
                class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-4 py-2.5 rounded-xl shadow-sm hover:shadow transition-all duration-200 cursor-pointer"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'create_category')"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add Category</span>
            </button>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Success and Errors Messages --}}
            <x-success-errors-message />

            <!-- MAIN TABLE CARD -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-600 !my-2" id="categories-table">
                            <thead>
                                <tr class="text-xs font-bold text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <th scope="col" class="px-5 py-3.5 rounded-l-xl">ID</th>
                                    <th scope="col" class="px-5 py-3.5">Category Name</th>
                                    <th scope="col" class="px-5 py-3.5">Slug</th>
                                    <th scope="col" class="px-5 py-3.5 text-center">Products Count</th>
                                    <th scope="col" class="px-5 py-3.5 text-center">Total Stock</th>
                                    <th scope="col" class="px-5 py-3.5 text-right rounded-r-xl">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($categories as $category)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-5 py-4 font-semibold text-slate-400">
                                            #{{ $category->id }}
                                        </td>
                                        <td class="px-5 py-4 font-semibold text-slate-800">
                                            {{ $category->name }}
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-mono">
                                                {{ $category->slug }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                                {{ $category->products_count }} Products
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                {{ $category->products_sum_stock ?? '0' }} Units
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <div class="inline-flex items-center justify-end gap-2">
                                                <button 
                                                    type="button"
                                                    x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'edit_category{{ $category->id }}')"
                                                    class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-lg transition-colors"
                                                    title="Edit Category"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <button 
                                                    type="button" 
                                                    x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'delete_category{{ $category->id }}')"
                                                    class="p-2 text-rose-600 hover:text-rose-900 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                                                    title="Delete Category"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    @push('scripts')
                                    <!-- EDIT MODAL -->
                                    <x-modal name="edit_category{{ $category->id }}" max-width="lg" focusable>
                                        <form method="post" action="{{ route('admin.product-categories.update', $category->id) }}" class="p-6">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                                                <h3 class="text-lg font-bold text-slate-800">
                                                    {{ __('Edit Category') }}
                                                </h3>
                                            </div>

                                            <div class="space-y-4">
                                                <div>
                                                    <x-input-label for="name_{{ $category->id }}" value="{{ __('Category Name') }}" class="font-semibold text-slate-700" />
                                                    <x-text-input
                                                        id="name_{{ $category->id }}"
                                                        name="name"
                                                        type="text"
                                                        class="mt-1 block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                                        value="{{ old('name', $category->name) }}"
                                                        placeholder="Enter category name"
                                                        required
                                                    />
                                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                </div>
                                            </div>

                                            <div class="mt-6 flex justify-end gap-3 pt-3 border-t border-slate-100">
                                                <x-secondary-button x-on:click="$dispatch('close')" class="!rounded-xl">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>

                                                <x-primary-button class="!bg-indigo-600 hover:!bg-indigo-700 !rounded-xl">
                                                    {{ __('Update Category') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </x-modal>

                                    <!-- DELETE MODAL -->
                                    <x-modal name="delete_category{{ $category->id }}" max-width="lg" focusable>
                                        <form method="post" action="{{ route('admin.product-categories.destroy', $category) }}" class="p-6">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                                                <h3 class="text-lg font-bold text-slate-800">
                                                    {{ __('Delete Category') }}
                                                </h3>
                                            </div>

                                            <div class="p-4 bg-rose-50 rounded-xl mb-4 border border-rose-100">
                                                <p class="text-sm font-semibold text-rose-800">
                                                    Are you sure you want to delete "{{ $category->name }}"?
                                                </p>
                                                <p class="text-xs text-rose-600 mt-1">
                                                    This action cannot be undone and will affect all products linked to this category.
                                                </p>
                                            </div>

                                            <div class="flex justify-end gap-3 pt-2">
                                                <x-secondary-button x-on:click="$dispatch('close')" class="!rounded-xl">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>

                                                <x-danger-button class="!bg-rose-600 hover:!bg-rose-700 !rounded-xl">
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
    </div>

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        /* Custom Styling for DataTables to match Tailwind Design */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            padding: 0.4rem 0.8rem !important;
            font-size: 0.875rem !important;
            outline: none !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 1px #6366f1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #6366f1 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 0.5rem !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e0e7ff !important;
            color: #4338ca !important;
            border: none !important;
            border-radius: 0.5rem !important;
        }
        table.dataTable.no-footer {
            border-bottom: none !important;
        }
    </style>
@endpush

@push('scripts')
    <!-- CREATE MODAL -->
    <x-modal name="create_category" max-width="lg" focusable>
        <form method="post" action="{{ route('admin.product-categories.store') }}" class="p-6">
            @csrf
            
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">
                    {{ __('Create New Category') }}
                </h3>
            </div>

            <div class="space-y-4">
                <div>
                    <x-input-label for="create_name" value="{{ __('Category Name') }}" class="font-semibold text-slate-700" />
                    <x-text-input
                        id="create_name"
                        name="name"
                        type="text"
                        class="mt-1 block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        placeholder="e.g. Electronics, Clothing..."
                        minlength="3"
                        maxlength="50"
                        value="{{ old('name') }}"
                        required
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 pt-3 border-t border-slate-100">
                <x-secondary-button x-on:click="$dispatch('close')" class="!rounded-xl">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="!bg-indigo-600 hover:!bg-indigo-700 !rounded-xl">
                    {{ __('Create Category') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- DataTables JS CDN --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#categories-table').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search category...",
                }
            });
        });
    </script>
@endpush
</x-app-layout>