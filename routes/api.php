<?php

use Illuminate\Support\Facades\Route;

// Route::group([ 'middleware' => ['auth:sanctum'] ], function() {
  // QRCode Module
  Route::get('/qrcode/generate', 'QRController@generate')->name('qrcode.generate');

  // Certificate Module
  Route::get('/certificate/sign', 'CertificateController@sign')->name('certificate.sign');
  Route::get('/certificate/check/{id}', 'CertificateController@check')->name('certificate.check');
// });