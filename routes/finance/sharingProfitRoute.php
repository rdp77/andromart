<?php

// use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SharingProfitController;
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
    Route::group(['prefix' => 'sharing-profit'], function () {
        Route::resource('sharing-profit', SharingProfitController::class);
            // ->except([
            //     'show',
            // ]);

        // Route::get(
        //     'sharing-profit-form-update-status',
        //     [ServiceController::class, 'sharing-profitFormUpdateStatus']
        // )->name('sharing-profit.serviceFormUpdateStatus');

        Route::post(
            'sharing-profit-load-data-service',
            [SharingProfitController::class, 'sharingProfitLoadDataService']
        )->name('sharing-profit.sharingProfitLoadDataService');

        Route::post(
            'check-journals',
            [SharingProfitController::class, 'sharingProfitCheckJournals']
        )->name('sharing-profit.sharingProfitCheckJournals');

        // Route::post(
        //     'sharing-profit-form-update-status-save-data',
        //     [ServiceController::class, 'sharing-profitFormUpdateStatusSaveData']
        // )->name('sharing-profit.serviceFormUpdateStatusSaveData');

        // Route::resource('sharing-profit-payment', ServicePaymentController::class);

    });

});
