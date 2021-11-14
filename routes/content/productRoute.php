<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|
| Here is where you can register users routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "users" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'content'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::resource('type-product', TypeProductController::class);
        Route::resource('product', ProductController::class);
        Route::get('product-created/{id}', [ProductController::class, 'created'])->name('product.created');
    });
});
