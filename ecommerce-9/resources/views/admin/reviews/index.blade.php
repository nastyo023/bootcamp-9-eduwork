@extends('admin.layouts.app')

@section('title', 'Ulasan & Feedback Pelanggan')
@section('page-title', 'Ulasan & Feedback Pelanggan')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">Daftar Feedback & Ulasan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Ulasan / Feedback</th>
                        <th>Rating</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews ?? [] as $index => $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $review->user->name ?? 'Anonim' }}</td>
                            <td>{{ $review->comment ?? $review->message ?? '-' }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill me-1"></i>{{ $review->rating ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $review->created_at ? $review->created_at->format('d M Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-chat-square-text fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada ulasan atau feedback dari pelanggan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection