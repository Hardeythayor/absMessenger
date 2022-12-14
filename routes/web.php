<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('is_admin')->prefix('messages')->name('messages.')->group(function () {
    Route::get('/', [MessagesController::class, 'index'])->name('index')->withoutMiddleware('is_admin');
    Route::get('/admin', [MessagesController::class, 'messages_for_admin_index'])->name('admin');
    Route::get('/admin/fetch', [MessagesController::class, 'fetch_messages_for_admin'])->name('admin.fetch');
    Route::post('/send', [MessagesController::class, 'store'])->name('send')->withoutMiddleware('is_admin');
});

Route::middleware('is_admin')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'users_index'])->name('index');
    Route::post('/fetch', [UserController::class, 'index'])->name('fetch');
    Route::put('/change_status/{id}', [UserController::class, 'update'])->name('change_status');
});

