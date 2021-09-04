<?php

use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|
| Here is where you can register users routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "users" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'content'], function () {
    // Route::post('content/save-content', [ContentController::class, 'create'])->name('save content');
    Route::get('contents/create/{id}', [ContentController::class, 'creates'])->name('contentCreates');
    Route::post('contents/store/{id}', [ContentController::class, 'stores'])->name('contentStores');
    Route::get('contents/delete/{id}', [ContentController::class, 'delete'])->name('contentPhotoDelete');
    Route::resource('contents', ContentController::class);
});
