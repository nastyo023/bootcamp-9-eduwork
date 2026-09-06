<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center gap-2" href="{{ route('home') }}">
            <i class="bi bi-shop fs-4"></i> E-Commerce
        </a>

        <!-- Hamburger Button untuk Mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarMain">
            
            <!-- SEARCH BAR TENGAH (Untuk Semua User) -->
            <div class="mx-auto my-2 my-lg-0 w-50">
                <form action="{{ route('home') }}" method="GET" class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-end-0" placeholder="Cari produk favoritmu..." value="{{ request('search') }}">
                    <button class="btn btn-light border border-start-0 text-muted" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- MENU KANAN -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0 ms-auto">
                
                @auth
                    <!-- Tombol Panel Admin Merah (HANYA MUNCUL JIKA ADMIN) -->
                    @if(Auth::user()->role === 'admin' || Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill"></i> Panel Admin
                        </a>
                    @endif

                    <!-- Keranjang Belanja dengan Badge Notifikasi (User Logged In) -->
                    <a href="{{ route('carts.index') }}" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm position-relative" style="width: 40px; height: 40px;">
                        <i class="bi bi-cart fs-5 text-dark"></i>
                        @if(isset($cartCount) && $cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.65rem;">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                                <span class="visually-hidden">jumlah item</span>
                            </span>
                        @endif
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light border dropdown-toggle btn-sm rounded-pill px-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 12px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span>{{ Auth::user()->name }}</span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <!-- Menu Dashboard Admin (HANYA MUNCUL JIKA ADMIN) -->
                            @if(Auth::user()->role === 'admin' || Auth::user()->is_admin)
                                <li>
                                    <a class="dropdown-item text-danger fw-bold py-2 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Dashboard Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <!-- Menu Biasa (User & Admin) -->
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ Route::has('orders.index') ? route('orders.index') : '#' }}">
                                    <i class="bi bi-box-seam"></i> Pesanan Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2 d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Keranjang Guest (User Belum Login) -->
                    <a href="{{ route('carts.index') }}" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm position-relative me-1" style="width: 40px; height: 40px;" title="Keranjang Belanja">
                        <i class="bi bi-cart fs-5 text-dark"></i>
                    </a>

                    <!-- Tombol Masuk -->
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3 fw-bold rounded-2">
                        Masuk
                    </a>

                    <!-- Tombol Daftar (Register) -->
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3 fw-bold rounded-2 shadow-sm">
                            Daftar
                        </a>
                    @endif
                @endauth

            </div>
        </div>
    </div>
</nav>