<?php

use App\Http\Controllers\Template\MenuController;
use App\Http\Controllers\Template\SubMenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Menu Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Menu routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Menu" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'menu'], function () {
        Route::resource('menu', MenuController::class)
            ->except([
                'show',
            ]);
        Route::resource('submenu', SubMenuController::class)
            ->except([
                'show', 'index'
            ]);
    });
});
