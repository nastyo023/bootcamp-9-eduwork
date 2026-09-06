@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-5">
            
            <!-- Card Container Reset Password -->
            <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white">
                
                <!-- Header Card -->
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 65px; height: 65px;">
                        <i class="fa-solid fa-key fs-3"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Atur Ulang Kata Sandi</h3>
                    <p class="text-muted small mb-0">Silakan masukkan email dan kata sandi baru Anda.</p>
                </div>

                <!-- Form Reset Password -->
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary small">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                                   class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                                   placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <span class="text-danger small mt-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-secondary small">Kata Sandi Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="form-control bg-light border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                   placeholder="••••••••">
                            <button class="btn btn-light border border-start-0 text-muted" type="button" onclick="togglePassword('password', 'eyeIcon1')">
                                <i class="fa-regular fa-eye" id="eyeIcon1"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm New Password Input -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold text-secondary small">Konfirmasi Kata Sandi Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-shield-halved"></i></span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="form-control bg-light border-start-0 border-end-0 @error('password_confirmation') is-invalid @enderror" 
                                   placeholder="••••••••">
                            <button class="btn btn-light border border-start-0 text-muted" type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                                <i class="fa-regular fa-eye" id="eyeIcon2"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="text-danger small mt-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold shadow-sm">
                        <i class="fa-solid fa-rotate me-1"></i> Simpan Kata Sandi
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