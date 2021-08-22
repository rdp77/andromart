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
    // Route::post('notes/save-notes', [NotesController::class, 'create'])->name('save notes');
    Route::get('notes/delete/{id}', [NotesController::class, 'delete'])->name('notesPhotoDelete');
    Route::resource('notes', NotesController::class);
});
