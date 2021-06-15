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

  // Modul Meeting - Users
  Route::get('/meeting/users', 'MeetingScheduleController@users_index')->name('meeting.schedule.users_index');
  Route::get('/meeting/attendance', 'MeetingScheduleController@users_attendance')->name('meeting.schedule.users_attendance');
  Route::post('/meeting/join', 'MeetingScheduleController@users_join')->name('meeting.schedule.users_join');

  // Modul Profile
  Route::get('/profile', 'ProfileController@index')->name('profile.index');
  Route::post('/profile/update', 'ProfileController@update')->name('profile.update');
});

Route::group(['middleware' => 'role:admin'], function() {
  // Modul Meeting - Schedule
  Route::get('/meeting/schedule', 'MeetingScheduleController@index')->name('meeting.schedule.index');
  Route::get('/meeting/schedule/create', 'MeetingScheduleController@create')->name('meeting.schedule.create');
  Route::post('/meeting/schedule/create', 'MeetingScheduleController@store')->name('meeting.schedule.store');
  Route::get('/meeting/schedule/edit/{id}', 'MeetingScheduleController@edit')->name('meeting.schedule.edit');
  Route::post('/meeting/schedule/edit/{id}', 'MeetingScheduleController@update')->name('meeting.schedule.update');
  Route::get('/meeting/schedule/stop/{id}', 'MeetingScheduleController@stop')->name('meeting.schedule.stop');
  Route::get('/meeting/schedule/delete/{id}', 'MeetingScheduleController@delete')->name('meeting.schedule.delete');

  // Modul Meeting - Invitation
  Route::get('/meeting/invitation', 'MeetingInvititationController@index')->name('meeting.invitation.index');
  Route::post('/meeting/invitation/create', 'MeetingInvititationController@store')->name('meeting.invitation.store');
  Route::get('/settings/users/delete/{id}', 'MeetingInvititationController@delete')->name('meeting.invitation.delete');
  Route::get('/meeting/invitation/getParticipants/{id}', 'MeetingInvititationController@getParticipants')->name('meeting.invitation.getParticipants');

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