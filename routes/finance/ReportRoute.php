<?php

// use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportIncomeSpendingController;
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

Route::group(['prefix' => 'finance'], function () {
    Route::group(['prefix' => 'report'], function () {
        Route::get(
            'report-income-spending',
            [ReportIncomeSpendingController::class, 'reportIncomeSpending']
        )->name('report-income-spending.reportIncomeSpending');
        Route::post(
            'search-report-income-spending',
            [ReportIncomeSpendingController::class, 'searchReportIncomeSpending']
        )->name('report-income-spending.searchReportIncomeSpending');

    });

});
