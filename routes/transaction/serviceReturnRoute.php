<?php

use App\Http\Controllers\ServiceReturnController;
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
    Route::group(['prefix' => 'service-return'], function () {
        Route::resource('service-return', ServiceReturnController::class)
            ->except([
                'show',
            ]);

        Route::get(
            'service-get-data',
            [ServiceReturnController::class, 'serviceGetData']
        )->name('service-return.serviceGetData');
    });
});