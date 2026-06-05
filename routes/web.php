<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
Route::get('/home', [HomeController::class, 'home']);
Route::get('/ThongTin', [HomeController::class, 'thongTinCongTy']);
Route::get('/ChiTietXe/{id}', [HomeController::class, 'chiTietXe']);
Route::get('/TimKiem', [HomeController::class, 'timKiem']);