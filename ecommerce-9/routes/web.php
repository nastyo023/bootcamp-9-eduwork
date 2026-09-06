<?php

use Illuminate\Support\Facades\Route;

// Controller Customer / Publik
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\ProductCategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminFeedbackController;

/*
|--------------------------------------------------------------------------
| PUBLIC & CUSTOMER ROUTES (Sisi Pembeli)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    // Keranjang & Checkout
    Route::resource('carts', CartItemController::class)->except(['show', 'create', 'edit']);
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Pesanan / Orders Customer
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/upload-payment', [OrderController::class, 'uploadPaymentProof'])->name('orders.uploadPayment');

    // Feedback & Review
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Sisi Pengelola / Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->as('admin.')->group(function () {
    // 1. Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // 2. CRUD Product
    Route::resource('products', AdminProductController::class);

    // 3. CRUD Product Category
    Route::resource('categories', AdminCategoryController::class);

    // 4. Transaction Management (Kelola Pesanan dari Sisi Admin)
    Route::resource('transactions', AdminOrderController::class)->only(['index', 'show', 'update']);

    // 5. Kelola Masukan / Reviews Pelanggan
    Route::get('/reviews', [AdminFeedbackController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [AdminFeedbackController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__.'/auth.php';


// ==========================================
// DAFTAR HALAMAN APLIKASI E-COMMERCE
// ==========================================

// User / Publik:
// - Home / Beranda (Katalog Produk & Filter)
// - Deskripsi / Detail Product
// - Keranjang Belanja (Cart)
// - Checkout & Pembayaran
// - Order List (Riwayat Transaksi User)
// - Profil User
// - Masukan / Feedback & Ulasan Produk

// Admin:
// - Dashboard Admin
// - CRUD Product (Tambah, Edit, Hapus Produk)
// - CRUD Product Category (Kelola Kategori)
// - Transaction Management (Kelola Status Pesanan)
// - Kelola Masukan / Ulasan Pelanggan

// Autentikasi:
// - Login & Registrasi
// - Lupa & Reset Kata Sandi