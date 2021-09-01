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
    Route::get('contents/delete/{id}', [ContentController::class, 'delete'])->name('contentPhotoDelete');
    Route::get('contents/content-show/{id}', [ContentController::class, 'showContent'])->name('contentShow');
    Route::resource('contents', ContentController::class);
});
