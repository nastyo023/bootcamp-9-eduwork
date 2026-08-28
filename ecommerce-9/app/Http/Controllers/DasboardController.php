<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = $this->getData();
        $orderDataForChartJs = $this->getOrderDataForChartJs();
        $orderDataForTable = $this->orderDataForTableDisplay();
        
        return view('dashboards.index', 
            compact(
                'data',
                'orderDataForChartJs',
                'orderDataForTable'
            )
        );
    }

    private function getData()
    {
        return [
            [
                'title' => 'Products',
                'value' => 100,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#6a7282" viewBox="0 -960 960 960"><path d="M200-80q-33 0-56.5-23.5T120-160v-451q-18-11-29-28.5T80-680v-120q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v120q0 23-11 40.5T840-611v451q0 33-23.5 56.5T760-80zm0-520v440h560v-440zm-40-80h640v-120H160zm200 280h240v-80H360zm120 20"/></svg>'
            ],
            [
                'title' => 'Product Clicks',
                'value' => 100,
                'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#6a7282"><path d="M80-480v-80h120v80H80Zm136 222-56-58 84-84 58 56-86 86Zm28-382-84-84 56-58 86 86-58 56Zm476 480L530-350l-50 150-120-400 400 120-148 52 188 188-80 80ZM400-720v-120h80v120h-80Zm236 80-58-56 86-86 56 56-84 86Z"/></svg>'
            ],
            [
                'title' => 'Categories',
                'value' => 100,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#6a7282" viewBox="0 -960 960 960"><path d="m260-520 220-360 220 360zM700-80q-75 0-127.5-52.5T520-260t52.5-127.5T700-440t127.5 52.5T880-260t-52.5 127.5T700-80m-580-20v-320h320v320zm580-60q42 0 71-29t29-71-29-71-71-29-71 29-29 71 29 71 71 29m-500-20h160v-160H200zm202-420h156l-78-126zm298 340"/></svg>'
            ],
            [
                'title' => 'Orders',
                'value' => 100,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#6a7282"><path d="M440-600v-120H320v-80h120v-120h80v120h120v80H520v120h-80ZM223.5-103.5Q200-127 200-160t23.5-56.5Q247-240 280-240t56.5 23.5Q360-193 360-160t-23.5 56.5Q313-80 280-80t-56.5-23.5Zm400 0Q600-127 600-160t23.5-56.5Q647-240 680-240t56.5 23.5Q760-193 760-160t-23.5 56.5Q713-80 680-80t-56.5-23.5ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/></svg>'
            ],
            [
                'title' => 'Users',
                'value' => 100,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#6a7282" viewBox="0 -960 960 960"><path d="M234-276q51-39 114-61.5T480-360t132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800t-226.5 93.5T160-480q0 59 19.5 111t54.5 93m146.5-204.5Q340-521 340-580t40.5-99.5T480-720t99.5 40.5T620-580t-40.5 99.5T480-440t-99.5-40.5M480-80q-83 0-156-31.5T197-197t-85.5-127T80-480t31.5-156T197-763t127-85.5T480-880t156 31.5T763-763t85.5 127T880-480t-31.5 156T763-197t-127 85.5T480-80m100-95.5q47-15.5 86-44.5-39-29-86-44.5T480-280t-100 15.5-86 44.5q39 29 86 44.5T480-160t100-15.5M523-537q17-17 17-43t-17-43-43-17-43 17-17 43 17 43 43 17 43-17m-43 317"/></svg>'
            ],
        ];

    }

    private function getOrderDataForChartJs()
    {
        // 7 days data range for orders data using Carbon
        $startDate = Carbon::now()->subDays(6);
        $endDate = Carbon::now();
        $labels = [];
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $labels[] = $date->format('Y-m-d');
        }

        return [
            'order_count'=>[
                'labels' => $labels,
                'data' => [10, 5, 50, 15, 25, 100, 50],
            ],
            'order_revenue'=>[
                'labels' => $labels,
                'data' => [100000, 50000, 500000, 250000, 1000000, 400000, 900000],
            ],
        ];
    }

    private function orderDataForTableDisplay()
    {
        return [
            [
                'order_id' => 1,
                'customer_name' => 'John Doe',
                'total_amount' => 100000,
                'status' => 'Completed',
                'created_at' => Carbon::now()->locale('id')->subDays(1)->translatedFormat('l, d F Y'),
            ],
            [
                'order_id' => 2,
                'customer_name' => 'Jane Doe',
                'total_amount' => 50000,
                'status' => 'Pending',
                'created_at' => Carbon::now()->locale('id')->subDays(2)->translatedFormat('l, d F Y'),
            ],
            [
                'order_id' => 3,
                'customer_name' => 'John Smith',
                'total_amount' => 250000,
                'status' => 'Completed',
                'created_at' => Carbon::now()->locale('id')->subDays(3)->translatedFormat('l, d F Y'),
            ],
        ];
    }
}