@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Ringkasan & Statistik Toko')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.25rem rgba(0, 0, 0, 0.08) !important;
    }
</style>
@endpush

@section('content')
<!-- Ringkasan Statistik Card -->
<div class="row g-3 mb-4">
    <!-- Total Pendapatan -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white stat-card h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Pendapatan</span>
                    <h4 class="fw-bold text-dark mt-1 mb-0">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                    <i class="bi bi-wallet2 fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pesanan -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white stat-card h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Pesanan</span>
                    <h4 class="fw-bold text-dark mt-1 mb-0">{{ number_format($totalOrders ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                    <i class="bi bi-cart-check fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Produk -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white stat-card h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Produk</span>
                    <h4 class="fw-bold text-dark mt-1 mb-0">{{ number_format($totalProducts ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pelanggan -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white stat-card h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Pelanggan</span>
                    <h4 class="fw-bold text-dark mt-1 mb-0">{{ number_format($totalUsers ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                    <i class="bi bi-people fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Transaksi Terbaru -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0">Pesanan Terbaru</h5>
        <a href="{{ Route::has('admin.transactions.index') ? route('admin.transactions.index') : '#' }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
            Lihat Semua
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">ID Pesanan</th>
                    <th>Nama Pembeli</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold">{{ $order->user->name ?? 'Guest' }}</span>
                            </div>
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @switch($order->status)
                                @case('paid')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Lunas</span>
                                    @break
                                @case('pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Menunggu</span>
                                    @break
                                @case('cancelled')
                                @case('failed')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Batal</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">{{ ucfirst($order->status) }}</span>
                            @endswitch
                        </td>
                        <td class="text-end pe-4 text-muted small">
                            {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            Belum ada transaksi masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection