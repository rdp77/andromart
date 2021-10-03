<?php

use App\Http\Controllers\RegulationController;
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
    Route::group(['prefix' => 'regulation'], function () {
        Route::resource('regulation', RegulationController::class);
        Route::get('/all-sop', [RegulationController::class, 'all'])->name('regulationAll');
        Route::get('/select-sop/{id}', [RegulationController::class, 'select'])->name('regulationSelect');
        Route::get('/visi-misi', [RegulationController::class, 'visiMisi'])->name('visiMisi');
        Route::get('/delete-detail/{id}/{iddetail}', [RegulationController::class, 'deleteDetail'])->name('deleteDetail');
        Route::get('/delete/{id}', [RegulationController::class, 'regulationDelete'])->name('regulationDelete');
        Route::get('/visi', [RegulationController::class, 'visi'])->name('regulationVisi');
        Route::get('/misi', [RegulationController::class, 'misi'])->name('regulationMisi');
        Route::post('/update-visi-misi/{id}', [RegulationController::class, 'updateVisiMisi'])->name('regulationUpdateVisiMisi');
    });
});
