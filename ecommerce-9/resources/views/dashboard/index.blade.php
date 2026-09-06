<x-app-layout title="Dashboard">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Dashboard Overview') }}
            </h2>
            <span class="text-xs font-semibold px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full border border-indigo-100">
                E-Commerce Admin
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- STATISTIK CARDS (GRID RESPONSIVE 5 KOLOM) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($data as $item)
                    <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                    {{ $item['title'] }}
                                </span>
                                <div class="p-2 rounded-xl bg-slate-50 text-indigo-600 flex items-center justify-center">
                                    {!! $item['icon'] !!}
                                </div>
                            </div>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                                {{ $item['value'] ?? 0 }}
                            </h3>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-[11px] font-medium text-emerald-500 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- GRAFIK CHART.JS -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Orders (Last 7 Days)</h3>
                            <p class="text-xs text-slate-400">Statistik tren jumlah dan pendapatan pesanan.</p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">Chart.js</span>
                    </div>
                    <div class="relative w-full h-[320px]">
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- TABEL LATEST ORDERS -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Latest Orders</h3>
                            <p class="text-xs text-slate-400">Daftar transaksi terbaru yang masuk.</p>
                        </div>
                        <!-- FIX: Menggunakan admin.orders.index jika ada -->
                        <a href="{{ Route::has('admin.orders.index') ? route('admin.orders.index') : '#' }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">
                            View All Orders
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="min-w-full divide-y divide-slate-100 text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Order ID</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Phone</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Total Amount</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($orderDataForTable as $row)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                            <!-- FIX: Menggunakan admin.orders.show jika ada -->
                                            <a href="{{ Route::has('admin.orders.show') ? route('admin.orders.show', $row->order_number ?? $row->id) : '#' }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">
                                                #{{ $row->order_number ?? $row->id }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-700">{{ $row->customer_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $row->customer_phone }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-800">Rp {{ number_format($row->total_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100 uppercase">
                                                {{ $row->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-400">{{ $row->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">
                                            Belum ada data transaksi terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('orderChart').getContext('2d');
        const orderChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($orderDataForChartJs['order_count']['labels']),
                datasets: [
                    {
                        label: 'Order Count',
                        data: @json($orderDataForChartJs['order_count']['data']),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.05)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Order Revenue',
                        data: @json($orderDataForChartJs['order_revenue']['data']),
                        borderColor: '#10b981',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Order Count'
                        },
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Revenue (Rp)'
                        },
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>