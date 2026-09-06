<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'E-Commerce' }}</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Footer Styling */
        .footer-dark {
            background: #0f172a; /* Slate Dark */
            color: #94a3b8;
        }

        .footer-heading {
            color: #ffffff;
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 35px;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 2px;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #38bdf8;
            transform: translateX(5px);
        }

        .social-icon {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: #0d6efd;
            color: #ffffff;
            transform: translateY(-3px);
        }

        .newsletter-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .newsletter-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #0d6efd;
            color: #ffffff;
            box-shadow: none;
        }

        .newsletter-input::placeholder {
            color: #64748b;
        }

        .payment-badge {
            background: rgba(255, 255, 255, 0.9);
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            font-weight: bold;
            font-size: 0.75rem;
            color: #0f172a;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    @include('layouts.navigation')

    <!-- MAIN CONTENT -->
    <main class="py-4 flex-grow-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- FOOTER MODERN -->
    <footer class="footer-dark mt-auto pt-5 pb-3">
        <div class="container">
            <!-- Feature Badges Section -->
            <div class="row g-3 border-bottom border-secondary border-opacity-25 pb-4 mb-5 text-center text-md-start">
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <i class="bi bi-truck fs-2 text-primary"></i>
                        <div>
                            <h6 class="mb-0 text-white fw-bold small">Pengiriman Cepat</h6>
                            <small class="text-secondary">Ke seluruh Indonesia</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <i class="bi bi-shield-check fs-2 text-primary"></i>
                        <div>
                            <h6 class="mb-0 text-white fw-bold small">Pembayaran Aman</h6>
                            <small class="text-secondary">Terproteksi 100%</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <i class="bi bi-patch-check fs-2 text-primary"></i>
                        <div>
                            <h6 class="mb-0 text-white fw-bold small">Produk Original</h6>
                            <small class="text-secondary">Jaminan kualitas 100%</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <i class="bi bi-headset fs-2 text-primary"></i>
                        <div>
                            <h6 class="mb-0 text-white fw-bold small">Layanan 24/7</h6>
                            <small class="text-secondary">Dukungan CS siap bantu</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Links Section -->
            <div class="row g-4 mb-5">
                <!-- Branding & Social -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-bag-heart-fill fs-3 text-primary"></i>
                        <span class="fs-4 fw-extrabold text-white tracking-tight">{{ config('app.name', 'E-Store') }}</span>
                    </div>
                    <p class="small text-secondary mb-4">
                        Destinasi belanja online terbaik dengan beragam produk pilihan berkualitas, transaksi aman, dan pengiriman super cepat.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-icon" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Tautan Cepat -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-heading">Navigasi</h6>
                    <ul class="list-unstyled footer-links small mb-0">
                        <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="mb-2"><a href="#">Kategori Produk</a></li>
                        <li class="mb-2"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                        <li class="mb-2"><a href="#">Promo & Diskon</a></li>
                    </ul>
                </div>

                <!-- Bantuan & Layanan -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-heading">Bantuan</h6>
                    <ul class="list-unstyled footer-links small mb-0">
                        <li class="mb-2"><a href="#">Pusat Bantuan</a></li>
                        <li class="mb-2"><a href="#">Cara Pembayaran</a></li>
                        <li class="mb-2"><a href="#">Lacak Pengiriman</a></li>
                        <li class="mb-2"><a href="#">Syarat & Ketentuan</a></li>
                        <li class="mb-2"><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Newsletter / Langganan -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-heading">Langganan Info Promo</h6>
                    <p class="small text-secondary mb-3">Dapatkan promo eksklusif dan penawaran menarik langsung ke email Anda.</p>
                    <form action="#" method="POST" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm newsletter-input px-3" placeholder="Masukkan email Anda..." required>
                            <button class="btn btn-primary btn-sm px-3 fw-bold" type="submit">
                                <i class="bi bi-send-fill me-1"></i> Daftar
                            </button>
                        </div>
                    </form>
                    <small class="text-secondary d-block" style="font-size: 0.75rem;">
                        <i class="bi bi-envelope-check me-1"></i> Bebas spam, Anda bisa berhenti berlangganan kapan saja.
                    </small>
                </div>
            </div>

            <!-- Bottom Line: Payment Methods & Copyright -->
            <div class="border-top border-secondary border-opacity-25 pt-4">
                <div class="row align-items-center g-3">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="small text-secondary mb-0">
                            &copy; {{ date('Y') }} <strong class="text-white">{{ config('app.name', 'E-Store') }}</strong>. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="d-inline-flex align-items-center gap-2">
                            <span class="small text-secondary me-2">Metode Pembayaran:</span>
                            <span class="payment-badge"><i class="bi bi-bank me-1"></i> Transfer</span>
                            <span class="payment-badge"><i class="bi bi-qr-code-scan me-1"></i> QRIS</span>
                            <span class="payment-badge"><i class="bi bi-credit-card-2-front me-1"></i> CC</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>