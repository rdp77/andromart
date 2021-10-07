<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServicePaymentController;
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

Route::group(['prefix' => 'transaction'], function () {
    Route::group(['prefix' => 'service'], function () {
        Route::resource('service', ServiceController::class)
            ->except([
                'show',
            ]);

        Route::get(
            'service-form-update-status',
            [ServiceController::class, 'serviceFormUpdateStatus']
        )->name('service.serviceFormUpdateStatus');

        Route::post(
            'service-form-update-status-load-data',
            [ServiceController::class, 'serviceFormUpdateStatusLoadData']
        )->name('service.serviceFormUpdateStatusLoadData');

        Route::post(
            'service-form-update-status-save-data',
            [ServiceController::class, 'serviceFormUpdateStatusSaveData']
        )->name('service.serviceFormUpdateStatusSaveData');

        Route::post(
            'check-journals',
            [ServicePaymentController::class, 'serviceCheckJournals']
        )->name('service.serviceCheckJournals');

        Route::get(
            'service/{id}',
            [ServiceController::class, 'printService']
        )->name('service.printService');

        

        Route::resource('service-payment', ServicePaymentController::class);

        Route::get(
            'print-service-payment/{id}',
            [ServicePaymentController::class, 'printServicePayment']
        )->name('service.printServicePayment');

    });
});
