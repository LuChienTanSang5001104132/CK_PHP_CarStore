<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Sử dụng $request->user() để lấy user từ Token Sanctum
        $user = $request->user();

        // Nếu không có user (chưa cấp token) hoặc không phải admin -> Chặn
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn không có quyền truy cập trang quản trị.'
            ], 403);
        }

        return $next($request);
    }
}