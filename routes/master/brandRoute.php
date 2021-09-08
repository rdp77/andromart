<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Brand Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Brand routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Brand" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'brand'], function () {
        Route::resource('brand', BrandController::class)
            ->except([
                'show',
            ]);
    });
});
