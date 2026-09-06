<x-app-layout title="Keranjang Belanja">
    <div class="container my-5">
        
        <h3 class="fw-bold mb-4">Keranjang Belanja</h3>

        <!-- Alert Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(isset($carts) && count($carts) > 0)
            <div class="row g-4">
                <!-- Tabel Item Keranjang -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light border-bottom">
                                        <tr>
                                            <th class="ps-4 py-3">Produk</th>
                                            <th class="py-3">Harga</th>
                                            <th class="py-3 text-center" style="width: 160px;">Jumlah</th>
                                            <th class="py-3 text-end">Subtotal</th>
                                            <th class="pe-4 py-3 text-center" style="width: 60px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalPrice = 0; @endphp
                                        @foreach ($carts as $cart)
                                            @php 
                                                $price = $cart->product->price ?? $cart->price ?? 0;
                                                $qty = $cart->quantity ?? 1;
                                                $subtotal = $price * $qty;
                                                $totalPrice += $subtotal;
                                            @endphp
                                            <tr>
                                                <td class="ps-4 py-3">
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if(isset($cart->product->image) && $cart->product->image)
                                                            <img src="{{ asset('storage/' . $cart->product->image) }}" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                                        @else
                                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                                                <i class="bi bi-image fs-5"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="fw-bold mb-0 text-dark">{{ $cart->product->name ?? 'Produk' }}</h6>
                                                            <small class="text-muted">{{ $cart->product->category->name ?? '' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-medium text-secondary">
                                                    Rp {{ number_format($price, 0, ',', '.') }}
                                                </td>

                                                <!-- Bagian Tambah/Kurang Quantity (Diperbaiki) -->
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        <!-- Tombol Kurangi (-) -->
                                                        <form action="{{ route('carts.update', ['cart' => $cart->id]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="quantity" value="{{ $qty - 1 }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary px-2" {{ $qty <= 1 ? 'disabled' : '' }}>
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                        </form>

                                                        <!-- Input Angka -->
                                                        <form action="{{ route('carts.update', ['cart' => $cart->id]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="number" name="quantity" class="form-control form-control-sm text-center px-1" 
                                                                   value="{{ $qty }}" min="1" style="width: 50px;" onchange="this.form.submit()">
                                                        </form>

                                                        <!-- Tombol Tambah (+) -->
                                                        <form action="{{ route('carts.update', ['cart' => $cart->id]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="quantity" value="{{ $qty + 1 }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary px-2">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>

                                                <td class="fw-bold text-primary text-end">
                                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                </td>
                                                <td class="pe-4 text-center">
                                                    <form action="{{ route('carts.destroy', ['cart' => $cart->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus item ini dari keranjang?')">
                                                            <i class="bi bi-trash fs-5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Belanja -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>
                            <hr class="text-muted opacity-25">
                            
                            <div class="d-flex justify-content-between mb-2 fs-6">
                                <span class="text-secondary">Total Harga</span>
                                <span class="fw-bold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            
                            <hr class="text-muted opacity-25">
                            
                            <div class="d-flex justify-content-between mb-4 fs-5 fw-bold">
                                <span>Total Tagihan</span>
                                <span class="text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') ?? '#' }}" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                                Lanjut ke Pembayaran &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Tampilan Jika Keranjang Kosong -->
            <div class="card border-0 shadow-sm p-5 text-center rounded-3">
                <div class="py-4">
                    <i class="bi bi-cart-x fs-1 text-muted d-block mb-3"></i>
                    <h4 class="fw-bold text-dark">Keranjang Belanja Kamu Kosong</h4>
                    <p class="text-muted mb-4">Yuk, cari produk menarik dan tambahkan ke keranjang sekarang!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary fw-bold px-4 py-2">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>