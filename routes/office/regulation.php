<?php

use App\Http\Controllers\RegulationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Branch Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Branch routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Branch" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'office'], function () {
    Route::group(['prefix' => 'regulation'], function () {
        Route::resource('regulation', RegulationController::class);
    });
});
