<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::post('/cart', [CartController::class, 'createCart']);


// Protected routes: Users
Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::group(['prefix' => 'user'], function () {
        Route::get('', [UserController::class, 'getUser']);
        Route::get('/role', [UserController::class, 'getRole']);
        Route::get('/cart', [UserController::class, 'getCart']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/products', [CartController::class, 'getProducts']);
        Route::get('/total', [CartController::class, 'getTotal']);
        Route::get('/quantities', [CartController::class, 'getQuantities']);

        Route::get('/items', [CartController::class, 'getItems']);
        Route::post('/item/{id}', [CartController::class, 'addItem']);
        Route::delete('/item/{id}', [CartController::class, 'removeItem']);
        Route::put('/item/quantity', [CartController::class, 'updateQuantity']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('', [OrderController::class, 'createOrder']);
        Route::post('/item', [OrderController::class, 'addOrderItem']);
        Route::get('', [OrderController::class, 'getUserOrders']);
    });
});

// Protected routes: Admins
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'admin'], function() {
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'getAllOrders']);
});

