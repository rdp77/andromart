<?php

use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Unit Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Unit routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Unit" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'unit'], function () {
        Route::resource('unit', UnitController::class)
            ->except([
                'show',
            ]);
    });
});
