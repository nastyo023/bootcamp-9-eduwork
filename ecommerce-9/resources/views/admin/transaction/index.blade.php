@extends('admin.layouts.app')

@section('title', 'Kelola Transaksi')
@section('page-title', 'Daftar Transaksi & Pesanan')

@section('content')
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
                    <th>Status Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th class="text-center" style="width: 200px;">Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions ?? $orders ?? [] as $transaction)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ $transaction->id }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $transaction->user->name ?? 'Guest User' }}</div>
                            <small class="text-muted">{{ $transaction->user->email ?? '-' }}</small>
                        </td>
                        <td class="fw-bold text-success">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if(in_array($transaction->status, ['paid', 'lunas', 'completed']))
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Lunas
                                </span>
                            @elseif(in_array($transaction->status, ['pending', 'menunggu']))
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-clock-history me-1"></i> Menunggu
                                </span>
                            @elseif(in_array($transaction->status, ['shipped', 'dikirim']))
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-truck me-1"></i> Dikirim
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-x-circle-fill me-1"></i> {{ ucfirst($transaction->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="text-center">
                            <!-- Form Ubah Status Cepat -->
                            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PATCH')
                                <div class="input-group input-group-sm">
                                    <select name="status" class="form-select form-select-sm border-secondary-subtle" onchange="this.form.submit()">
                                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ in_array($transaction->status, ['paid', 'lunas']) ? 'selected' : '' }}>Lunas (Paid)</option>
                                        <option value="shipped" {{ in_array($transaction->status, ['shipped', 'dikirim']) ? 'selected' : '' }}>Dikirim</option>
                                        <option value="cancelled" {{ in_array($transaction->status, ['cancelled', 'batal']) ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
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
    @endif
</div>
@endsection