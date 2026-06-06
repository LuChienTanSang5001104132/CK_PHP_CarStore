<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarApiController;


Route::get('/cars', [CarApiController::class, 'index']);

Route::post('/cars', [CarApiController::class, 'store']);

Route::get('/cars/{id}', [CarApiController::class, 'show']);

Route::put('/cars/{id}', [CarApiController::class, 'update']);

Route::delete('/cars/{id}', [CarApiController::class, 'destroy']);


Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // ── Dashboard & Báo cáo ───────────────────────────────────────────────
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard']);

    // FIXED: reports() method đã được thêm vào AdminController
    Route::get('/reports', [\App\Http\Controllers\Admin\AdminController::class, 'reports']);

    // Xuất file
    Route::get('/reports/export/pdf',   [\App\Http\Controllers\Admin\AdminReportController::class, 'exportPdf']);
    Route::get('/reports/export/excel', [\App\Http\Controllers\Admin\AdminReportController::class, 'exportExcel']);

    // ── Quản lý Người dùng ───────────────────────────────────────────────
    Route::apiResource('users', \App\Http\Controllers\Admin\AdminUserController::class);

    // ── Quản lý Xe ───────────────────────────────────────────────────────
    Route::apiResource('cars', \App\Http\Controllers\Admin\AdminCarController::class);

    // ── Quản lý Đơn hàng ─────────────────────────────────────────────────
    Route::get   ('/orders',                  [\App\Http\Controllers\Admin\AdminOrderController::class, 'index']);
    Route::get   ('/orders/{id}',             [\App\Http\Controllers\Admin\AdminOrderController::class, 'show']);
    Route::put   ('/orders/{id}/status',      [\App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus']);
    // FIXED: Thêm route cập nhật trạng thái thanh toán (method mới bổ sung)
    Route::put   ('/orders/{id}/payment',     [\App\Http\Controllers\Admin\AdminOrderController::class, 'updatePaymentStatus']);
    Route::delete('/orders/{id}',             [\App\Http\Controllers\Admin\AdminOrderController::class, 'destroy']);

    // ── Quản lý Bình luận / Đánh giá ─────────────────────────────────────
    Route::get   ('/comments',     [\App\Http\Controllers\Admin\AdminCommentController::class, 'index']);
    Route::delete('/comments/{id}',[\App\Http\Controllers\Admin\AdminCommentController::class, 'destroy']);
});

