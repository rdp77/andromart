<?php

use App\Http\Controllers\ReportServicePaymentController;
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
            'report-service-payment',
            [ReportServicePaymentController::class, 'reportServicePayment']
        )->name('report-service-payment.reportServicePayment');
        Route::post(
            'refresh-report-service-payment',
            [ReportServicePaymentController::class, 'dataLoad']
        )->name('report-service-payment.dataLoad');
        Route::post(
            'refresh-report-service-payment-branch',
            [ReportServicePaymentController::class, 'branchLoad']
        )->name('report-service-payment.branchLoad');

        // Print Report Service Payment
        Route::get(
            'print-report-service-payment-periode',
            [ReportServicePaymentController::class, 'printPeriode']
        )->name('print-report-service-payment.periode');
        Route::get(
            'print-report-service-payment-branch',
            [ReportServicePaymentController::class, 'printBranch']
        )->name('print-report-service-payment.branch');
    });
});
