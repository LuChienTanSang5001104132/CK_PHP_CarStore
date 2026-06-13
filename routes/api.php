<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Lớp Controller API User
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CarApiController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\OrderController;

// Lớp Controller API Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminReportController;

/*
|--------------------------------------------------------------------------
| API ROUTES - CHUẨN TOKEN (SANCTUM)
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES (Không cần Token) ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// API Xem danh sách xe, chi tiết xe, đánh giá
Route::get('/cars', [CarApiController::class, 'index']);
Route::get('/cars/{id}', [CarApiController::class, 'show']);
Route::get('/cars/{carId}/reviews', [ReviewController::class, 'index']);

// API Lấy danh sách hãng xe (Dành cho Form Thêm/Sửa xe của Admin)
Route::get('/brands', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Brand::select('id', 'name')->get()
    ]);
});


// ==================== PRIVATE ROUTES (Yêu cầu Token User) ====================
Route::middleware('auth:sanctum')->group(function () {
    
    // Quản lý tài khoản
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    
    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);

    // Đơn hàng
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment']);
 
    // Viết Đánh giá
    Route::post('/cars/{carId}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});


// ==================== ADMIN ROUTES (Yêu cầu Token + Quyền Admin) ====================
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // Dashboard & Báo cáo
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/reports', [AdminController::class, 'reports']);
    Route::get('/reports/export/pdf', [AdminReportController::class, 'exportPdf']);
    Route::get('/reports/export/excel', [AdminReportController::class, 'exportExcel']);

    // Quản lý User và Xe (Tự động map các route chuẩn: index, store, show, update, destroy)
    Route::apiResource('users', AdminUserController::class);
    Route::apiResource('cars', AdminCarController::class);

    // Quản lý Đơn hàng
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    Route::put('/orders/{id}/payment', [AdminOrderController::class, 'updatePaymentStatus']);
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy']);

    // Quản lý Bình luận
    Route::get('/comments', [AdminCommentController::class, 'index']);
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy']);
});