<?php

// use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LossItemsController;
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
    Route::group(['prefix' => 'loss-items'], function () {
        Route::resource('loss-items', LossItemsController::class)
            ->except([
                'show',
            ]);

        // Route::get(
        //     'sharing-profit-form-update-status',
        //     [ServiceController::class, 'sharing-profitFormUpdateStatus']
        // )->name('sharing-profit.serviceFormUpdateStatus');

        Route::post(
            'loss-items-load-data-service',
            [LossItemsController::class, 'lossItemsLoadDataService']
        )->name('loss-items.lossItemsLoadDataService');

        // Route::post(
        //     'sharing-profit-form-update-status-save-data',
        //     [ServiceController::class, 'sharing-profitFormUpdateStatusSaveData']
        // )->name('sharing-profit.serviceFormUpdateStatusSaveData');

        // Route::resource('sharing-profit-payment', ServicePaymentController::class);

    });

});
