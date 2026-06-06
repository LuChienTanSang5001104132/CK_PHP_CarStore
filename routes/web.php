<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', function () {
    return view('welcome');
})->name('home');


// ==================== AUTH ROUTES ====================
// Hiển thị form đăng nhập (gọi tới file resources/views/auth/login.blade.php)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Xử lý logic khi bấm nút Đăng nhập
Route::post('/login', function (Request $request) {
    // 1. Kiểm tra dữ liệu nhập vào
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // 2. Thực hiện đăng nhập
    if (auth()->attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        // Nếu là admin thì đẩy thẳng vào dashboard admin
        if (auth()->user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }
        
        // Nếu là user thường thì về trang chủ
        return redirect('/');
    }

    // 3. Đăng nhập thất bại (sai pass/email) thì quay lại form và báo lỗi
    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ])->onlyInput('email');
});


// ==================== ADMIN ROUTES ====================
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Quản lý Xe
        Route::resource('cars', \App\Http\Controllers\Admin\AdminCarController::class);

        // Quản lý Người dùng
        Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);

        // Quản lý Đơn hàng
        Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])
             ->name('orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'show'])
             ->name('orders.show');

        // Quản lý Bình luận
        Route::get('/comments', [\App\Http\Controllers\Admin\AdminCommentController::class, 'index'])
             ->name('comments.index');

        // Báo cáo
        Route::get('/reports', function () {
            return view('admin.reports.index'); // sẽ tạo sau
        })->name('reports');
    });

// Đăng xuất (dùng chung)
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');