<?php

use App\Http\Controllers\ReportSaleController;
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

Route::group(['prefix' => 'report'], function () {
    Route::group(['prefix' => 'report'], function () {
        Route::get(
            'report-sale',
            [ReportSaleController::class, 'reportSale']
        )->name('report-sale.reportSale');
        Route::post(
            'search-report-sale',
            [ReportSaleController::class, 'searchReportSale']
        )->name('report-sale.searchReportIncomeSpending');

    });

});
