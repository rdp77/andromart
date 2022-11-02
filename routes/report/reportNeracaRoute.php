<?php

use App\Http\Controllers\ReportNeracaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Payment routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Payment" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'report'], function () {
    Route::group(['prefix' => 'report'], function () {
        Route::resource('report-neraca', ReportNeracaController::class)
            ->except([
                'show',
            ]);

        // Route::post(
        //     'search-report-neraca',
        //     [ReportNeracaController::class, 'searchReportNeraca']
        // )->name('report-neraca.searchReportNeraca');

        Route::get(
            'print-neraca',
            [ReportNeracaController::class, 'printReportNeraca']
        )->name('report-neraca.printReportNeraca');
        
        Route::get(
            'load-data-neraca',
            [ReportNeracaController::class, 'loadDataReportNeraca']
        )->name('report-neraca.loadDataReportNeraca');
    });
});
