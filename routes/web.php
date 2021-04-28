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

Route::group(['middleware' => 'role:guest'], function() {
  Route::get('/auth/login', 'AuthController@index')->name('auth.login');
  Route::post('/auth/login', 'AuthController@submitLogin')->name('auth.submitLogin');
  Route::get('/auth/register', 'AuthController@register')->name('auth.register');
  Route::post('/auth/register', 'AuthController@submitRegister')->name('auth.submitRegister');
  Route::get('/auth/verify/{id}', 'AuthController@verifyToken')->name('auth.verifyToken');
});

Route::group(['middleware' => 'role:admin,user'], function() {
  Route::get('/', 'DashboardController@index')->name('dashboard.index');
  Route::get('/logout', 'DashboardController@logout')->name('dashboard.logout');
  Route::get('/certificate/sign', 'CertificateController@sign')->name('certificate.sign');
  Route::get('/certificate/check/{id}', 'CertificateController@check')->name('certificate.check');
});