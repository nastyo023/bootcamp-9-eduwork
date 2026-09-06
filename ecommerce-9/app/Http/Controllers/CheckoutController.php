<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        // Load relasi product agar harga dan nama produk terbaca
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        return view('checkout.index', compact('cartItems'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'payment_method' => 'required|string|in:bank_transfer,cod',
        ]);

        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        // 1. Jika keranjang kosong, redirect ke halaman keranjang (bukan back)
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Jalankan dalam Database Transaction agar pembuatan order & pembersihan keranjang atomic
        return DB::transaction(function () use ($request, $cartItems) {
            
            // Tentukan status awal: COD langsung 'processing', Bank Transfer 'pending'
            $status = ($request->payment_method === 'cod') ? 'processing' : 'pending';

            $order = new Order();
            $order->order_number     = 'ORD-' . strtoupper(bin2hex(random_bytes(5)));
            $order->user_id          = Auth::id();
            $order->customer_name    = $request->name;
            $order->customer_phone   = $request->phone;
            $order->customer_address = $request->address;
            
            // 2. Gunakan operator ?? 0 untuk antisipasi jika ada produk yang dihapus/null
            $order->total_amount     = $cartItems->sum(function ($item) {
                return ($item->product->price ?? 0) * $item->quantity;
            });
            
            $order->payment_method   = $request->payment_method;
            $order->status           = $status;
            $order->save();

            // Simpan setiap item ke rincian pesanan (OrderItem)
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->product->price ?? 0,
                ]);
            }

            // Hapus keranjang belanja setelah checkout berhasil
            CartItem::where('user_id', Auth::id())->delete();

            return redirect()->route('orders.show', $order->order_number)
                             ->with('success', 'Pesanan berhasil dibuat!');
        });
    }
}