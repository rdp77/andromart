<?php

use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Icon Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Icon routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Icon" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'asset'], function () {
        Route::resource('asset', AssetController::class)
            ->except([
                'show',
            ]);
    });
});
