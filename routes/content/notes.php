<?php

use App\Http\Controllers\NotesController;
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
    Route::group(['prefix' => 'notes'], function () {
        Route::resource('notes', NotesController::class)
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
