@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-6 col-lg-4">
            
            <!-- Card Container Confirm Password -->
            <div class="card border-0 shadow-lg rounded-4 p-4 bg-white">
                
                <!-- Header Card -->
                <div class="text-center mb-4">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 65px; height: 65px;">
                        <i class="fa-solid fa-user-shield fs-3"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Konfirmasi Kata Sandi</h4>
                    <p class="text-muted small mb-0">Ini adalah area aman. Harap konfirmasi kata sandi Anda sebelum melanjutkan.</p>
                </div>

                <!-- Form Confirm Password -->
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-secondary small">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input id="password" type="password" name="password" required autocomplete="current-password" autofocus
                                   class="form-control bg-light border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                   placeholder="••••••••">
                            <button class="btn btn-light border border-start-0 text-muted" type="button" onclick="togglePassword('password', 'eyeIcon')">
                                <i class="fa-regular fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold shadow-sm">
                        <i class="fa-solid fa-check-circle me-1"></i> Konfirmasi
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

<!-- Script Show / Hide Password -->
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection