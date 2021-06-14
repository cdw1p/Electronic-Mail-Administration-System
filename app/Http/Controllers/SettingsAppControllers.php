<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Hash;
use Session;

class SettingsAppControllers extends Controller
{
  public function index(Request $request) {
    return view('settings/app_index', ['data' => Settings::first()]);
  }

  public function update(Request $request) {
    $updateSettings = Settings::first()->update($request->except(['_token']));
    if ($updateSettings) {
      Session::flash('success', 'Selamat, data pengaturan aplikasi berhasil disimpan kedalam database server!');
    } else {
      Session::flash('error', 'Maaf, data pengaturan tidak dapat disimpan. Silahkan coba lagi!');
    }
    return redirect()->route('settings.app.index');
  }
}