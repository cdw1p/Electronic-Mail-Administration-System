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
  // Modul Authentication
  Route::get('/auth/login', 'AuthController@index')->name('auth.login');
  Route::post('/auth/login', 'AuthController@submitLogin')->name('auth.submitLogin');
  Route::get('/auth/register', 'AuthController@register')->name('auth.register');
  Route::post('/auth/register', 'AuthController@submitRegister')->name('auth.submitRegister');
  Route::get('/auth/verify/{id}', 'AuthController@verifyToken')->name('auth.verifyToken');
});

Route::group(['middleware' => 'role:user'], function() {
  // Modul Dashboard
  Route::get('/', 'DashboardController@index')->name('dashboard.index');
  Route::get('/logout', 'DashboardController@logout')->name('dashboard.logout');

  // Modul Profile
  Route::get('/profile', 'ProfileController@index')->name('profile.index');
  Route::post('/profile/update', 'ProfileController@update')->name('profile.update');
});

Route::group(['middleware' => 'role:admin'], function() {
  // Modul Users Management
  Route::get('/settings/users', 'SettingsUsersControllers@index')->name('settings.users.index');
  Route::get('/settings/users/create', 'SettingsUsersControllers@create')->name('settings.users.create');
  Route::post('/settings/users/create', 'SettingsUsersControllers@store')->name('settings.users.store');
  Route::get('/settings/users/edit/{email}', 'SettingsUsersControllers@edit')->name('settings.users.edit');
  Route::post('/settings/users/edit/{email}', 'SettingsUsersControllers@update')->name('settings.users.update');
  Route::get('/settings/users/delete/{email}', 'SettingsUsersControllers@delete')->name('settings.users.delete');

  // Modul Aplikasi
  Route::get('/settings/app', 'SettingsAppControllers@index')->name('settings.app.index');
  Route::post('/settings/app', 'SettingsAppControllers@update')->name('settings.app.update');
});