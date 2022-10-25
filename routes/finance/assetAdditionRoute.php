<?php

use App\Http\Controllers\AssetAdditionController;
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
    Route::group(['prefix' => 'asset-addition'], function () {
        Route::resource('asset-addition', AssetAdditionController::class)
            ->except([
                'show',
            ]);

        Route::post(
            'check-journals',
            [AssetAdditionController::class, 'assetAdditionCheckJournals']
        )->name('asset-addition.assetAdditionCheckJournals');
    });
});
