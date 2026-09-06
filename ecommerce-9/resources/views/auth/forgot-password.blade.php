<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lupa Password - {{ config('app.name', 'E-Commerce') }}</title>

    <!-- Google Fonts & Bootstrap 5 & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-5 col-lg-4">
                
                <!-- Logo Brand Utama -->
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="text-decoration-none fw-bold text-primary fs-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-shop fs-2"></i> {{ config('app.name', 'E-Commerce') }}
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                                <i class="bi bi-key-fill fs-4"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1">Lupa Password?</h4>
                            <p class="text-muted small">
                                Masukkan email Anda dan kami akan mengirimkan tautan untuk me-reset password.
                            </p>
                        </div>

                        <!-- Alert Status Sukses -->
                        @if (session('status'))
                            <div class="alert alert-success d-flex align-items-center small mb-4 rounded-3 border-0 shadow-sm" role="alert">
                                <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
                                <div>{{ session('status') }}</div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Input Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label small fw-bold text-secondary">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="nama@email.com" 
                                           required 
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3 shadow-sm mb-3">
                                Kirim Link Reset
                            </button>

                            <!-- Back Link -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold text-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Masuk
                                </a>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Footer Copyright -->
                <div class="text-center mt-4">
                    <p class="text-muted small">&copy; {{ date('Y') }} {{ config('app.name', 'E-Commerce') }}. All rights reserved.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>