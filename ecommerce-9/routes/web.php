<?php

use Illuminate\Support\Facades\Route;

// home
Route::get('/', function () {
    echo "selamat datang di halaman home";
});


// about
Route::get('/about', function () {
    echo "selamat datang di halaman about";
});

// product
Route::get('/products', function () {
    echo "selamat datang di halaman product";
});

// cart
Route::get('/cart', function () {
    echo "selamat datang di halaman cart";
});

// checkout
Route::get('checkout', function () {
    echo "selamat datang di halaman checkout";
});


// contact
Route::get('/contact', function () {
    echo "selamat datang di halaman contact";
});
