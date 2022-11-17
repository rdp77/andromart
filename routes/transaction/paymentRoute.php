<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Payment routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Payment" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'transaction'], function () {
    Route::group(['prefix' => 'payment'], function () {
        Route::resource('payment', PaymentController::class);

        Route::post(
            'check-journals',
            [PaymentController::class, 'paymentCheckJournals']
        )->name('payment.paymentCheckJournals');
    });
});
