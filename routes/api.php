<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController, CartController, CarApiController, ReviewController, OrderController};
use App\Http\Controllers\Admin\{AdminCarController, AdminUserController, AdminOrderController, AdminCommentController, AdminReportController};

/*
|--------------------------------------------------------------------------
| API ROUTES - KHÁCH HÀNG (CLIENT)
|--------------------------------------------------------------------------
*/

// 1. Auth & Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Public Cars & Reviews
Route::get('/cars', [CarApiController::class, 'index']);
Route::get('/cars/{id}', [CarApiController::class, 'show']);
Route::get('/cars/{carId}/reviews', [ReviewController::class, 'index']);

// 2. Protected (Yêu cầu Token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);

    // Cart
    Route::apiResource('cart', CartController::class);

    // Orders
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment']);

    // Reviews
    Route::post('/cars/{carId}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| API ROUTES - QUẢN TRỊ (ADMIN)
|--------------------------------------------------------------------------
*/
// Lưu ý: Đảm bảo user có role 'admin' để truy cập nhóm này
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    
    // Báo cáo & Thống kê
    Route::get('/reports', [AdminReportController::class, 'index']);
    Route::get('/reports/export-pdf', [AdminReportController::class, 'exportPdf']);
    Route::get('/reports/export-excel', [AdminReportController::class, 'exportExcel']);

    // CRUD Tài nguyên (Dùng apiResource cho gọn)
    Route::apiResource('users', AdminUserController::class);
    Route::apiResource('cars', AdminCarController::class);

    // Đơn hàng (Admin)
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    Route::put('/orders/{id}/payment', [AdminOrderController::class, 'updatePaymentStatus']);
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy']);

    // Bình luận
    Route::get('/comments', [AdminCommentController::class, 'index']);
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy']);
});