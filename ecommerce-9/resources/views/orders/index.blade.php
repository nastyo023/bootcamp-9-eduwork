<x-app-layout title="Riwayat Pesanan">
    <div class="container my-5">
        <h3 class="fw-bold mb-4"><i class="bi bi-bag-check me-2"></i>Riwayat Pesanan Saya</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(isset($orders) && $orders->count() > 0)
            <div class="d-flex flex-column gap-3">
                @foreach($orders as $order)
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                <div>
                                    <span class="fw-bold text-primary me-2">#{{ $order->order_number }}</span>
                                    <small class="text-muted">{{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</small>
                                </div>
                                <div>
                                    @if($order->status === 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu Pembayaran</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Diproses</span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <p class="mb-1 text-muted small">Total Tagihan</p>
                                    <h5 class="fw-bold text-dark mb-0">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h5>
                                    <small class="text-muted">Metode: {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</small>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <a href="{{ route('orders.show', $order->order_number ?? $order->id) }}" class="btn btn-outline-primary fw-bold px-4 rounded-pill">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="card border-0 shadow-sm p-5 text-center rounded-3">
                <i class="bi bi-receipt fs-1 text-muted d-block mb-3"></i>
                <h5 class="fw-bold">Belum Ada Pesanan</h5>
                <p class="text-muted">Kamu belum melakukan transaksi apapun.</p>
                <a href="{{ route('home') }}" class="btn btn-primary fw-bold px-4 py-2 mt-2 w-auto mx-auto rounded-pill">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</x-app-layout>