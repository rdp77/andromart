<?php

use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Type Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Type routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Type" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'type'], function () {
        Route::resource('type', TypeController::class)
            ->except([
                'show',
            ]);
    });
});
