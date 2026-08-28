@props([
    'type' => 'success'
])
<div class="alert alert-{{ $type }}" role="alert">
  {{ $slot }}
</div>