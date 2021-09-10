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
Route::post('/message', [FrontendController::class, 'message'])->name('frontendMessage');
Route::get('/login', [FrontendController::class, 'login'])->name('frontendLogin');
Route::get('/trackingService/{id}', [FrontendController::class, 'tracking'])->name('frontendTracking');
// Route::get('/login', function () {
//     return view('home');
// });

// Backend
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/log', [DashboardController::class, 'log'])
    ->name('dashboard.log');

require __DIR__ . '/auth.php';
require __DIR__ . '/master/areaRoute.php';
require __DIR__ . '/master/branchRoute.php';
require __DIR__ . '/master/brandRoute.php';
require __DIR__ . '/master/cashRoute.php';
require __DIR__ . '/master/categoryRoute.php';
require __DIR__ . '/master/costRoute.php';
require __DIR__ . '/master/customerRoute.php';
require __DIR__ . '/master/employeeRoute.php';
require __DIR__ . '/master/itemRoute.php';
require __DIR__ . '/master/unitRoute.php';
require __DIR__ . '/master/supplierRoute.php';
require __DIR__ . '/master/typeRoute.php';
require __DIR__ . '/master/warrantyRoute.php';
require __DIR__ . '/transaction/serviceRoute.php';
require __DIR__ . '/finance/sharingProfitRoute.php';
require __DIR__ . '/finance/lossItemsRoute.php';
require __DIR__ . '/transaction/saleRoute.php';
require __DIR__ . '/transaction/paymentRoute.php';
require __DIR__ . '/transaction/purchasingRoute.php';
require __DIR__ . '/content/notes.php';
require __DIR__ . '/content/contents.php';
require __DIR__ . '/users.php';
require __DIR__ . '/warehouse/stockRoute.php';
