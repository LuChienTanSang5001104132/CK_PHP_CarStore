<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        // FIXED: dùng 'customer_full_name' và 'customer_phone' đúng với migration
        $query = Order::with([
            'user:id,name,email,phone',
            'items.car:id,name,brand_id,featured_image',
            'items.car.brand:id,name',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) =>
                    $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                )
                ->orWhere('customer_full_name', 'like', "%{$search}%")
                ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data'    => $orders
        ]);
    }

    public function show($id)
    {
        $order = Order::with([
            'user',
            'items.car.brand',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $order
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            // FIXED: status values phải khớp với migration
            // Migration dùng: pending, confirmed, shipping, delivered, cancelled
            'status' => 'required|in:pending,confirmed,shipping,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Cập nhật payment_status tự động khi delivered
        if ($request->status === 'delivered' && $order->payment_method !== 'cod') {
            $order->update(['payment_status' => 'paid']);
        }

        return response()->json([
            'success' => true,
            'message' => "Đơn hàng #{$id} đã chuyển từ '{$oldStatus}' → '{$request->status}'",
            'data'    => $order->fresh()
        ]);
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thanh toán thành công',
            'data'    => $order->fresh()
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Chỉ cho phép xóa đơn đã hủy hoặc đang pending
        if (!in_array($order->status, ['cancelled', 'pending'])) {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể xóa đơn hàng đang chờ xử lý hoặc đã hủy'
            ], 422);
        }

        $order->items()->delete();
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa đơn hàng thành công'
        ]);
    }
}
