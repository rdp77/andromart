<?php

use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
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

        Route::get(
            'sale/{id}',
            [SaleController::class, 'printSale']
        )->name('sale.printSale');

        Route::get(
            'sale-print/{id}',
            [SaleController::class, 'printSmallSale']
        )->name('sale.printSmallSale');

        Route::get(
            'payment-method',
            [SaleController::class, 'getPaymentMethod']
        )->name('sale.getPaymentMethod');

        // Return
        Route::resource('sale-return', SaleReturnController::class);
        Route::get(
            'get-sale-return',
            [SaleReturnController::class, 'getData']
        )->name('sale.return.data');
        Route::post(
            'sale-type-return',
            [SaleReturnController::class, 'getType']
        )->name('sale.return.type');
    });
});