<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardUserController;
use App\Http\Controllers\HomeController;
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

Route::controller(HomeController::class)->middleware('auth')->name('vote.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/vote/{candidate:id}', 'vote')->name('vote');
    });

Route::controller(DashboardController::class)->middleware(['auth:sanctum', 'verified', 'admin'])->name('dashboard.')->group(function () {
    Route::get('/dashboard', 'index')->name('index');
    Route::get('/dashboard/create', 'create')->name('create');
    Route::get('/dashboard/edit/{candidate:id}', 'edit')->name('edit');
    Route::post('/dashboard', 'store')->name('store');
    Route::put('/dashboard/update/{candidate:id}', 'update')->name('update');
    Route::delete('/dashboard/delete/{candidate:id}', 'destroy')->name('delete');
});

Route::controller(DashboardUserController::class)->middleware(['auth:sanctum', 'verified', 'admin'])->name('user.')->group(function () {
    Route::get('/dashboard/user', 'index')->name('index');
    Route::put('/dashboard/user/update', 'update')->name('update');
    Route::put('/dashboard/user/admin/{user:id}', 'admin')->name('admin');
    Route::delete('/dashboard/user/delete/{user:id}', 'destroy')->name('delete');
});
