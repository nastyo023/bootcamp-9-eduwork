@extends('admin.layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Produk')

@section('content')
<!-- Alert Notifikasi -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Form Tambah/Edit Kategori -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold text-dark mb-0">
                    {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                </h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" placeholder="Contoh: Pakaian, Sepatu, Elektronik" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-semibold rounded-3 py-2">
                            <i class="bi {{ isset($category) ? 'bi-pencil-square' : 'bi-plus-circle' }} me-1"></i>
                            {{ isset($category) ? 'Perbarui Kategori' : 'Simpan Kategori' }}
                        </button>
                        @if(isset($category))
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light text-secondary rounded-3">Batal Edit</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Kategori -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">Daftar Kategori</h5>
                
                <!-- Form Pencarian Ringkas -->
                <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm rounded-3" placeholder="Cari kategori..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Produk</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $item)
                            <tr>
                                <td class="ps-4 text-muted">
                                    {{ method_exists($categories, 'firstItem') ? $categories->firstItem() + $index : $loop->iteration }}
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $item->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">
                                        {{ $item->products_count ?? 0 }} Produk
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a href="{{ route('admin.categories.index', ['edit' => $item->id]) }}" class="btn btn-light btn-sm rounded-circle text-primary border" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-circle text-danger border" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($categories, 'hasPages') && $categories->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection