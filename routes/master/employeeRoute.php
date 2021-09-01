<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Employee routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Employee" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'master'], function () {
    Route::group(['prefix' => 'employee'], function () {
        Route::resource('employee', EmployeeController::class)
            ->except([
                'show',
            ]);
    });
});
