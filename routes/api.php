<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\v1;
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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/discount')
    ->controller(v1\DiscountController::class)
    ->group(function () {
        Route::get('/find/{order}', 'discountFinder');
        Route::post('/', 'store');
        Route::get('/', 'index');
    });

Route::prefix('/order')
    ->controller(v1\OrderController::class)
    ->group(function () {
        Route::get('/products', 'orderedProducts');
        Route::get('/discounts', 'orderedDiscounts');
    });

Route::apiResource('category', v1\CategoryController::class);
Route::apiResource('customer', v1\CustomerController::class);
Route::apiResource('order', v1\OrderController::class);
Route::apiResource('product', v1\ProductController::class);

