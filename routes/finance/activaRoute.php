<?php

use App\Http\Controllers\ActivaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Icon Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Icon routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Icon" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'finance'], function () {
    Route::group(['prefix' => 'activa'], function () {
        Route::resource('activa', ActivaController::class)->except('show');
        
        Route::get(
            'activa/detail',
            [ActivaController::class, 'detail']
        )->name('activa.detail');

        Route::get(
            'activa/depreciation',
            [ActivaController::class, 'depreciation']
        )->name('activa.depreciation');

        Route::get(
            'activa/excel-view',
            [ActivaController::class, 'excelView']
        )->name('activa.excel-view');

        Route::post(
            'activa/store-depreciation',
            [ActivaController::class, 'storeDepreciation']
        )->name('activa.storeDepreciation');
        
        Route::get(
            'activa/change-status',
            [ActivaController::class, 'changeStatus']
        )->name('activa.changeStatus');

        Route::get(
            'activa/check-journals',
            [ActivaController::class, 'activaCheckJournals']
        )->name('activa.activaCheckJournals');

        Route::get(
            'activa/stop-activa',
            [ActivaController::class, 'stopActiva']
        )->name('activa.stop-activa');

        Route::post(
            'activa/stop-store-activa',
            [ActivaController::class, 'stopStoreActiva']
        )->name('activa.stop-store-activa');
    });
});
