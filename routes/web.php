<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - CHỈ TRẢ VỀ GIAO DIỆN (VIEWS)
|--------------------------------------------------------------------------
*/

// ── Trang chủ
Route::get('/', function () { return view('welcome'); })->name('home');

// ── Giao diện Auth (Đăng nhập, Đăng ký, Quên mật khẩu)
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.forgot');

// ── Giao diện Người dùng
Route::get('/cart', function () { return view('cart'); })->name('cart');
Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
Route::get('/profile', function () { return view('profile'); })->name('profile');

// ── Giao diện Admin (Khai báo đủ các tên route để thanh menu không bị lỗi)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    
    // Các route này sẽ gọi đến các file view trong thư mục resources/views/admin/...
    Route::get('/cars', function () { return view('admin.cars.index'); })->name('cars.index');
    Route::get('/users', function () { return view('admin.users.index'); })->name('users.index');
    Route::get('/orders', function () { return view('admin.orders.index'); })->name('orders.index');
    Route::get('/comments', function () { return view('admin.comments.index'); })->name('comments.index');
    Route::get('/reports', function () { return view('admin.reports.index'); })->name('reports');
});