<x-app-layout title="Home Page">
    <!-- Custom Style iOS Modern -->
    <style>
        :root {
            --ios-bg: #f5f5f7;
            --ios-card-bg: rgba(255, 255, 255, 0.85);
            --ios-border: rgba(225, 225, 230, 0.6);
            --ios-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            --ios-shadow-hover: 0 16px 40px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--ios-bg);
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .ios-card {
            background: var(--ios-card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--ios-border);
            border-radius: 22px;
            box-shadow: var(--ios-shadow);
        }

        .ios-input, .ios-select {
            border: 1px solid var(--ios-border);
            border-radius: 14px;
            background: rgba(245, 245, 250, 0.8);
            padding: 10px 16px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .ios-input:focus, .ios-select:focus {
            background: #ffffff;
            border-color: #007aff;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.15);
            outline: none;
        }

        .btn-ios-primary {
            background: linear-gradient(135deg, #007aff, #0056b3);
            color: #ffffff;
            border-radius: 14px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.25);
            transition: all 0.2s ease;
        }

        .btn-ios-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 122, 255, 0.35);
            color: #ffffff;
        }

        .btn-ios-secondary {
            border-radius: 14px;
            background: rgba(225, 225, 230, 0.6);
            color: #3a3a3c;
            border: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-ios-secondary:hover {
            background: rgba(210, 210, 215, 0.8);
            color: #1c1c1e;
        }

        /* Hero Banner Custom */
        .carousel-item {
            border-radius: 24px;
            overflow: hidden;
        }
    </style>

    <div class="container my-4">

        <!-- 1. BANNER CAROUSEL BOOTSTRAP (iOS Gradient Banner Style) -->
        <div id="heroCarousel" class="carousel slide mb-4 ios-card overflow-hidden" data-bs-ride="carousel" data-bs-interval="4000">
            <!-- Indikator Titik -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>

            <!-- Slide Item -->
            <div class="carousel-inner">
                <div class="carousel-item active p-5 text-white text-center" style="background: linear-gradient(135deg, #007aff, #5856d6);">
                    <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold mb-2 shadow-sm">PROMO SPESIAL</span>
                    <h2 class="fw-bold tracking-tight">Diskon Akhir Tahun Hingga 50%!</h2>
                    <p class="mb-4 opacity-90">Dapatkan produk elektronik impianmu dengan harga promo terbatas.</p>
                    <a href="#katalog" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-primary shadow-sm">Belanja Sekarang &rarr;</a>
                </div>

                <div class="carousel-item p-5 text-white text-center" style="background: linear-gradient(135deg, #1c1c1e, #2c2c2e);">
                    <span class="badge bg-danger rounded-pill px-3 py-2 fw-semibold mb-2 shadow-sm">HOT ITEM</span>
                    <h2 class="fw-bold tracking-tight">Koleksi Gadget & Aksesoris Terbaru</h2>
                    <p class="mb-4 opacity-90">Produk paling dicari dengan garansi resmi dan kualitas terbaik.</p>
                    <a href="#katalog" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">Lihat Katalog</a>
                </div>

                <div class="carousel-item p-5 text-white text-center" style="background: linear-gradient(135deg, #34c759, #30d158);">
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-semibold mb-2 shadow-sm">BEBAS ONGKIR</span>
                    <h2 class="fw-bold tracking-tight">Gratis Pengiriman Seluruh Indonesia</h2>
                    <p class="mb-4 opacity-90">Belanja makin hemat tanpa dipikirkan ongkos kirim.</p>
                    <a href="#katalog" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-success shadow-sm">Klaim Promo</a>
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

        <!-- 2. FILTER & SEARCH BAR (iOS Glassmorphism Bar) -->
        <div id="katalog" class="ios-card p-3 p-md-4 mb-4">
            <form method="GET" action="{{ route('home') }}" class="row g-2 align-items-center">
                
                <div class="col-md-5">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control ios-input" placeholder="Cari nama produk..." value="{{ request()->input('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-select ios-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->input('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="sort" class="form-select ios-select">
                        <option value="">Urutkan</option>
                        <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                        <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-ios-primary w-100 py-2">Filter</button>
                    @if(request()->input('category') || request()->input('sort') || request()->input('search'))
                        <a href="{{ route('home') }}" class="btn btn-ios-secondary py-2 px-3">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- 3. GRID PRODUK -->
        <div class="row">
            @forelse ($products as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
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
                    <div class="ios-card p-5">
                        <i class="bi bi-search fs-1 text-secondary opacity-50 mb-2 d-block"></i>
                        <p class="text-secondary fs-5 mb-0">Produk yang kamu cari tidak ditemukan.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- 4. PAGINASI BOOTSTRAP 5 -->
        @if($products->hasPages())
            <div class="col-12 d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</x-app-layout>