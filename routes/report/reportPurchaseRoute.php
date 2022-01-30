<?php

use App\Http\Controllers\ReportPurchaseController;
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
            'report-purchase',
            [ReportPurchaseController::class, 'reportPurchase']
        )->name('report-Purchase.reportPurchase');
        Route::post(
            'search-report-purchase',
            [ReportPurchaseController::class, 'searchReportPurchase']
        )->name('report-purchase.searchReportIncomeSpending');
        Route::post(
            'refresh-report-Purchase',
            [ReportPurchaseController::class, 'dataLoad']
        )->name('report-purchase.dataLoad');
        Route::post(
            'refresh-report-Purchase',
            [ReportPurchaseController::class, 'dataLoad']
        )->name('report-purchase.dataLoad');
        Route::post(
            'refresh-report-Purchase-item',
            [ReportPurchaseController::class, 'itemLoad']
        )->name('report-purchase.itemLoad');
        Route::post(
            'refresh-report-Purchase-supplier',
            [ReportPurchaseController::class, 'supplierLoad']
        )->name('report-purchase.supplierLoad');
        Route::post(
            'refresh-report-Purchase-branch',
            [ReportPurchaseController::class, 'branchLoad']
        )->name('report-purchase.branchLoad');

        //print report
        Route::get(
            'print-report-purchase-periode',
            [ReportPurchaseController::class, 'printPeriode']
        )->name('print-report-purchase.periode');
        Route::get(
            'print-report-purchase-item',
            [ReportPurchaseController::class, 'printItem']
        )->name('print-report-purchase.item');
        Route::get(
            'print-report-purchase-supplier',
            [ReportPurchaseController::class, 'printSupplier']
        )->name('print-report-purchase.supplier');
        Route::get(
            'print-report-purchase-branch',
            [ReportPurchaseController::class, 'printBranch']
        )->name('print-report-purchase.branch');
    });
});
