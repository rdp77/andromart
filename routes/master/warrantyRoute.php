<?php

use App\Http\Controllers\WarrantyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Warranty Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Warranty routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Warranty" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'warranty'], function () {
        Route::resource('warranty', WarrantyController::class)
            ->except([
                'show',
            ]);
    });
});
