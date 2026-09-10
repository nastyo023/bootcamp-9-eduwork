@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border btn-sm rounded-circle">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="fw-bold text-dark mb-0">Edit Kategori</h5>
                </div>
            </div>
            <div class="card-body p-4">

                {{-- Tampilan Alert Jika Ada Validasi Gagal --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal memperbarui data:</strong>
                        <ul class="mb-0 mt-2 small ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Form Kirim Data Update --}}
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4 rounded-3">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i> Perbarui Kategori
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection