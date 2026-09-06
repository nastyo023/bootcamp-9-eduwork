@props(['title', 'description' => '', 'image' => null, 'price' => 0, 'slug' => '#'])

<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden w-100">
    <!-- Gambar Produk -->
    <a href="{{ route('products.show', $slug) }}" class="text-decoration-none">
        @if(!empty($image))
            @php
                // Cek apakah string $image sudah mengandung kata 'storage/' atau 'http'
                $imageUrl = Str::startsWith($image, ['http://', 'https://']) 
                    ? $image 
                    : (Str::startsWith($image, 'storage/') 
                        ? asset($image) 
                        : asset('storage/' . $image));
            @endphp
            <img src="{{ $imageUrl }}" 
                 class="card-img-top object-fit-cover" 
                 alt="{{ $title }}" 
                 style="height: 200px;"
                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'bg-light d-flex flex-column align-items-center justify-content-center text-muted\' style=\'height: 200px;\'><i class=\'bi bi-image fs-1 mb-1\'></i><span class=\'fw-semibold small\'>No Image</span></div>';">
        @else
            <!-- Tampilan jika variabel $image benar-benar kosong -->
            <div class="bg-light d-flex flex-column align-items-center justify-content-center text-muted" style="height: 200px;">
                <i class="bi bi-image fs-1 mb-1"></i>
                <span class="fw-semibold small">No Image</span>
            </div>
        @endif
    </a>

    <div class="card-body d-flex flex-column p-3">
        <!-- Nama Produk -->
        <a href="{{ route('products.show', $slug) }}" class="text-decoration-none text-dark">
            <h6 class="card-title fw-bold text-truncate mb-2" title="{{ $title }}">
                {{ $title }}
            </h6>
        </a>

        <!-- Deskripsi Singkat -->
        @if(!empty($description))
            <p class="text-muted small text-truncate mb-3">{{ $description }}</p>
        @endif

        <!-- Harga & Tombol Detail -->
        <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top">
            <span class="fw-bold text-primary">
                Rp {{ number_format($price, 0, ',', '.') }}
            </span>
            
            <a href="{{ route('products.show', $slug) }}" class="btn btn-primary btn-sm rounded-pill px-3">
                Lihat <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>