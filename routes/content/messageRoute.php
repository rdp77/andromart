<?php
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Purchasing Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Purchasing routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Purchasing" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'content'], function () {
    Route::group(['prefix' => 'messages'], function () {
        Route::resource('message', MessageController::class);
    });
});
