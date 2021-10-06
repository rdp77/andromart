<?php

use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Area Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Area routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Area" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'account-main'], function () {
        Route::resource('account-main', AccountMainController::class)
            ->except([
                'show',
            ]);
    });
    Route::group(['prefix' => 'account-main-detail'], function () {
        Route::resource('account-main-detail', AccountMainDetailController::class)
            ->except([
                'show',
            ]);
    });
    Route::group(['prefix' => 'account-data'], function () {
        Route::resource('account-data', AccountDataController::class)
            ->except([
                'show',
            ]);
    });
});
