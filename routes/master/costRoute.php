<?php

use App\Http\Controllers\CostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Cost Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Cost routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Cost" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'cost'], function () {
        Route::resource('cost', CostController::class)
            ->except([
                'show',
            ]);
    });
});
