<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string',
        ]);

        $order = Order::with('orderItems')->findOrFail($request->order_id);

        if (strtolower($order->status) !== 'completed') {
            return redirect()->back()->with('error', 'Hanya pesanan yang sudah selesai yang dapat diberi ulasan.');
        }

        // Cek ulasan ganda
        $existingFeedback = Feedback::where('order_id', $order->id)->first();
        if ($existingFeedback) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        // Ambil order_item_id pertama jika ada
        $firstOrderItem = $order->orderItems->first();

        // Simpan feedback
        Feedback::create([
            'user_id'       => Auth::id(),
            'order_id'      => $order->id,
            'order_item_id' => $firstOrderItem ? $firstOrderItem->id : null,
            'rating'        => $request->rating,
            'comment'       => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}