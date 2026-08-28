<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartItemController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::resource('carts', CartItemController::class)->except(['show', 'create', 'edit']);

Route::prefix('dashboard')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', OrderController::class)->except(['show', 'index']); // index, create, store, show, edit, update, destroy
    Route::resource('products', ProductController::class);
    Route::resource('product-categories', ProductCategoryController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



// Daftar Halaman
// - Home/Beranda
// - Deskripsi Product
// - Order List

// Admin:
// - Dashboard
// - CRUD Product
// - CRUD Product Category
// - Transaction Management

// Login & Registrasi