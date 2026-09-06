<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders     = Order::count();
        $pendingOrders   = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalProducts   = Product::count();

        // Data statistik kartu
        $data = [
            [
                'title' => 'Total Orders',
                'value' => $totalOrders,
                'icon'  => '<i class="fa-solid fa-cart-shopping"></i>',
            ],
            [
                'title' => 'Pending Orders',
                'value' => $pendingOrders,
                'icon'  => '<i class="fa-solid fa-clock"></i>',
            ],
            [
                'title' => 'Completed Orders',
                'value' => $completedOrders,
                'icon'  => '<i class="fa-solid fa-circle-check"></i>',
            ],
            [
                'title' => 'Total Products',
                'value' => $totalProducts,
                'icon'  => '<i class="fa-solid fa-box"></i>',
            ],
        ];

        // Tabel transaksi & ulasan terbaru
        $recentOrders      = Order::with('user')->latest()->take(5)->get();
        $orderDataForTable = $recentOrders;
        $latestFeedbacks   = Feedback::with(['user', 'order'])->latest()->take(5)->get();

        // Data Grafik (7 hari terakhir: Jumlah Order & Total Revenue)
        $chartLabels      = [];
        $chartOrderCount  = [];
        $chartRevenueData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');

            // Hitung jumlah order per hari
            $chartOrderCount[] = Order::whereDate('created_at', $date->toDateString())->count();

            // Hitung total revenue per hari (hanya order completed)
            $chartRevenueData[] = Order::whereDate('created_at', $date->toDateString())
                ->where('status', 'completed')
                ->sum('total_amount');
        }

        $orderDataForChartJs = [
            'order_count' => [
                'labels' => $chartLabels,
                'data'   => $chartOrderCount,
            ],
            'order_revenue' => [
                'labels' => $chartLabels,
                'data'   => $chartRevenueData,
            ]
        ];

        return view('dashboard.index', compact(
            'data', 
            'recentOrders', 
            'orderDataForTable', 
            'latestFeedbacks', 
            'orderDataForChartJs'
        ));
    }
}