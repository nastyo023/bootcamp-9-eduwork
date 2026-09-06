<x-app-layout title="Detail Pesanan #{{ $order->order_number }}">
    <div class="container my-5">
        <a href="{{ route('orders.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat Pesanan
        </a>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Rincian Pesanan & Barang -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Pesanan #{{ $order->order_number }}</h5>
                            <span class="badge bg-primary px-3 py-2 rounded-pill">{{ strtoupper($order->status) }}</span>
                        </div>
                        <p class="text-muted small">Tanggal Transaksi: {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>

                        <hr class="text-muted opacity-25">

                        <h6 class="fw-bold mb-3">Item Pesanan</h6>
                        @php $items = $order->orderItems->isNotEmpty() ? $order->orderItems : $order->items; @endphp
                        @foreach($items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="fw-semibold mb-0">{{ $item->product->name ?? 'Produk Dihapus' }}</h6>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="fw-bold text-dark">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach

                        <hr class="text-muted opacity-25">

                        <div class="d-flex justify-content-between fs-5 fw-bold">
                            <span>Total Pembayaran</span>
                            <span class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Upload / Preview Bukti Transfer -->
                @if($order->payment_method === 'bank_transfer')
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-bank me-2 text-primary"></i>Instruksi Pembayaran</h5>
                            <p class="text-muted small mb-3">Silakan transfer ke rekening berikut:</p>
                            
                            <div class="alert alert-light border rounded-3 p-3 mb-3">
                                <span class="d-block text-muted small">Bank BCA</span>
                                <strong class="fs-4 text-dark">123-456-7890</strong>
                                <span class="d-block text-muted small">a.n. Toko Saya</span>
                            </div>

                            @if($order->payment_proof)
                                <div class="alert alert-success border-0 mb-3">
                                    <i class="bi bi-check-circle me-1"></i> Bukti pembayaran telah diunggah dan sedang diverifikasi admin.
                                </div>
                                <div class="text-center mt-3">
                                    <p class="fw-medium text-muted mb-2">Bukti Transfer Anda:</p>
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Transfer" class="img-fluid rounded-3 shadow-sm border" style="max-height: 250px;">
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('orders.uploadProof', $order->order_number ?? $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="payment_proof" class="form-label fw-medium">Upload Bukti Transfer</label>
                                        <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">
                                        <i class="bi bi-upload me-1"></i> Kirim Bukti Transfer
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detail Penerima -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt text-primary me-2"></i>Alamat Pengiriman</h5>
                        <hr class="text-muted opacity-25">
                        
                        <p class="mb-1 fw-bold">{{ $order->customer_name }}</p>
                        <p class="mb-1 text-muted small">{{ $order->customer_phone }}</p>
                        <p class="mb-0 text-muted small">{{ $order->customer_address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>