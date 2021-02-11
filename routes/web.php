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

Auth::routes();

Route::resource('/', 'App\Http\Controllers\BlogController');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/category', 'App\Http\Controllers\CategoryController');
    Route::resource('/tag', 'App\Http\Controllers\TagController');
    Route::resource('/user', 'App\Http\Controllers\UserController');
    Route::get('/post/tampil_hapus', 'App\Http\Controllers\PostController@tampil_hapus')->name('post.tampil_hapus');
    Route::get('/post/restore/{id}', 'App\Http\Controllers\PostController@restore')->name('post.restore');
    Route::delete('/post/kill/{id}', 'App\Http\Controllers\PostController@kill')->name('post.kill');
    Route::resource('/post', 'App\Http\Controllers\PostController');
    Route::resource('/user', 'App\Http\Controllers\UserController');
});





