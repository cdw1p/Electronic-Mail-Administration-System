<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Route::group([ 'middleware' => ['auth:sanctum', 'verified'] ], function() {
    Route::view('/', 'dashboard')->name('dashboard');

    Route::get('/user', 'UserController@index')->name('user');
    Route::view('/user/new', 'pages.user.user-new')->name('user.new');
    Route::view('/user/edit/{userId}', 'pages.user.user-edit')->name('user.edit');
});
