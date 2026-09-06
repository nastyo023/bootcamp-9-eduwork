<x-app-layout title="Pesanan Saya">
    <div class="container my-5">
        
        <h3 class="fw-bold mb-4"><i class="bi bi-box-seam me-2"></i>Pesanan Saya</h3>

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

        @if(isset($orders) && count($orders) > 0)
            <div class="d-flex flex-column gap-3">
                @foreach ($orders as $order)
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom">
                            <div>
                                <span class="fw-bold text-dark me-2">Kode Pesanan: #{{ $order->code ?? $order->id }}</span>
                                <small class="text-muted">| {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</small>
                            </div>
                            <div>
                                <!-- Badge Metode Pembayaran -->
                                <span class="badge {{ strtoupper($order->payment_method ?? '') === 'COD' ? 'bg-secondary' : 'bg-info text-dark' }} me-2">
                                    {{ strtoupper($order->payment_method ?? 'TRANSFER') }}
                                </span>

                                <!-- Badge Status Transaksi -->
                                @php
                                    $status = strtolower($order->status ?? 'pending');
                                @endphp
                                @if($status === 'completed' || $status === 'success' || $status === 'selesai')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                                @elseif($status === 'pending' || $status === 'menunggu pembayaran')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Menunggu Pembayaran</span>
                                @elseif($status === 'processing' || $status === 'diproses')
                                    <span class="badge bg-primary"><i class="bi bi-box me-1"></i>Diproses</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>{{ ucfirst($status) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <!-- Daftar Produk dalam Pesanan -->
                            <div class="row align-items-center g-3">
                                <div class="col-md-8">
                                    @if(isset($order->items) && count($order->items) > 0)
                                        @foreach($order->items as $item)
                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                @if(isset($item->product->image) && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                                @else
                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image fs-5"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="fw-bold mb-0 text-dark">{{ $item->product->name ?? 'Produk' }}</h6>
                                                    <small class="text-muted">{{ $item->quantity ?? 1 }} x Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted mb-0">Detail produk pesanan</p>
                                    @endif
                                </div>

                                <div class="col-md-4 text-md-end border-start-md pt-3 pt-md-0">
                                    <small class="text-muted d-block">Total Tagihan</small>
                                    <h5 class="fw-bold text-primary mb-3">Rp {{ number_format($order->total_price ?? $order->grand_total ?? 0, 0, ',', '.') }}</h5>

                                    <!-- Tombol Aksi Sesuai Metode Pembayaran -->
                                    @if(strtoupper($order->payment_method ?? '') === 'TRANSFER' || strtoupper($order->payment_method ?? '') === 'TF')
                                        @if($order->payment_proof)
                                            <button class="btn btn-outline-success btn-sm fw-bold rounded-pill" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $order->id }}">
                                                <i class="bi bi-file-earmark-check me-1"></i>Bukti Transfer Terkirim
                                            </button>
                                        @else
                                            <button class="btn btn-primary btn-sm fw-bold rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadProofModal{{ $order->id }}">
                                                <i class="bi bi-upload me-1"></i>Upload Bukti TF
                                            </button>
                                        @endif
                                    @else
                                        <span class="text-muted small"><i class="bi bi-cash-stack me-1"></i>Bayar Tunai Saat Kurir Tiba (COD)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL UPLOAD BUKTI TRANSFER -->
                    @if(strtoupper($order->payment_method ?? '') === 'TRANSFER' || strtoupper($order->payment_method ?? '') === 'TF')
                        <div class="modal fade" id="uploadProofModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('orders.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Upload Bukti Transfer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-info border-0 rounded-3 mb-3">
                                                <small class="d-block fw-bold mb-1">Info Rekening Pembayaran:</small>
                                                <small class="d-block">BCA: <strong>1234567890</strong> a/n E-Commerce</small>
                                                <small class="d-block">Mandiri: <strong>0987654321</strong> a/n E-Commerce</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="payment_proof" class="form-label fw-medium">Pilih Foto Bukti Transfer <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="payment_proof" accept="image/*" required>
                                                <small class="text-muted">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary fw-bold px-4">Kirim Bukti</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL LIHAT BUKTI TRANSFER -->
                        @if($order->payment_proof)
                            <div class="modal fade" id="viewProofModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Bukti Transfer Saya</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center p-3">
                                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded border shadow-sm" alt="Bukti Transfer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                @endforeach
            </div>
        @else
            <!-- Tampilan Jika Pesanan Kosong -->
            <div class="card border-0 shadow-sm p-5 text-center rounded-3">
                <div class="py-4">
                    <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                    <h4 class="fw-bold text-dark">Belum Ada Pesanan</h4>
                    <p class="text-muted mb-4">Kamu belum pernah melakukan pesanan apapun.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary fw-bold px-4 py-2">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>