<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/zoom/getUser', 'ZoomController@getUser')->name('zoom.getUser');
Route::get('/zoom/getMeeting', 'ZoomController@getMeeting')->name('zoom.getMeeting');
Route::get('/zoom/createMeeting', 'ZoomController@createMeeting')->name('zoom.createMeeting');