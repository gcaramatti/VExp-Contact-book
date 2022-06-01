<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/categorias', [App\Http\Controllers\CategoryController::class, 'index'])->name('categorias');
Route::delete('/apagar-categoria/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('apagar-categoria');
Route::post('/nova-categoria', [App\Http\Controllers\CategoryController::class, 'store'])->name('nova-categoria');