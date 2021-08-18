<?php

use App\Http\Controllers\ServiceController;
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

Route::group(['prefix' => 'transaction'], function () {
    Route::group(['prefix' => 'service'], function () {
        Route::resource('service', ServiceController::class)
            ->except([
                'show',
            ]);
        // Users Password
        // Route::post('/reset/{id}', [CreditFundsController::class, 'reset'])
            // ->name('users.reset');
        // Users Name
        // Route::get('/change-name', [CreditFundsController::class, 'changeName']);
    });
});
