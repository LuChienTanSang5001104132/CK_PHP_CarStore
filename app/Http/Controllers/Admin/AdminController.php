<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();
        $totalCars = Car::count();

        // Top 5 xe bán chạy
        $topCars = DB::table('order_items')
            ->join('cars', 'order_items.car_id', '=', 'cars.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select(
                'cars.id', 'cars.name', 'cars.brand', 'cars.image',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('cars.id', 'cars.name', 'cars.brand', 'cars.image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Doanh thu 6 tháng gần nhất
        $revenueLast6Months = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'overview' => [
                    'total_revenue' => $totalRevenue,
                    'total_orders' => $totalOrders,
                    'total_customers' => $totalCustomers,
                    'total_cars' => $totalCars,
                ],
                'top_cars' => $topCars,
                'revenue_last_6_months' => $revenueLast6Months,
            ]
        ]);
    }
}