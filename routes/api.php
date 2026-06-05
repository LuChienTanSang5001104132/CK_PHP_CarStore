<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarApiController;


Route::get('/cars', [CarApiController::class, 'index']);

Route::post('/cars', [CarApiController::class, 'store']);

Route::get('/cars/{id}', [CarApiController::class, 'show']);

Route::put('/cars/{id}', [CarApiController::class, 'update']);

Route::delete('/cars/{id}', [CarApiController::class, 'destroy']);