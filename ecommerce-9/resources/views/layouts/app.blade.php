<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'E-Commerce') }}</title>

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
        :root {
            --ios-bg: #f5f5f7;
            --ios-card-bg: rgba(255, 255, 255, 0.85);
            --ios-border: rgba(225, 225, 230, 0.6);
            --ios-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "SF Pro Display", sans-serif;
            background-color: var(--ios-bg);
            color: #1c1c1e;
        }

        /* iOS Modern Light Footer */
        .footer-ios {
            background: var(--ios-card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid var(--ios-border);
            color: #3a3a3c;
        }

        .footer-heading {
            color: #1c1c1e;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -0.3px;
        }

        .footer-links a {
            color: #636366;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #007aff;
            transform: translateX(3px);
        }

        .social-icon-ios {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(235, 235, 240, 0.8);
            color: #1c1c1e;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .social-icon-ios:hover {
            background: #007aff;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
        }

        .ios-newsletter-input {
            background: rgba(245, 245, 250, 0.8);
            border: 1px solid var(--ios-border);
            border-radius: 12px 0 0 12px;
            color: #1c1c1e;
            font-size: 0.85rem;
        }

        .ios-newsletter-input:focus {
            background: #ffffff;
            border-color: #007aff;
            box-shadow: none;
        }

        .btn-ios-send {
            background: #007aff;
            color: #ffffff;
            border-radius: 0 12px 12px 0;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-ios-send:hover {
            background: #0056b3;
            color: #ffffff;
        }

        .payment-badge-ios {
            background: rgba(235, 235, 240, 0.8);
            border: 1px solid var(--ios-border);
            padding: 5px 12px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            font-size: 0.75rem;
            color: #3a3a3c;
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

    <!-- FOOTER MODERN IOS STYLE -->
    <footer class="footer-ios mt-auto pt-5 pb-3">
        <div class="container">
            <!-- Feature Badges Section -->
            <div class="row g-3 border-bottom border-light-subtle pb-4 mb-5 text-center text-md-start">
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-truck fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-dark fw-bold small">Pengiriman Cepat</h6>
                            <small class="text-secondary" style="font-size: 11px;">Ke seluruh Indonesia</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-shield-check fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-dark fw-bold small">Pembayaran Aman</h6>
                            <small class="text-secondary" style="font-size: 11px;">Terproteksi 100%</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-15 p-2 text-warning d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-dark fw-bold small">Produk Original</h6>
                            <small class="text-secondary" style="font-size: 11px;">Jaminan kualitas 100%</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                        <div class="rounded-circle bg-info bg-opacity-10 p-2 text-info d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-headset fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-dark fw-bold small">Layanan 24/7</h6>
                            <small class="text-secondary" style="font-size: 11px;">Dukungan CS siap bantu</small>
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
                        <span class="fs-4 fw-bold text-dark tracking-tight">{{ config('app.name', 'E-Store') }}</span>
                    </div>
                    <p class="small text-secondary mb-4" style="line-height: 1.6;">
                        Destinasi belanja online terbaik dengan beragam produk pilihan berkualitas, transaksi aman, dan pengiriman super cepat.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-icon-ios" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon-ios" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon-ios" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon-ios" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Navigasi -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-heading">Navigasi</h6>
                    <ul class="list-unstyled footer-links small mb-0">
                        <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="mb-2"><a href="#katalog">Kategori Produk</a></li>
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
                            <input type="email" class="form-control ios-newsletter-input px-3" placeholder="Masukkan email Anda..." required>
                            <button class="btn btn-ios-send px-3" type="submit">
                                <i class="bi bi-send-fill me-1"></i> Daftar
                            </button>
                        </div>
                    </form>
                    <small class="text-secondary d-block" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-check me-1 text-success"></i> Bebas spam, Anda bisa berhenti berlangganan kapan saja.
                    </small>
                </div>
            </div>

            <!-- Bottom Line: Payment Methods & Copyright -->
            <div class="border-top border-light-subtle pt-4">
                <div class="row align-items-center g-3">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="small text-secondary mb-0">
                            &copy; {{ date('Y') }} <strong class="text-dark">{{ config('app.name', 'E-Store') }}</strong>. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="d-inline-flex align-items-center gap-2">
                            <span class="small text-secondary me-2">Metode Pembayaran:</span>
                            <span class="payment-badge-ios"><i class="bi bi-bank me-1 text-primary"></i> Transfer</span>
                            <span class="payment-badge-ios"><i class="bi bi-qr-code-scan me-1 text-danger"></i> QRIS</span>
                            <span class="payment-badge-ios"><i class="bi bi-credit-card-2-front me-1 text-success"></i> CC</span>
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