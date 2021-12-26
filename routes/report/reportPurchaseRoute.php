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
        Route::get('report-purchase', [ReportPurchaseController::class, 'reportPurchase'])->name('report-Purchase.reportPurchase');
        Route::post('search-report-purchase', [ReportPurchaseController::class, 'searchReportPurchase'])->name('report-purchase.searchReportIncomeSpending');
        Route::post('refresh-report-Purchase', [ReportPurchaseController::class, 'dataLoad'])->name('report-purchase.dataLoad');
    });
});
