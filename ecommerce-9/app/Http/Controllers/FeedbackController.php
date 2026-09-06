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
            'comment'  => 'required|string|max:1000',
        ]);

        $order = Order::where('id', $request->order_id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        // Validasi: Hanya pesanan bernilai 'completed' yang bisa diberi ulasan
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Hanya pesanan yang sudah selesai yang dapat diberi ulasan.');
        }

        // Cek apakah pesanan ini sudah pernah diberi ulasan sebelumnya
        $existingFeedback = Feedback::where('order_id', $order->id)->first();
        if ($existingFeedback) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        // Simpan feedback
        Feedback::create([
            'user_id'  => Auth::id(),
            'order_id' => $order->id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}