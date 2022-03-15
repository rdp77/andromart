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
        Route::resource('sale', SaleController::class);

        Route::get(
            'salePrint/{id}',
            [SaleController::class, 'printSale']
        )->name('sale.printSale');

        Route::post(
            'check-journals',
            [SaleController::class, 'checkJournals']
        )->name('sale.checkJournals');

        Route::get(
            'smallPrint/{id}',
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
        Route::get(
            'add-sale-return',
            [SaleReturnController::class, 'add']
        )->name('sale.return.add');
        Route::get(
            'detail-sale-return',
            [SaleReturnController::class, 'getDetail']
        )->name('sale.return.detail');
        Route::get(
            'sale-return-print/{id}',
            [SaleReturnController::class, 'printReturn']
        )->name('sale.return.print');
        Route::get(
            'sale-return-print-small/{id}',
            [SaleReturnController::class, 'printSmallReturn']
        )->name('sale.return.printSmall');

        // load item id
        Route::post(
            'sale-return-load-data-id',
            [SaleReturnController::class, 'loadDataItem']
        )->name('sale.return.loadDataItem');

        Route::post(
            'sale-return-load-data-item-all-id',
            [SaleReturnController::class, 'loadDataItemAll']
        )->name('sale.return.loadDataItemAll');

        Route::post(
            'sale-return-load-data-qty',
            [SaleReturnController::class, 'loadDataQty']
        )->name('sale.return.loadDataQty');

        Route::post(
            'sale-return-tindakan',
            [SaleReturnController::class, 'loadTindakan']
        )->name('sale.return.tindakan');

        // Route::post(
        //     'sale-return-load-action',
        //     [SaleReturnController::class, 'loadAction']
        // )->name('sale.return.loadDataQty');
    });
});
