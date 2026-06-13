<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - CHỈ TRẢ VỀ GIAO DIỆN (FRONTEND)
| Kiến trúc mới: Mọi logic bảo mật, lấy dữ liệu sẽ do JavaScript (fetch API) 
| xử lý ở phía Client (trình duyệt). File này chỉ trả về giao diện rỗng.
|--------------------------------------------------------------------------
*/

// ==================== GIAO DIỆN FRONTEND (CỦA KHÁNH) ====================
Route::get('/home', [HomeController::class, 'home']);
Route::get('/ThongTin', [HomeController::class, 'thongTinCongTy']);
Route::get('/ChiTietXe/{id}', [HomeController::class, 'chiTietXe']);
Route::get('/TimKiem', [HomeController::class, 'timKiem']);


// ==================== GIAO DIỆN CƠ BẢN & AUTH ====================
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.forgot');


// ==================== GIAO DIỆN NGƯỜI DÙNG ====================
Route::get('/cart', function () { return view('cart'); })->name('cart');
Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
Route::get('/profile', function () { return view('profile'); })->name('profile');


// ==================== GIAO DIỆN ADMIN ====================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Trang tổng quan & Báo cáo
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::get('/reports', function () { return view('admin.reports.index'); })->name('reports');

    // Quản lý Xe (Khai báo đủ các route tĩnh để JS render)
    Route::get('/cars', function () { return view('admin.cars.index'); })->name('cars.index');
    Route::get('/cars/create', function () { return view('admin.cars.creat'); })->name('cars.create');
    Route::get('/cars/{id}/edit', function () { return view('admin.cars.edit'); })->name('cars.edit');
    Route::get('/cars/{id}', function () { return view('admin.cars.show'); })->name('cars.show');

    // Quản lý Người dùng, Đơn hàng, Bình luận (Chỉ cần trang index cơ bản)
    Route::get('/users', function () { return view('admin.users.index'); })->name('users.index');
    Route::get('/orders', function () { return view('admin.orders.index'); })->name('orders.index');
    Route::get('/comments', function () { return view('admin.comments.index'); })->name('comments.index');
});