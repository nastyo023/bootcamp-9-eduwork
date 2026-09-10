<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhere('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($qUser) use ($request) {
                      $qUser->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.transactions.index', compact('orders'));
    }

    public function show($id)
    {
        // Cari spesifik berdasarkan ID agar tidak terpengaruh getRouteKeyName
        $order = Order::with(['user', 'orderItems.product'])
            ->where('id', $id)
            ->firstOrFail();

        return view('admin.transactions.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        // Cari spesifik berdasarkan ID
        $order = Order::where('id', $id)->firstOrFail();

        // Validasi mendukung semua variasi status yang ada di migration
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled,canceled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui!');
    }
}