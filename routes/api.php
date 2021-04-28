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

Route::group(['middleware' => 'role:admin'], function() {
  // Room Module
  Route::post('/room/create', 'RoomController@create')->name('room.create');
});

Route::group(['middleware' => 'role:admin,user'], function() {
  // Zoom Module
  Route::get('/zoom/getUser', 'ZoomController@getUser')->name('zoom.getUser');
  Route::get('/zoom/getMeeting', 'ZoomController@getMeeting')->name('zoom.getMeeting');
  Route::get('/zoom/endMeeting', 'ZoomController@endMeeting')->name('zoom.endMeeting');
  Route::get('/zoom/createMeeting', 'ZoomController@createMeeting')->name('zoom.createMeeting');
  Route::get('/zoom/deleteMeeting', 'ZoomController@deleteMeeting')->name('zoom.deleteMeeting');

  // QRCode Module
  Route::get('/qrcode/generate', 'QRController@generate')->name('qr.generate');

  // Certificate Module
  Route::get('/certificate/sign', 'CertificateController@sign')->name('certificate.sign');
  Route::get('/certificate/check/{id}', 'CertificateController@check')->name('certificate.check');
});