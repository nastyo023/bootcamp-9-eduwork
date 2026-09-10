@extends('admin.layouts.app')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi & Pesanan')

@section('content')
<div class="container-fluid py-3">

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
        <div class="card-header bg-white py-3 border-0">
            <h5 class="fw-bold text-dark mb-0">Daftar Transaksi</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th class="text-center">Bukti Transfer</th>
                        <th class="text-center">Status Saat Ini</th>
                        <th class="text-center" style="width: 220px;">Ubah Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $order->order_number ?? $order->id }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $order->customer_name ?? $order->user->name ?? 'Guest' }}</div>
                                <div class="small text-muted">{{ $order->customer_phone ?? $order->user->email ?? '-' }}</div>
                            </td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($order->total_amount ?? $order->total_price ?? 0, 0, ',', '.') }}
                            </td>
                            
                            <!-- BUKTI TRANSFER -->
                            <td class="text-center">
                                @if(!empty($order->payment_proof))
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalProof{{ $order->id }}">
                                        <i class="bi bi-receipt me-1"></i> Lihat Bukti
                                    </button>

                                    <!-- Modal Preview Bukti Transfer -->
                                    <div class="modal fade" id="modalProof{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4 border-0">
                                                <div class="modal-header border-0">
                                                    <h6 class="modal-title fw-bold">Bukti Pembayaran #{{ $order->order_number ?? $order->id }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center py-2">
                                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                                                         alt="Bukti Transfer" 
                                                         class="img-fluid rounded-3 border shadow-sm"
                                                         style="max-height: 400px; object-fit: contain;">
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-sm btn-primary rounded-pill w-100">
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

                            <!-- BADGE STATUS SAAT INI -->
                            <td class="text-center">
                                @php $st = strtolower($order->status); @endphp
                                @if($st == 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2">Pending</span>
                                @elseif($st == 'processing')
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-2">Processing</span>
                                @elseif($st == 'shipped')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">Shipped</span>
                                @elseif($st == 'completed')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Completed</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2">Cancelled</span>
                                @endif
                            </td>

                            <!-- FORM UBAH STATUS -->
                            <td class="text-center">
                                <form action="{{ route('admin.transactions.update', $order->id) }}" method="POST" class="d-flex gap-1 justify-content-center align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm rounded-3 border-secondary-subtle">
                                        <option value="pending" {{ $st == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $st == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $st == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="completed" {{ $st == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ in_array($st, ['cancelled', 'canceled']) ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-3 px-2" title="Simpan Perubahan">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>

                            <!-- AKSI DETAIL -->
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.transactions.show', $order->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection