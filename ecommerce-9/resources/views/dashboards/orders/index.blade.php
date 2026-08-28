<x-app-layout title="Orders">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Display Products data in table view --}}
                    <div class="overflow-x-auto">
                    <table class="table-auto w-full overflow-x-auto" id="products-table">
                        <thead class="">
                            <tr>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Order_number</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Name</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Phone</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Total items</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Total amount</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Payment Method</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Status</th>
                                <th class="px-4 py-2 bg-gray-200 border border-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="border px-4 py-2">{{ $order->order_number }}</td>
                                    <td class="border px-4 py-2">{{ $order->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $order->user->phone }}</td>
                                    <td class="border px-4 py-2">{{ $order->order_items_count }}</td>
                                    <td class="border px-4 py-2">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">{{ $order->payment_method }}</td>
                                    <td class="border px-4 py-2">{{ $order->status }}</td>
                                    <td class="border px-4 py-2 flex flex-wrap gap-2 items-center">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('orders.edit', $order->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">Edit</a>
                                        {{-- Delete button --}}
                                       <button type="button" 
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'delete_order{{ $order->id }}')"
                                        class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-700 cursor-pointer">Delete</button>
                                    </td>
                                </tr>
                            @push('scripts')
                            {{-- Delete Product Modal --}}
                            <x-modal name="delete_order{{ $order->id }}" max-width="lg" focusable>
                                    <form method="post" action="{{ route('orders.destroy', $order->id) }}" class="p-6">
                                        @csrf
                                        @method('DELETE')
                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Delete Order ' . $order->order_number) }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ __('Are you sure you want to delete this order? This action cannot be undone.') }}
                                        </p>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-danger-button class="ms-3">
                                                {{ __('Delete Order') }}
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
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>