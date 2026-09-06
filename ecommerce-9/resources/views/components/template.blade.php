<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-2">
    <div class="container">
        
        <!-- 1. LOGO E-COMMERCE -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark me-4" href="{{ route('home') }}">
            <i class="bi bi-shop text-primary fs-4"></i>
            <span>E-Commerce</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdminContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdminContent">
            
            <!-- 2. MENU NAVIGASI KHUSUS ADMIN (Dashboard, CRUD Produk, Kategori, Transaksi, Ulasan) -->
            @auth
                @if(Auth::user()->is_admin || Auth::user()->role === 'admin')
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold {{ request()->routeIs('admin.dashboard') ? 'active text-primary' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="masterDataDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-box-seam me-1"></i> Master Data
                            </a>
                            <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="masterDataDropdown">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('admin.products.index') }}">
                                        <i class="bi bi-boxes text-primary me-2"></i> CRUD Product
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('admin.categories.index') }}">
                                        <i class="bi bi-tags text-success me-2"></i> CRUD Product Category
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold {{ request()->routeIs('admin.transactions.*') ? 'active text-primary' : '' }}" href="{{ route('admin.transactions.index') }}">
                                <i class="bi bi-receipt me-1"></i> Transaction Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold {{ request()->routeIs('admin.reviews.*') ? 'active text-primary' : '' }}" href="{{ route('admin.reviews.index') }}">
                                <i class="bi bi-chat-left-text me-1"></i> Kelola Masukan
                            </a>
                        </li>
                    </ul>
                @else
                    <!-- Search Bar untuk Pelanggan Biasa -->
                    <div class="flex-grow-1 mx-lg-4 my-2 my-lg-0">
                        <form action="{{ route('home') }}" method="GET" class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-end-0" placeholder="Cari produk favoritmu..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary border-start-0 bg-light" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <!-- Search Bar untuk Guest -->
                <div class="flex-grow-1 mx-lg-4 my-2 my-lg-0">
                    <form action="{{ route('home') }}" method="GET" class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-end-0" placeholder="Cari produk favoritmu..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary border-start-0 bg-light" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            @endauth

            <!-- 3. KANAN: Keranjang & Dropdown Admin / User -->
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link position-relative p-2 rounded-circle bg-light d-flex align-items-center justify-content-center" href="{{ route('carts.index') }}" style="width: 38px; height: 38px;">
                        <i class="bi bi-cart3 text-dark fs-5"></i>
                    </a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 fw-semibold text-dark" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center font-bold" style="width: 32px; height: 32px; font-size: 14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userMenu">
                            <li class="px-3 py-2 border-bottom">
                                <span class="d-block text-muted fs-7">Login sebagai:</span>
                                <strong class="text-dark">{{ Auth::user()->email }}</strong>
                            </li>

                            @if(Auth::user()->is_admin || Auth::user()->role === 'admin')
                                <li><h6 class="dropdown-header text-uppercase mt-2">Menu Panel Admin</h6></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam me-2"></i> CRUD Product</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags me-2"></i> CRUD Product Category</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}"><i class="bi bi-receipt me-2"></i> Transaction Management</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reviews.index') }}"><i class="bi bi-chat-left-text me-2"></i> Kelola Masukan</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </a>
                            </li>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-primary btn-sm px-3 fw-semibold" href="{{ route('login') }}">Masuk</a>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>    <title>{{ $title }} | My E-commerce Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    @include('template.header')
    <main style="min-height: 100vh">
    {{ $slot }}
    </main>
    @include('template.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>