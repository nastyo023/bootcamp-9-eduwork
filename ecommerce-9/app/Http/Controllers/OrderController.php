<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        // Memuat relasi item dan produk secara efisien
        $orders = Order::with(['user', 'items.product', 'orderItems.product'])
                    ->withCount(['items', 'orderItems']);

        // Batasi hanya jika role-nya 'user' (Admin/Customer non-user tetap bisa lihat semua)
        if (Auth::user()->role === 'user') {
            $orders->where('user_id', Auth::id());
        }

        $orders = $orders->orderBy('created_at', 'desc')->paginate(10);

        // Menyesuaikan folder view jika dipanggil dari route customer / admin
        if (request()->is('admin/*')) {
    return view('dashboard.orders.index', compact('orders'));
    }

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $query = Order::with(['user', 'items.product', 'orderItems.product'])
                    ->where(function ($q) use ($id) {
                        $q->where('id', $id)
                          ->orWhere('order_number', $id);
                    });

        // Pengaman: User biasa HANYA bisa lihat pesanannya sendiri
        if (Auth::user()->role === 'user') {
            $query->where('user_id', Auth::id());
        }

        $order = $query->firstOrFail();

        if (request()->is('admin/*')) {
            return view('dashboard.orders.show', compact('order'));
        }

        return view('dashboard.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        // Validasi status transaksi
        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled,selesai,diproses,dibatalkan',
        ]);

        $order = Order::where('id', $id)
                    ->orWhere('order_number', $id)
                    ->firstOrFail();

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // User hanya bisa upload di pesanan miliknya sendiri
        $order = Order::where(function ($q) use ($id) {
                    $q->where('id', $id)
                      ->orWhere('order_number', $id);
                })
                ->where('user_id', Auth::id())
                ->firstOrFail();

        // Validasi tambahan: Metode COD tidak perlu upload bukti TF
        if (strtoupper($order->payment_method) === 'COD') {
            return redirect()->back()->with('error', 'Pesanan metode COD tidak memerlukan unggahan bukti transfer.');
        }

        if ($request->hasFile('payment_proof')) {
            // Hapus bukti transfer lama jika ada (mencegah penumpukan file)
            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $order->payment_proof = $path;
            $order->status = 'processing'; // Otomatis ubah status setelah upload
            $order->save();
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah! Pesanan sedang diverifikasi.');
    }
}