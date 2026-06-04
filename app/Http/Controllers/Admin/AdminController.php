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
        // FIXED: dùng 'total_amount' thay vì 'total' (theo đúng migration)
        // FIXED: dùng status 'delivered' thay vì 'completed' (theo đúng migration)
        $totalRevenue   = Order::where('status', 'delivered')->sum('total_amount');
        $totalOrders    = Order::count();
        $totalCustomers = User::where('role', 'user')->count();
        $totalCars      = Car::count();

        // Top 5 xe bán chạy
        // FIXED: join với bảng brands thay vì dùng cột 'brand' trực tiếp
        $topCars = DB::table('order_items')
            ->join('cars', 'order_items.car_id', '=', 'cars.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('brands', 'cars.brand_id', '=', 'brands.id')
            ->where('orders.status', 'delivered')
            ->select(
                'cars.id',
                'cars.name',
                'brands.name as brand',          // FIXED: lấy từ bảng brands
                'cars.featured_image as image',   // FIXED: tên cột đúng là featured_image
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('cars.id', 'cars.name', 'brands.name', 'cars.featured_image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Doanh thu 6 tháng gần nhất
        $revenueLast6Months = Order::where('status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total_amount) as revenue')  // FIXED: tên cột đúng
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Thống kê đơn hàng theo trạng thái
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return response()->json([
            'success' => true,
            'data' => [
                'overview' => [
                    'total_revenue'   => $totalRevenue,
                    'total_orders'    => $totalOrders,
                    'total_customers' => $totalCustomers,
                    'total_cars'      => $totalCars,
                ],
                'top_cars'              => $topCars,
                'revenue_last_6_months' => $revenueLast6Months,
                'orders_by_status'      => $ordersByStatus,
            ]
        ]);
    }

    // FIXED: Thêm method reports() bị thiếu (route /admin/reports gọi method này)
    public function reports()
    {
        $year = request()->get('year', now()->year);

        $revenueByMonth = Order::where('status', 'delivered')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Điền đủ 12 tháng (tháng không có đơn thì revenue = 0)
        $fullYear = collect(range(1, 12))->map(function ($m) use ($revenueByMonth, $year) {
            $found = $revenueByMonth->firstWhere('month', $m);
            return [
                'month'   => $m,
                'label'   => "Tháng {$m}/{$year}",
                'revenue' => $found ? $found->revenue : 0,
                'orders'  => $found ? $found->orders  : 0,
            ];
        });

        $topCars = DB::table('order_items')
            ->join('cars', 'order_items.car_id', '=', 'cars.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('brands', 'cars.brand_id', '=', 'brands.id')
            ->where('orders.status', 'delivered')
            ->whereYear('orders.created_at', $year)
            ->select(
                'cars.name',
                'brands.name as brand',
                'cars.price',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('cars.name', 'brands.name', 'cars.price')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'year'             => $year,
                'revenue_by_month' => $fullYear,
                'top_cars'         => $topCars,
                'total_revenue'    => Order::where('status', 'delivered')->whereYear('created_at', $year)->sum('total_amount'),
                'total_orders'     => Order::where('status', 'delivered')->whereYear('created_at', $year)->count(),
            ]
        ]);
    }
}
