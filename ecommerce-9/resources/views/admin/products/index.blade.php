@extends('admin.layouts.app')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h5 class="fw-bold text-dark mb-0">Daftar Produk</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>

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
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded-3 object-fit-cover" style="width: 50px; height: 50px;">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                    <i class="bi bi-image fs-4"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold text-dark d-block">{{ $product->name }}</span>
                            <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="fw-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($product->stock > 10)
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">{{ $product->stock }} unit</span>
                            @elseif($product->stock > 0)
                                <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1">Sisa {{ $product->stock }}</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Habis</span>
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
                            <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary"></i>
                            Belum ada produk yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($products) && method_exists($products, 'links'))
        <div class="card-footer bg-white border-0 py-3">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection