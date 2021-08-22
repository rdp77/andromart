<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front End
// Route::get('/', function () { 
// 	return view('pages.frontend.index');
// });
Route::get('/', [FrontendController::class, 'home'])->name('frontendHome');
Route::get('/about', [FrontendController::class, 'about'])->name('frontendAbout');
Route::get('/services', [FrontendController::class, 'services'])->name('frontendServices');
Route::get('/work', [FrontendController::class, 'work'])->name('frontendWork');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontendContact');
// Route::get('/', function () {
//     return view('home');
// });

// Backend
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/log', [DashboardController::class, 'log'])
    ->name('dashboard.log');


require __DIR__ . '/auth.php';
require __DIR__ . '/transaction/serviceRoute.php';
require __DIR__ . '/content/notes.php';
require __DIR__ . '/item.php';
require __DIR__ . '/users.php';