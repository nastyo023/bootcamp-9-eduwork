<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-success-errors-message />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="font-bold text-xl mb-2">{{ $product->name }}</div>
                        <p class="text-gray-700 text-base mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-gray-600 text-sm mb-4">
                            Stok: {{ $product->stock }}
                        </p>
                        <p class="text-gray-500 text-xs">
                            Kategori: {{ $product->category->name ?? $product->productCategory->name ?? '-' }}
                        </p>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-6 rounded-lg text-center text-gray-500">
                        Tidak ada produk.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>