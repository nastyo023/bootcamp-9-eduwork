@extends('admin.layouts.app')

@section('title', 'Kelola Ulasan & Feedback')
@section('page-title', 'Ulasan & Feedback Pelanggan')

@section('content')
<div class="container-fluid py-3">

    <!-- NOTIFIKASI SUKSES -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- RINGKASAN STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-chat-left-text-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold">Total Ulasan</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalFeedback }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-star-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold">Rata-Rata Rating</small>
                        <h4 class="fw-bold mb-0 text-dark">
                            {{ number_format($avgRating, 1) }} <span class="fs-6 text-muted">/ 5.0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-hand-thumbs-up-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold">Puas (Rating 4-5)</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $satisfiedCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-hand-thumbs-down-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold">Perlu Perhatian (&le; 3)</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $needsAttentionCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL DAFTAR ULASAN -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-dark mb-0">Daftar Ulasan Masuk</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 60px;">No</th>
                        <th style="width: 220px;">Pelanggan</th>
                        <th style="width: 140px;">ID Pesanan</th>
                        <th class="text-center" style="width: 150px;">Rating</th>
                        <th>Komentar / Ulasan</th>
                        <th class="text-end pe-4" style="width: 160px;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">
                                {{ ($feedbacks->currentPage() - 1) * $feedbacks->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $item->user->name ?? 'Pelanggan' }}</div>
                                        <small class="text-muted">{{ $item->user->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-semibold">
                                    #{{ $item->order->order_number ?? $item->order_id }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="text-warning fs-6">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $item->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star text-muted opacity-25"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="fw-bold text-muted">{{ $item->rating }} / 5</small>
                            </td>
                            <td>
                                @if(!empty($item->comment))
                                    <p class="mb-0 text-dark small" style="white-space: pre-line;">{{ $item->comment }}</p>
                                @else
                                    <span class="text-muted italic small">Tidak ada ulasan tertulis.</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 text-muted small">
                                {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-chat-square-quote fs-1 d-block mb-2 text-muted"></i>
                                <span class="text-muted">Belum ada ulasan yang dikirim oleh pelanggan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($feedbacks, 'links'))
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-end">
                    {{ $feedbacks->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection