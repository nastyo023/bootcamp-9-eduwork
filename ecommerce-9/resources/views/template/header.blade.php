<!-- FontAwesome Icons (Untuk Ikon Keranjang & Pencarian) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- NAVBAR UTAMA -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm py-2">
    <div class="container">
        <!-- BRAND / LOGO -->
        <a class="navbar-brand text-primary d-flex align-items-center gap-2" href="{{ route('home') }}">
            <i class="fa-solid fa-store fs-4"></i>
            <span class="fw-bold text-dark fs-5">E-Commerce</span>
        </a>

        <!-- TOGGLER MOBILE -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- NAVBAR CONTENT -->
        <div class="collapse navbar-collapse" id="navbarContent">
            
            <!-- SEARCH BAR CENTRAL -->
            <form action="{{ route('home') }}" method="GET" class="d-flex mx-auto my-2 my-lg-0 w-100" style="max-width: 450px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-end-0 ps-3" placeholder="Cari produk favoritmu..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary bg-light border-start-0 text-muted px-3" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>

            <!-- RIGHT MENU (Auth & Cart) -->
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @auth
                    <!-- TOMBOL QUICK ACCESS ADMIN (Hanya Muncul jika Role Admin) -->
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm rounded-pill px-3 fw-semibold shadow-sm">
                                <i class="fa-solid fa-user-shield me-1"></i> Panel Admin
                            </a>
                        </li>
                    @endif

                    <!-- CART BUTTON -->
                    <li class="nav-item">
                        <a href="{{ route('carts.index') }}" class="btn btn-light position-relative rounded-circle p-2 px-3 text-secondary">
                            <i class="fa-solid fa-cart-shopping fs-5"></i>
                            
                            @php
                                $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                            @endphp

                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- USER DROPDOWN -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-semibold d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 14px;">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name ?? 'User' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                            <!-- MENU KHUSUS ADMIN DI DROPDOWN -->
                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item py-2 fw-semibold text-danger" href="{{ route('admin.dashboard') }}">
                                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="fa-solid fa-user me-2 text-muted"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('orders.index') }}">
                                    <i class="fa-solid fa-box me-2 text-muted"></i> Pesanan Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- GUEST BUTTONS -->
                    <li class="nav-item">
                        <a class="btn btn-outline-primary px-4 rounded-pill font-semibold text-sm" href="{{ route('login') }}">Masuk</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-primary px-4 rounded-pill font-semibold text-sm shadow-sm" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                @endauth
            </ul>

        </div>
    </div>
</nav>