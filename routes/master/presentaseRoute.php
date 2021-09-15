<?php

use App\Http\Controllers\SettingPresentaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Presentase Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Presentase routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Presentase" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'presentase'], function () {
        Route::resource('presentase', SettingPresentaseController::class)
            ->except([
                'show',
            ]);
        Route::post('/update-presentase', [SettingPresentaseController::class, 'updates'])
            ->name('updatePresentase');
    });
});
