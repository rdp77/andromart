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
            'refresh-report-sale',
            [ReportSaleController::class, 'dataLoad']
        )->name('report-sale.dataLoad');
        Route::post(
            'refresh-report-sale-item',
            [ReportSaleController::class, 'itemLoad']
        )->name('report-sale.itemLoad');
        Route::post(
            'refresh-report-sale-sales',
            [ReportSaleController::class, 'salesLoad']
        )->name('report-sale.salesLoad');
        Route::post(
            'refresh-report-sale-kas',
            [ReportSaleController::class, 'kasLoad']
        )->name('report-sale.kasLoad');
        Route::post(
            'refresh-report-sale-customer',
            [ReportSaleController::class, 'customerLoad']
        )->name('report-sale.customerLoad');
        Route::post(
            'refresh-report-sale-branch',
            [ReportSaleController::class, 'branchLoad']
        )->name('report-sale.branchLoad');
        // Route::post(
        //     'search-report-sale',
        //     [ReportSaleController::class, 'searchReportSale']
        // )->name('report-sale.searchReportIncomeSpending');

        //print report
        Route::get(
            'print-report-sale-periode',
            [ReportSaleController::class, 'printPeriode']
        )->name('print-report-sale.periode');
        Route::get(
            'print-report-sale-item',
            [ReportSaleController::class, 'printItem']
        )->name('print-report-sale.item');
        Route::get(
            'print-report-sale-sales',
            [ReportSaleController::class, 'printSales']
        )->name('print-report-sale.sales');
        Route::get(
            'print-report-sale-kas',
            [ReportSaleController::class, 'printKas']
        )->name('print-report-sale.kas');
        Route::get(
            'print-report-sale-customer',
            [ReportSaleController::class, 'printCustomer']
        )->name('print-report-sale.customer');
        Route::get(
            'print-report-sale-branch',
            [ReportSaleController::class, 'printBranch']
        )->name('print-report-sale.branch');

    });

});
