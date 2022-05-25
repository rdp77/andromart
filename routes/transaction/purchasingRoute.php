<?php

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\PurchasingDetailController;
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

Route::group(['prefix' => 'transaction'], function () {
    Route::group(['prefix' => 'purchasing'], function () {
        Route::resource('purchase', PurchaseController::class);
        Route::resource('reception', ReceptionController::class);
        Route::post('/history-purchasing', [ReceptionController::class, 'history'])->name('receptionHistory');
        Route::get('/approve/{id}', [PurchaseController::class, 'approve'])->name('purchaseApprove');
        Route::get('/reception/updated/{id}/{history}/{qty?}', [ReceptionController::class, 'updateHistory'])->name('receptionUpdatedHistory');
        Route::post('/reception/updated', [ReceptionController::class, 'updated'])->name('receptionUpdated');

        Route::get('/purchase/item/create', [PurchaseController::class, 'itemCreate'])->name('purchase.item.create');
        Route::post('/purchase/item', [PurchaseController::class, 'itemStore'])->name('purchase.item.store');
        // Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {});
        // Route::get('/user/{id}', [UserController::class, 'index']);
    });
});
