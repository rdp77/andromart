<?php

use App\Http\Controllers\ReportSummaryController;
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
            'report-summary',
            [ReportSummaryController::class, 'reportSummary']
        )->name('report-summary.reportSummary');
        Route::post(
            'search-report-summary',
            [ReportSummaryController::class, 'searchReportSummary']
        )->name('report-summary.searchReportSummary');

        //print report
        // Route::get(
        //     'print-report-purchase-periode',
        //     [ReportSummaryController::class, 'printPeriode']
        // )->name('print-report-purchase.periode');
        // Route::get(
        //     'print-report-purchase-item',
        //     [ReportPurchaseController::class, 'printItem']
        // )->name('print-report-purchase.item');
        // Route::get(
        //     'print-report-purchase-supplier',
        //     [ReportPurchaseController::class, 'printSupplier']
        // )->name('print-report-purchase.supplier');
        // Route::get(
        //     'print-report-purchase-branch',
        //     [ReportPurchaseController::class, 'printBranch']
        // )->name('print-report-purchase.branch');
    });
});
