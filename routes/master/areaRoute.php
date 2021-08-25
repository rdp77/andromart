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
    Route::group(['prefix' => 'area'], function () {
        Route::resource('area', AreaController::class)
            ->except([
                'show',
            ]);
    });
});
