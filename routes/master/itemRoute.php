<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Item Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Item routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Item" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'item'], function () {
        Route::resource('item', ItemController::class)
            ->except([
                'show',
            ]);
    });
});
