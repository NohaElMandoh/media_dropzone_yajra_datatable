<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/album', [App\Http\Controllers\AlbumController::class, 'index'])->name('album.index');
Route::get('/album/create', [App\Http\Controllers\AlbumController::class, 'create'])->name('album.create');
Route::post('/album/store', [App\Http\Controllers\AlbumController::class, 'store'])->name('album.store');
Route::get('/album/view/{id}', [App\Http\Controllers\AlbumController::class, 'view'])->name('album.view');





Route::get('/media', [App\Http\Controllers\MediaController::class, 'index'])->name('media.index');
Route::get('/media/create', [App\Http\Controllers\MediaController::class, 'create'])->name('media.create');
Route::post('/upload', [App\Http\Controllers\MediaController::class, 'upload'])->name('media.upload');
Route::post('/destroy', [App\Http\Controllers\MediaController::class, 'fileDestroy'])->name('media.delete');
Route::get('/fetch', [App\Http\Controllers\MediaController::class, 'fetch'])->name('media.fetch');

