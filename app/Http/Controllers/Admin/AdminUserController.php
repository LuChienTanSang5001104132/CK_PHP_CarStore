<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->select('id', 'name', 'email', 'role', 'avatar', 'phone', 'address', 'created_at')
                       ->withCount('orders')
                       ->latest()
                       ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data'    => $users
        ]);
    }

    public function show($id)
    {
        $user = User::with([
            'orders' => fn($q) => $q->latest()->limit(10),
            'orders.items.car',
        ])->findOrFail($id);

        // Thống kê tổng chi tiêu
        $user->total_spent = $user->orders()
            ->where('status', 'delivered')
            ->sum('total_amount');

        return response()->json([
            'success' => true,
            'data'    => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'    => 'sometimes|string|max:255',
            'email'   => ['sometimes', 'email', Rule::unique('users')->ignore($id)],
            'role'    => 'sometimes|in:user,admin',
            'phone'   => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:500',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'phone', 'address']));

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật người dùng thành công',
            'data'    => $user->fresh()
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa tài khoản đang đăng nhập'
            ], 403);
        }

        if ($user->role === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa tài khoản admin'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa người dùng thành công'
        ]);
    }
}
