<div class="card" style="width: 18rem;">
  <img src="{{ asset($image) }}" class="card-img-top" alt="...">
  <div class="card-body d-flex flex-column justify-content-between">
    <h5 class="card-title">{{ $title }}</h5>
    <a href="{{ route('products.show', $slug) }}" class="btn btn-warning">Lihat Detail</a>
  </div>
</div>