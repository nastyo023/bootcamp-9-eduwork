<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Produk
        $totalProducts = Product::count();

        // 2. Total Pesanan
        $totalOrders = Order::count();

        // 3. Total Pelanggan (Customer / Role Null)
        $totalUsers = User::where(function ($query) {
            $query->where('role', 'customer')
                  ->orWhereNull('role');
        })->count();

        // 4. Total Pendapatan (Sudah disesuaikan ke total_amount)
        $totalRevenue = Order::where('status', 'completed')
            ->sum('total_amount') ?? 0;

        // 5. Pesanan Terbaru (5 Transaksi Terakhir)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // 6. Data Grafik Penjualan Bulanan (Sudah disesuaikan ke total_amount)
        $monthlySales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->where('status', 'completed')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

        // Format data array 12 bulan (Januari - Desember)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlySales[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'chartData'
        ));
    }
}