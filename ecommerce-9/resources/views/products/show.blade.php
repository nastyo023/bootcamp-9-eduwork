<x-app-layout :title="$product->name">
    <div class="container my-4">
        
        <!-- Tombol Kembali -->
        <div class="mb-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Kembali ke Katalog
            </a>
        </div>

        <!-- Detail Utama Produk -->
        <div class="card shadow-sm mb-5 border-0">
            <div class="card-body p-4">
                <div class="row g-4 align-items-center">
                    
                    <!-- Area Gambar Produk -->
                    <div class="col-md-5 text-center">
                        <div class="bg-light rounded p-3 border overflow-hidden" style="max-height: 380px;">
                            @if ($product->image && file_exists(public_path($product->image)))
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 340px; object-fit: contain;">
                            @elseif (isset($product->image_url) && $product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 340px; object-fit: contain;">
                            @else
                                <div class="py-5 text-muted">
                                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                                    <span>Gambar Tidak Tersedia</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi Produk -->
                    <div class="col-md-7 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-2 px-3 py-2 text-uppercase">
                                {{ $product->category->name ?? $product->productCategory->name ?? 'Produk' }}
                            </span>

                            <h2 class="fw-bold text-dark mb-2">{{ $product->name }}</h2>

                            <h3 class="fw-bold text-success my-3">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </h3>

                            <hr class="text-muted opacity-25">

                            <div class="my-3">
                                <h6 class="fw-bold text-uppercase text-muted fs-7 mb-2">Deskripsi Produk</h6>
                                <p class="text-secondary lh-base mb-0">
                                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                                </p>
                            </div>

                            <div class="mb-3 text-muted fs-7">
                                Stok Tersedia: <strong class="text-dark">{{ $product->stock }} pcs</strong>
                            </div>
                        </div>

                        <!-- Form Tambah ke Keranjang -->
                        <div class="pt-2">
                            <form action="{{ route('carts.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                                    + Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Rekomendasi Produk Lainnya -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-5">
                <h4 class="fw-bold text-dark mb-3">Rekomendasi Produk Lainnya</h4>
                
                <div class="row">
                    @foreach ($relatedProducts as $related)
                        <div class="col-md-3 mb-4 d-flex">
                            <x-product-card 
                                :title="$related->name"
                                :description="$related->description"
                                :image="$related->image" 
                                :price="$related->price"
                                :slug="$related->slug ?? $related->id"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>