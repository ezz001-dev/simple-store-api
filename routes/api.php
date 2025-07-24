<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DashboardController;

// Auth
// Rute untuk Autentikasi
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Rute yang memerlukan autentikasi
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});


Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

// Rute untuk Admin
Route::group(['middleware' => ['auth:api', 'admin']], function () {
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('checkout', [OrderController::class, 'checkout'])->middleware('customer');

    // Rute yang hanya bisa diakses admin
    Route::group(['middleware' => 'admin'], function () {
        Route::get('orders/report', [OrderController::class, 'salesReport']);
        Route::get('dashboard/stats', [DashboardController::class, 'stats']);
    });
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
