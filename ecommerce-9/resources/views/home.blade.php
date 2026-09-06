<x-app-layout title="Home Page">
    <div class="container my-4">

        <!-- 1. BANNER CAROUSEL BOOTSTRAP -->
        <div id="heroCarousel" class="carousel slide mb-4 shadow-sm rounded-3 overflow-hidden" data-bs-ride="carousel" data-bs-interval="4000">
            <!-- Indikator Titik -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>

            <!-- Slide Item -->
            <div class="carousel-inner">
                <div class="carousel-item active p-5 bg-primary text-white text-center">
                    <span class="badge bg-light text-primary mb-2">PROMO SPESIAL</span>
                    <h2 class="fw-bold">Diskon Akhir Tahun Hingga 50%!</h2>
                    <p class="mb-3">Dapatkan produk elektronik impianmu dengan harga promo terbatas.</p>
                    <a href="#katalog" class="btn btn-warning fw-bold">Belanja Sekarang &rarr;</a>
                </div>
                <div class="carousel-item p-5 bg-dark text-white text-center">
                    <span class="badge bg-danger mb-2">HOT ITEM</span>
                    <h2 class="fw-bold">Koleksi Gadget & Aksesoris Terbaru</h2>
                    <p class="mb-3">Produk paling dicari dengan garansi resmi dan kualitas terbaik.</p>
                    <a href="#katalog" class="btn btn-light fw-bold">Lihat Katalog</a>
                </div>
                <div class="carousel-item p-5 bg-success text-white text-center">
                    <span class="badge bg-warning text-dark mb-2">BEBAS ONGKIR</span>
                    <h2 class="fw-bold">Gratis Pengiriman Seluruh Indonesia</h2>
                    <p class="mb-3">Belanja makin hemat tanpa dipikirkan ongkos kirim.</p>
                    <a href="#katalog" class="btn btn-light fw-bold">Klaim Promo</a>
                </div>
            </div>

            <!-- Tombol Navigasi Kiri / Kanan -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- 2. FILTER & SEARCH BAR -->
        <div id="katalog" class="card card-body mb-4 shadow-sm border-0">
            <form method="GET" action="{{ route('home') }}" class="row g-2">
                
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request()->input('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->input('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="sort" class="form-select">
                        <option value="">Urutkan</option>
                        <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                        <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                    @if(request()->input('category') || request()->input('sort') || request()->input('search'))
                        <a href="{{ route('home') }}" class="btn btn-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- 3. GRID PRODUK -->
        <div class="row">
            @forelse ($products as $item)
                <div class="col-md-3 mb-4 d-flex">
                    <x-product-card 
                        :title="$item->name"
                        :description="$item->description"
                        :image="$item->image" 
                        :price="$item->price"
                        :slug="$item->slug ?? $item->id"
                    />
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">Produk tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        <!-- 4. PAGINASI BOOTSTRAP 5 -->
        <div class="col-12 d-flex justify-content-center mt-3">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>
</x-app-layout>