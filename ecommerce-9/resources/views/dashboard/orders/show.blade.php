<x-app-layout title="Detail Pesanan #{{ $order->order_number ?? $order->id }}">
    <div class="container my-5">
        
        <!-- BREADCRUMB & HEADER ACTION -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none">Riwayat Pesanan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail #{{ $order->order_number ?? $order->id }}</li>
                </ol>
            </nav>

            <!-- TOMBOL CETAK INVOICE -->
            @if(Route::has('orders.invoice'))
                <div>
                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i class="fa-solid fa-print me-1"></i> Cetak Invoice
                    </a>
                </div>
            @endif
        </div>

        <!-- FLASH MESSAGES -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Rincian Produk & Pengiriman (Sisi Kiri) -->
            <div class="col-lg-8">
                
                <!-- RINCIAN PRODUK -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold m-0">Produk yang Dibeli</h5>
                        <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Produk</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->orderItems as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if(optional($item->product)->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded" style="width: 55px; height: 55px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 55px; height: 55px;">
                                                            <i class="fa-solid fa-image fs-4"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="fw-semibold mb-1 text-dark">{{ optional($item->product)->name ?? 'Produk Tidak Ditemukan' }}</h6>
                                                        @if(isset($item->variant))
                                                            <span class="badge bg-light text-secondary border fs- tiny">Varian: {{ $item->variant }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-center"><span class="badge bg-light text-dark px-2 py-1 border">{{ $item->quantity }}</span></td>
                                            <td class="text-end pe-4 fw-semibold text-primary">
                                                Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                Tidak ada rincian produk untuk pesanan ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- INFORMASI PENGIRIMAN & NO RESI -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold m-0"><i class="fa-solid fa-location-dot me-2 text-danger"></i> Informasi Pengiriman</h5>
                        @if($order->courier)
                            <span class="badge bg-light text-dark border"><i class="fa-solid fa-truck-fast me-1"></i> {{ strtoupper($order->courier) }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7 mb-3 mb-md-0">
                                <p class="fw-semibold mb-1">{{ $order->customer_name ?? auth()->user()?->name ?? 'Pelanggan' }}</p>
                                <p class="text-muted mb-1"><i class="fa-solid fa-phone me-1 small"></i> {{ $order->customer_phone ?? '-' }}</p>
                                <p class="text-muted mb-0"><i class="fa-solid fa-map-marker-alt me-1 small"></i> {{ $order->customer_address ?? $order->shipping_address ?? 'Alamat pengiriman belum diisi.' }}</p>
                            </div>
                            
                            <!-- INFORMASI RESI (JIKA SUDAH DIKIRIM) -->
                            @if($order->tracking_number)
                                <div class="col-md-5 border-start-md ps-md-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <span class="text-muted small d-block mb-1">Nomor Resi:</span>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <strong class="text-primary fs-6 mb-0">{{ $order->tracking_number }}</strong>
                                            <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}')" title="Salin Resi">
                                                <i class="fa-regular fa-copy"></i>
                                            </button>
                                        </div>
                                        @if($order->shipping_status)
                                            <small class="text-success d-block mt-2"><i class="fa-solid fa-circle-info me-1"></i> Status: {{ ucfirst($order->shipping_status) }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Rincian Pembayaran (Sisi Kanan) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold m-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <!-- STATUS PESANAN -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Status Pesanan:</span>
                            @if($order->status == 'completed')
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"><i class="fa-solid fa-check me-1"></i> Selesai</span>
                            @elseif($order->status == 'pending')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2"><i class="fa-solid fa-clock me-1"></i> Menunggu Pembayaran</span>
                            @elseif($order->status == 'processing')
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-2"><i class="fa-solid fa-spinner fa-spin me-1"></i> Diproses</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2"><i class="fa-solid fa-truck me-1"></i> Dalam Pengiriman</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2"><i class="fa-solid fa-xmark me-1"></i> Dibatalkan</span>
                            @endif
                        </div>

                        <!-- METODE PEMBAYARAN -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Metode Pembayaran:</span>
                            <span class="fw-semibold text-uppercase badge bg-light text-dark border">{{ str_replace('_', ' ', $order->payment_method ?? '-') }}</span>
                        </div>

                        <hr class="my-3">

                        <!-- RINCIAN BIAYA -->
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal Produk</span>
                            <span>Rp{{ number_format($order->subtotal ?? $order->total_amount ?? $order->total_price ?? 0, 0, ',', '.') }}</span>
                        </div>
                        
                        @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Biaya Pengiriman</span>
                                <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Biaya Pengiriman</span>
                                <span class="text-success fw-semibold">Gratis</span>
                            </div>
                        @endif

                        @if(isset($order->discount) && $order->discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-danger">
                                <span>Diskon / Potongan</span>
                                <span>-Rp{{ number_format($order->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <hr class="my-3">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold text-dark fs-6">Total Pembayaran</span>
                            <span class="fw-bold text-primary fs-5">Rp{{ number_format($order->total_amount ?? $order->total_price ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <!-- SECTION UPLOAD BUKTI BAYAR -->
                        <div class="pt-3 border-top mb-3">
                            <h6 class="fw-bold mb-3"><i class="fa-solid fa-receipt me-1 text-primary"></i> Bukti Pembayaran</h6>

                            @if($order->payment_proof)
                                <div class="mb-3 text-center">
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Transfer" class="img-fluid rounded border shadow-sm mb-2" style="max-height: 180px; object-fit: contain;">
                                    </a>
                                    <span class="d-block text-success small fw-semibold">
                                        <i class="fa-solid fa-circle-check me-1"></i> Bukti Pembayaran Terunggah
                                    </span>
                                </div>
                            @endif

                            @if($order->status == 'pending' && $order->payment_method !== 'cod')
                                <div class="alert alert-warning border-0 small mb-3">
                                    <i class="fa-solid fa-circle-info me-1"></i> Silakan unggah bukti transfer agar pesanan diproses.
                                </div>
                                <form action="{{ route('orders.uploadPayment', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <!-- PREVIEW GAMBAR SEBELUM UPLOAD -->
                                        <div id="imagePreviewContainer" class="d-none mb-2 text-center">
                                            <img id="imagePreview" src="#" alt="Preview Gambar" class="img-fluid rounded border" style="max-height: 150px;">
                                        </div>
                                        <input type="file" class="form-control form-control-sm @error('payment_proof') is-invalid @enderror" id="payment_proof" name="payment_proof" accept="image/*" required onchange="previewFile(this)">
                                        @error('payment_proof')
                                            <div class="invalid-feedback small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                                        <i class="fa-solid fa-upload me-1"></i> {{ $order->payment_proof ? 'Ganti Bukti Bayar' : 'Unggah Bukti Bayar' }}
                                    </button>
                                </form>
                            @elseif($order->payment_method === 'cod')
                                <div class="alert alert-info border-0 small mb-0">
                                    <i class="fa-solid fa-truck me-1"></i> Pembayaran dilakukan secara Cash on Delivery (COD) saat barang sampai.
                                </div>
                            @endif
                        </div>

                        <!-- STATUS FEEDBACK / ULASAN -->
                        @if($order->status == 'completed')
                            <div class="pt-3 border-top mb-3 text-center">
                                @if($order->feedback)
                                    <div class="alert alert-success border-0 small mb-0 text-start">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="fw-bold me-2">Ulasan Anda:</span>
                                            <span class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-{{ $i <= $order->feedback->rating ? 'solid' : 'regular' }} fa-star"></i>
                                                @endfor
                                            </span>
                                        </div>
                                        <p class="mb-0 text-muted fst-italic">"{{ $order->feedback->comment }}"</p>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-warning text-white w-100 rounded-pill py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                                        <i class="fa-solid fa-star me-1"></i> Beri Ulasan / Feedback
                                    </button>
                                @endif
                            </div>
                        @endif

                        <!-- TOMBOL BATALKAN PESANAN (Hanya jika status Pending) -->
                        @if($order->status == 'pending' && Route::has('orders.cancel'))
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')" class="mb-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-semibold btn-sm">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 fw-semibold mt-1">
                            Kembali ke Daftar Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL FORM FEEDBACK (INTERAKTIF STAR RATING) -->
    @if($order->status == 'completed' && !$order->feedback)
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="modal-header border-bottom">
                            <h5 class="modal-title fw-bold">Ulasan & Masukan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body p-4 text-center">
                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block mb-2">Penilaian Anda</label>
                                <!-- STAR RATING INTERAKTIF -->
                                <div class="star-rating fs-2 text-warning d-flex justify-content-center gap-2" style="cursor: pointer;">
                                    <i class="fa-regular fa-star star-btn" data-value="1"></i>
                                    <i class="fa-regular fa-star star-btn" data-value="2"></i>
                                    <i class="fa-regular fa-star star-btn" data-value="3"></i>
                                    <i class="fa-regular fa-star star-btn" data-value="4"></i>
                                    <i class="fa-regular fa-star star-btn" data-value="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" value="5" required>
                                <small class="text-muted d-block mt-1" id="ratingText">Sangat Puas (5/5)</small>
                            </div>

                            <div class="mb-3 text-start">
                                <label for="comment" class="form-label fw-semibold">Komentar / Masukan</label>
                                <textarea name="comment" id="comment" rows="4" class="form-control" placeholder="Tuliskan pengalaman belanja atau masukan Anda..." required></textarea>
                            </div>
                        </div>

                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">Kirim Ulasan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- JAVASCRIPT UNTUK PREVIEW GAMBAR & STAR RATING -->
    <script>
        // Preview Bukti Transfer
        function previewFile(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreviewContainer').classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        }

        // Script Star Rating Interaktif
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('ratingInput');
            const ratingText = document.getElementById('ratingText');

            const labels = {
                1: 'Sangat Buruk (1/5)',
                2: 'Kurang (2/5)',
                3: 'Cukup (3/5)',
                4: 'Puas (4/5)',
                5: 'Sangat Puas (5/5)'
            };

            function setStars(val) {
                stars.forEach((star, index) => {
                    if (index < val) {
                        star.classList.remove('fa-regular');
                        star.classList.add('fa-solid');
                    } else {
                        star.classList.remove('fa-solid');
                        star.classList.add('fa-regular');
                    }
                });
                if(ratingInput) ratingInput.value = val;
                if(ratingText) ratingText.textContent = labels[val];
            }

            // Set default 5 bintang
            setStars(5);

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    setStars(val);
                });
            });
        });
    </script>
</x-app-layout>