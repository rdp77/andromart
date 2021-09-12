<?php

use App\Http\Controllers\NotesController;
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
    Route::group(['prefix' => 'notes'], function () {
        Route::resource('notes', NotesController::class);
    });
});
