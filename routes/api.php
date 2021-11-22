<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\FrontendController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test/{table}', [FrontendController::class, 'checkTable'])->name('apiTable');
Route::post('/test/input', [FrontendController::class, 'inputs'])->name('apiInput');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
