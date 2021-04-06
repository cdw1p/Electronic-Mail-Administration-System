<?php

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

Route::group(['middleware' => 'role:admin,user'], function() {
  Route::get('/zoom/getUser', 'ZoomController@getUser')->name('zoom.getUser');
  Route::get('/zoom/getMeeting', 'ZoomController@getMeeting')->name('zoom.getMeeting');
  Route::get('/zoom/endMeeting', 'ZoomController@endMeeting')->name('zoom.endMeeting');
  Route::get('/zoom/createMeeting', 'ZoomController@createMeeting')->name('zoom.createMeeting');
  Route::get('/zoom/deleteMeeting', 'ZoomController@deleteMeeting')->name('zoom.deleteMeeting');
});