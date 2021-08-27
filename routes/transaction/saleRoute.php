<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sale Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Sale routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Sale" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'transaction'], function () {
    Route::group(['prefix' => 'sale'], function () {
        Route::resource('sale', SaleController::class)
            ->except([
                'show',
            ]);
    });
});
