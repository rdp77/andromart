<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Customer routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Customer" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'customer'], function () {
        Route::resource('customer', CustomerController::class)
            ->except([
                'show',
            ]);
    });
});
