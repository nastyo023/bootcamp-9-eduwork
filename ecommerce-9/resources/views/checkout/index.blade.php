<x-app-layout title="Checkout">
    <div class="container my-5">
        <h3 class="fw-bold mb-1">Checkout</h3>
        <p class="text-muted mb-4">Periksa kembali pesanan Anda dan lengkapi informasi pengiriman.</p>

        @if(isset($cartItems) && count($cartItems) > 0)
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="row g-4">
                    
                    <!-- Form Informasi Pengiriman & Pembayaran -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt text-primary me-2"></i>Informasi Pengiriman</h5>
                                <hr class="text-muted opacity-25 mb-4">

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-medium">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name ?? '') }}" class="form-control" required placeholder="Masukkan nama penerima">
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-medium">Nomor Telepon / WhatsApp</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" class="form-control" required placeholder="Contoh: 08123456789">
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label fw-medium">Alamat Lengkap Pengiriman</label>
                                    <textarea name="address" id="address" rows="3" class="form-control" required placeholder="Nama jalan, nomor rumah, kecamatan, kota, kode pos">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3"><i class="bi bi-credit-card text-primary me-2"></i>Metode Pembayaran</h5>
                                <hr class="text-muted opacity-25 mb-4">

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label fw-medium">Pilih Metode Pembayaran</label>
                                    <select name="payment_method" id="payment_method" class="form-select" required>
                                        <option value="">-- Pilih Pembayaran --</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer (BCA, Mandiri, BRI)</option>
                                        <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD / Bayar di Tempat)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Pesanan -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>
                                <hr class="text-muted opacity-25">

                                <!-- Daftar Produk -->
                                <div class="mb-3" style="max-height: 280px; overflow-y: auto;">
                                    @php $grandTotal = 0; @endphp
                                    @foreach($cartItems as $cartItem)
                                        @php 
                                            $price = $cartItem->product->price ?? 0;
                                            $subtotal = $price * $cartItem->quantity;
                                            $grandTotal += $subtotal;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center mb-3 pe-2">
                                            <div class="d-flex align-items-center gap-3">
                                                {{-- Penanganan Gambar Produk (Mendukung URL Luar/Storage + Fallback Onerror) --}}
                                                @if(isset($cartItem->product->image) && $cartItem->product->image)
                                                    <img src="{{ \Illuminate\Support\Str::startsWith($cartItem->product->image, 'http') ? $cartItem->product->image : asset('storage/' . $cartItem->product->image) }}" 
                                                         onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Image';" 
                                                         class="rounded border" 
                                                         style="width: 48px; height: 48px; object-fit: cover;" 
                                                         alt="{{ $cartItem->product->name ?? 'Produk' }}">
                                                @else
                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center text-muted" style="width: 48px; height: 48px;">
                                                        <i class="bi bi-image fs-6"></i>
                                                    </div>
                                                @endif

                                                <div>
                                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ $cartItem->product->name ?? 'Produk' }}</h6>
                                                    <small class="text-muted">{{ $cartItem->quantity }}x @ Rp {{ number_format($price, 0, ',', '.') }}</small>
                                                </div>
                                            </div>
                                            <span class="fw-bold text-secondary ms-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="text-muted opacity-25">

                                <div class="d-flex justify-content-between mb-2 fs-6">
                                    <span class="text-secondary">Subtotal Produk</span>
                                    <span class="fw-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-3 fs-6">
                                    <span class="text-secondary">Biaya Pengiriman</span>
                                    <span class="text-success fw-bold">Gratis</span>
                                </div>

                                <hr class="text-muted opacity-25">

                                <div class="d-flex justify-content-between mb-4 fs-5 fw-bold">
                                    <span>Total Pembayaran</span>
                                    <span class="text-primary">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm">
                                    <i class="bi bi-shield-check me-2"></i> Buat Pesanan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        @else
            <!-- Tampilan jika tidak ada item untuk di-checkout -->
            <div class="card border-0 shadow-sm p-5 text-center rounded-3">
                <div class="py-4">
                    <i class="bi bi-bag-x fs-1 text-muted d-block mb-3"></i>
                    <h4 class="fw-bold text-dark">Tidak ada item untuk di-checkout</h4>
                    <p class="text-muted mb-4">Silakan tambahkan produk ke keranjang terlebih dahulu.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary fw-bold px-4 py-2">
                        Kembali Belanja
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>