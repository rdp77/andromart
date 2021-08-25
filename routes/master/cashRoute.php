<?php

use App\Http\Controllers\CashController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Cash Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Cash routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Cash" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'cash'], function () {
        Route::resource('cash', CashController::class)
            ->except([
                'show',
            ]);
    });
});
