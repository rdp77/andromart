<?php

use App\Http\Controllers\StockMutationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Stock Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Stock routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Stock" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'warehouse'], function () {
    Route::group(['prefix' => 'stock-mutation'], function () {
        Route::resource('stockMutation', StockMutationController::class)
            ->except([
                'show',
            ]);
    });
});
