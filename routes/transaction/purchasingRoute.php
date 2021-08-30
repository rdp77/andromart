<?php

use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\PurchasingDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Purchasing Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Purchasing routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Purchasing" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'transaction'], function () {
    Route::group(['prefix' => 'Purchasing'], function () {
        Route::resource('Purchasing', PurchasingController::class);
        Route::resource('PurchasingDetail', PurchasingDetailController::class);
    });
});
