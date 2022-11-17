<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServicePaymentController;
use App\Http\Controllers\ServiceItemsController;
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

        Route::get(
            'traffic-count',
            [ServiceController::class, 'trafficCount']
        )->name('service.trafficCount');

        Route::get(
            'service-onProgress',
            [ServiceController::class, 'onProgress']
        )->name('service.onProgress');
        Route::post(
            'service-onProgressLoad',
            [ServiceController::class, 'onProgressLoad']
        )->name('service.onProgressLoad');
        Route::get(
            'service-onProgressPrint',
            [ServiceController::class, 'onProgressPrint']
        )->name('service.onProgressPrint');

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

        Route::post(
            'check-journals-loss',
            [ServiceController::class, 'checkJournalsLoss']
        )->name('service-items.checkJournalsLoss');

        Route::get(
            'service/{id}',
            [ServiceController::class, 'printService']
        )->name('service.printService');

        Route::get(
            'service/{id}/show',
            [ServiceController::class, 'show']
        )->name('service.show');

        Route::resource('service-payment', ServicePaymentController::class);

        Route::get(
            'print-service-payment/{id}',
            [ServicePaymentController::class, 'printServicePayment']
        )->name('service.printServicePayment');

        // route service item / barang dagangan
        Route::resource('service-items', ServiceItemsController::class);
        
        Route::post(
            'service-items/check-journals',
            [ServiceItemsController::class, 'checkJournals']
        )->name('service-items.checkJournals');

     

        Route::post(
            'service-items/check-stock',
            [ServiceItemsController::class, 'checkStock']
        )->name('service-items.checkStock');

        Route::get(
            'service-items/{id}',
            [ServiceItemsController::class, 'printService']
        )->name('service-items.printService');

        Route::post(
            'service-items/check-price-service-items',
            [ServicePaymentController::class, 'checkPriceServiceItems']
        )->name('service-items.checkPriceServiceItems');



    });
});
