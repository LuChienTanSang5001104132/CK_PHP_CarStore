<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminReportController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - GIAO DIỆN KHÁCH HÀNG & QUẢN TRỊ
|--------------------------------------------------------------------------
*/

// ── Trang chủ & Auth
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.forgot');

// ── Giao diện Khách hàng (Client-side)
Route::get('/cart', function () { return view('cart'); })->name('cart');
Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
Route::get('/profile', function () { return view('profile'); })->name('profile');

// ── Khu vực Quản trị Admin
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', function () { 
        return view('admin.dashboard', [
            'carCount'   => \App\Models\Car::count(),
            'userCount'  => \App\Models\User::count(),
            'orderCount' => \App\Models\Order::count()
        ]); 
    })->name('dashboard');
    
    // 2. Quản lý Xe
    Route::get('/cars', function (\Illuminate\Http\Request $request) { 
        $query = \App\Models\Car::with('brand')->withCount('orderItems');
        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        return view('admin.cars.index', ['cars' => $query->latest()->paginate(10), 'brands' => \App\Models\Brand::all()]); 
    })->name('cars.index');
    Route::post('/cars/store', [AdminCarController::class, 'store'])->name('cars.store');
    Route::delete('/cars/{id}/destroy', [AdminCarController::class, 'destroy'])->name('cars.destroy');

    // 3. Quản lý Người dùng
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}/update', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}/destroy', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');

    // 4. Quản lý Đơn hàng
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}/destroy', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // 5. Quản lý Bình luận
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{id}/destroy', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    // 6. Báo cáo & Thống kê
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    Route::get('/reports/export-pdf', [AdminReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/export-excel', [AdminReportController::class, 'exportExcel'])->name('reports.excel');
});