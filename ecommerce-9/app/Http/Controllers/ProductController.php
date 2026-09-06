<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        // 1. Cari produk berdasarkan slug / id
        $product = Product::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();

        // 2. Ambil produk rekomendasi
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('product_category_id', $product->product_category_id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('id', '!=', $product->id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        // 3. Cek apakah user berhak isi ulasan (Sudah Login & Pernah Beli + Status Completed)
        $canReview = false;
        if (auth()->check()) {
            $canReview = Order::where('user_id', auth()->id())
                ->where('status', 'completed') // Sesuaikan dengan string status completed di database kamu
                ->whereHas('orderItems', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->exists();
        }

        return view('products.show', compact('product', 'relatedProducts', 'canReview'));
    }
}