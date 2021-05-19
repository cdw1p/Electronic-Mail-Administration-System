<?php

use Illuminate\Support\Facades\Route;

// Route::group([ 'middleware' => ['auth:sanctum'] ], function() {
  // Room Module
  Route::get('/room/get', 'RoomController@get')->name('room.get');
  Route::post('/room/create', 'RoomController@create')->name('room.create');
  Route::post('/room/update', 'RoomController@update')->name('room.update');
  Route::post('/room/delete', 'RoomController@delete')->name('room.delete');

  // User Module
  Route::get('/user/get', 'UserController@get')->name('user.get');
  Route::post('/user/update', 'UserController@update')->name('user.update');
  Route::post('/user/create', 'UserController@create')->name('user.create');
  Route::post('/user/delete', 'UserController@delete')->name('user.delete');

  // Zoom Module
  Route::get('/zoom/getUser', 'ZoomController@getUser')->name('zoom.getUser');
  Route::get('/zoom/getMeeting', 'ZoomController@getMeeting')->name('zoom.getMeeting');
  Route::get('/zoom/createMeeting', 'ZoomController@createMeeting')->name('zoom.createMeeting');
  Route::get('/zoom/endMeeting/{id}', 'ZoomController@endMeeting')->name('zoom.endMeeting');
  Route::get('/zoom/deleteMeeting/{id}', 'ZoomController@deleteMeeting')->name('zoom.deleteMeeting');

  // QRCode Module
  Route::get('/qrcode/generate', 'QRController@generate')->name('qrcode.generate');

  // Certificate Module
  Route::get('/certificate/sign', 'CertificateController@sign')->name('certificate.sign');
  Route::get('/certificate/check/{id}', 'CertificateController@check')->name('certificate.check');
// });