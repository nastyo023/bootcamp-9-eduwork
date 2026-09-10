@extends('admin.layouts.app')

@section('title', 'Kelola Transaksi')
@section('page-title', 'Daftar Transaksi & Pesanan')

@section('content')
<div class="container-fluid py-2">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Gagal memperbarui status:</strong>
            <ul class="mb-0 mt-1 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h5 class="fw-bold text-dark mb-0">Daftar Transaksi</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th class="text-center">Bukti Transfer</th>
                        <th class="text-center">Status Pembayaran</th>
                        <th>Tanggal Transaksi</th>
                        <th class="text-center" style="width: 180px;">Ubah Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions ?? $orders ?? [] as $transaction)
                        @php
                            $status = strtolower($transaction->status);
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $transaction->order_number ?? $transaction->id }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $transaction->customer_name ?? $transaction->user->name ?? 'Guest User' }}</div>
                                <small class="text-muted">{{ $transaction->customer_phone ?? $transaction->user->email ?? '-' }}</small>
                            </td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($transaction->total_amount ?? $transaction->total_price ?? 0, 0, ',', '.') }}
                            </td>
                            
                            <!-- KOLOM BUKTI TRANSFER USER -->
                            <td class="text-center">
                                @if(!empty($transaction->payment_proof))
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalProof{{ $transaction->id }}">
                                        <i class="bi bi-receipt me-1"></i> Lihat Bukti
                                    </button>

                                    <!-- Modal Pop-up Preview Bukti Transfer -->
                                    <div class="modal fade" id="modalProof{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4 border-0">
                                                <div class="modal-header border-0">
                                                    <h6 class="modal-title fw-bold">Bukti Pembayaran #{{ $transaction->order_number ?? $transaction->id }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center py-2">
                                                    <img src="{{ asset('storage/' . $transaction->payment_proof) }}" 
                                                         alt="Bukti Transfer" 
                                                         class="img-fluid rounded-3 border shadow-sm"
                                                         style="max-height: 400px; object-fit: contain;">
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="btn btn-sm btn-primary rounded-pill w-100">
                                                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Ukuran Penuh
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-light text-secondary border fw-normal">Belum Upload</span>
                                @endif
                            </td>

                            <!-- BADGE STATUS -->
                            <td class="text-center">
                                @if(in_array($status, ['completed', 'paid', 'lunas']))
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                    </span>
                                @elseif($status == 'processing')
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-gear-fill me-1"></i> Diproses
                                    </span>
                                @elseif($status == 'shipped')
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-truck me-1"></i> Dikirim
                                    </span>
                                @elseif($status == 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-x-circle-fill me-1"></i> Dibatalkan
                                    </span>
                                @endif
                            </td>

                            <td class="text-muted small">
                                {{ optional($transaction->created_at)->format('d M Y, H:i') ?? '-' }}
                            </td>

                            <!-- FORM UBAH STATUS (Sesuai ENUM Migration) -->
                            <td class="text-center">
                                <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="d-flex gap-1 align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm border-secondary-subtle">
                                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="completed" {{ in_array($status, ['completed', 'paid', 'lunas']) ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ in_array($status, ['cancelled', 'canceled', 'batal']) ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary" title="Simpan">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>

                            <td class="text-end pe-4">
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-receipt fs-1 d-block mb-2 text-secondary"></i>
                                Belum ada riwayat transaksi masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($transactions) && method_exists($transactions, 'links'))
            <div class="card-footer bg-white border-0 py-3">
                {{ $transactions->links() }}
            </div>
        @elseif(isset($orders) && method_exists($orders, 'links'))
            <div class="card-footer bg-white border-0 py-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection