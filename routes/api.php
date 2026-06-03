<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ... các route khác của bạn

/*
|--------------------------------------------------------------------------
| ADMIN API ROUTES - Người 5 (Sang)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // Dashboard & Báo cáo tổng quan
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard']);
    Route::get('/reports', [App\Http\Controllers\Admin\AdminController::class, 'reports']); // nếu bạn có method reports trong AdminController

    // Xuất báo cáo
    Route::get('/reports/export/pdf', [App\Http\Controllers\Admin\AdminReportController::class, 'exportPdf']);
    Route::get('/reports/export/excel', [App\Http\Controllers\Admin\AdminReportController::class, 'exportExcel']);

    // Quản lý Người dùng
    Route::apiResource('users', App\Http\Controllers\Admin\AdminUserController::class);

    // Quản lý Xe
    Route::apiResource('cars', App\Http\Controllers\Admin\AdminCarController::class);

    // Quản lý Đơn hàng
    Route::get('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'show']);
    Route::put('/orders/{id}/status', [App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus']);
    Route::delete('/orders/{id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'destroy']);

    // Quản lý Bình luận
    Route::get('/comments', [App\Http\Controllers\Admin\AdminCommentController::class, 'index']);
    Route::delete('/comments/{id}', [App\Http\Controllers\Admin\AdminCommentController::class, 'destroy']);
});