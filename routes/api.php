<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CarApiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminReportController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION API ROUTES - Tài
|--------------------------------------------------------------------------
*/
// Các API không cần đăng nhập
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']); // Gửi mã
Route::post('/reset-password', [AuthController::class, 'resetPassword']);   // Đặt lại MK

// Xem danh sách xe và chi tiết
Route::get('/cars',      [CarApiController::class, 'index']);
Route::get('/cars/{id}', [CarApiController::class, 'show']);

// Xem review của 1 xe (public)
Route::get('/cars/{carId}/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'index']);


// Nhóm các API yêu cầu đăng nhập (phải có Token)
Route::middleware('auth:sanctum')->group(function () {
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Quản lý hồ sơ
    Route::get('/profile', [AuthController::class, 'profile']); // Xem hồ sơ
    Route::post('/profile/update', [AuthController::class, 'updateProfile']); // Cập nhật & đổi ảnh
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    
    // API Giỏ hàng (Cart)
    Route::get('/cart', [\App\Http\Controllers\Api\CartController::class, 'index']);
    Route::post('/cart', [\App\Http\Controllers\Api\CartController::class, 'store']);
    Route::put('/cart/{id}', [\App\Http\Controllers\Api\CartController::class, 'update']);
    Route::delete('/cart/{id}', [\App\Http\Controllers\Api\CartController::class, 'destroy']);

    // Đơn hàng
    Route::post('/orders',               [\App\Http\Controllers\Api\OrderController::class, 'store']);   // Tạo đơn / thanh toán
    Route::get ('/orders',               [\App\Http\Controllers\Api\OrderController::class, 'index']);   // Lịch sử mua hàng
    Route::get ('/orders/{id}',          [\App\Http\Controllers\Api\OrderController::class, 'show']);    // Chi tiết đơn
    Route::put ('/orders/{id}/cancel',   [\App\Http\Controllers\Api\OrderController::class, 'cancel']);  // Hủy đơn
 
    // Đánh giá xe
    Route::post  ('/cars/{carId}/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'store']);   // Thêm review
    Route::put   ('/reviews/{id}',         [\App\Http\Controllers\Api\ReviewController::class, 'update']);  // Sửa review
    Route::delete('/reviews/{id}',         [\App\Http\Controllers\Api\ReviewController::class, 'destroy']); // Xóa review

    // Thanh toán giả lập
    Route::post('/orders/{id}/confirm-payment', [\App\Http\Controllers\Api\OrderController::class, 'confirmPayment']);
});

/*
|--------------------------------------------------------------------------
| ADMIN API ROUTES - Người 5 (Sang)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // ── Dashboard & Báo cáo
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard']);

    // FIXED: reports() method đã được thêm vào AdminController
    Route::get('/reports', [\App\Http\Controllers\Admin\AdminController::class, 'reports']);

    // Xuất file
    Route::get('/reports/export/pdf',   [\App\Http\Controllers\Admin\AdminReportController::class, 'exportPdf']);
    Route::get('/reports/export/excel', [\App\Http\Controllers\Admin\AdminReportController::class, 'exportExcel']);

    // ── Quản lý Người dùng
    Route::apiResource('users', \App\Http\Controllers\Admin\AdminUserController::class);

    // ── Quản lý Xe
    Route::apiResource('cars', \App\Http\Controllers\Admin\AdminCarController::class);

    // ── Quản lý Đơn hàng
    Route::get   ('/orders',                  [\App\Http\Controllers\Admin\AdminOrderController::class, 'index']);
    Route::get   ('/orders/{id}',             [\App\Http\Controllers\Admin\AdminOrderController::class, 'show']);
    Route::put   ('/orders/{id}/status',      [\App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus']);
    // FIXED: Thêm route cập nhật trạng thái thanh toán (method mới bổ sung)
    Route::put   ('/orders/{id}/payment',     [\App\Http\Controllers\Admin\AdminOrderController::class, 'updatePaymentStatus']);
    Route::delete('/orders/{id}',             [\App\Http\Controllers\Admin\AdminOrderController::class, 'destroy']);

    // ── Quản lý Bình luận / Đánh giá
    Route::get   ('/comments',     [\App\Http\Controllers\Admin\AdminCommentController::class, 'index']);
    Route::delete('/comments/{id}',[\App\Http\Controllers\Admin\AdminCommentController::class, 'destroy']);
});
