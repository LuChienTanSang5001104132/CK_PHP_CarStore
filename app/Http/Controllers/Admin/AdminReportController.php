<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class AdminReportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('admin.reports.pdf', $data)
                  ->setPaper('a4', 'landscape')
                  ->setOptions(['defaultFont' => 'DejaVuSans']);

        $filename = 'bao-cao-carstore-' . Carbon::now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getReportData($request);
        $filename = 'bao-cao-carstore-' . Carbon::now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new ReportExport($data), $filename);
    }

    private function getReportData(Request $request): array
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        $orderQuery = Order::where('status', 'completed');

        if ($month) {
            $orderQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } else {
            $orderQuery->whereYear('created_at', $year);
        }

        $revenueByMonth = Order::where('status', 'completed')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topCars = DB::table('order_items')
            ->join('cars', 'order_items.car_id', '=', 'cars.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereYear('orders.created_at', $year)
            ->when($month, fn($q) => $q->whereMonth('orders.created_at', $month))
            ->select(
                'cars.name', 'cars.brand', 'cars.price',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('cars.name', 'cars.brand', 'cars.price')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return [
            'generated_at'    => Carbon::now()->format('d/m/Y H:i'),
            'year'            => $year,
            'month'           => $month,
            'total_revenue'   => $orderQuery->sum('total'),
            'total_orders'    => $orderQuery->count(),
            'total_customers' => User::where('role', 'user')->count(),
            'revenue_by_month'=> $revenueByMonth,
            'top_cars'        => $topCars,
        ];
    }
}