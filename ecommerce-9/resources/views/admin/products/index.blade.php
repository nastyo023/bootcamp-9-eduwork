@extends('admin.layouts.app')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@push('styles')
<style>
    .product-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <!-- Header & Action Button -->
    <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold text-dark mb-1">Daftar Produk</h5>
            <p class="text-muted small mb-0">Kelola katalog produk, stok, dan kategori toko Anda.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    </div>

    <!-- Toolbar Filter & Search -->
    <div class="card-body border-bottom bg-light bg-opacity-50 px-4 py-3">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control bg-white border-start-0 ps-0" 
                           placeholder="Cari nama produk..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-6 col-md-4">
                <select name="category_id" class="form-select bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark rounded-3 px-3 w-100 fw-semibold">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category_id']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-3 px-3" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Produk -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 80px;">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                    <tr>
                        <td class="ps-4">
                            @if($product->image)
                                @php
                                    // Otomatis deteksi & atur URL gambar agar tidak bentrok
                                    if (Str::startsWith($product->image, ['http://', 'https://'])) {
                                        $imageUrl = $product->image;
                                    } else {
                                        $cleanPath = ltrim(Str::replaceFirst('public/', '', $product->image), '/');
                                        $cleanPath = ltrim(Str::replaceFirst('storage/', '', $cleanPath), '/');
                                        $imageUrl = asset('storage/' . $cleanPath);
                                    }
                                @endphp

                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-img border"
                                     onerror="this.onerror=null; this.remove(); this.nextElementSibling.classList.remove('d-none');">
                                
                                {{-- Placeholder alternatif jika file fisik di storage tidak ditemukan --}}
                                <div class="product-img border bg-light d-flex align-items-center justify-content-center text-muted d-none">
                                    <i class="bi bi-image fs-4"></i>
                                </div>
                            @else
                                {{-- Placeholder jika image bernilai NULL --}}
                                <div class="product-img border bg-light d-flex align-items-center justify-content-center text-muted">
                                    <i class="bi bi-image fs-4"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold text-dark d-block">{{ $product->name }}</span>
                            <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                {{ Str::limit($product->description, 50) }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1.5 rounded-pill fw-semibold">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="fw-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($product->stock > 10)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 rounded-pill fw-semibold">
                                    {{ $product->stock }} unit
                                </span>
                            @elseif($product->stock > 0)
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1.5 rounded-pill fw-semibold">
                                    Sisa {{ $product->stock }}
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill fw-semibold">
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-light btn-sm rounded-circle text-primary border" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
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
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            <span class="fw-semibold d-block mb-1">Produk tidak ditemukan</span>
                            <small>Belum ada produk atau hasil pencarian tidak cocok.</small>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($products) && method_exists($products, 'links'))
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() ?? 0 }} produk
            </small>
            <div>
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    @endif
</div>
@endsection