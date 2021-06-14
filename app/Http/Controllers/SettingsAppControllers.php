<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Hash;

class SettingsAppControllers extends Controller
{
  public function index(Request $request) {
    return view('settings/app_index', ['data' => Settings::first()]);
  }

  public function update(Request $request) {
    Settings::first()->update($request->except(['_token']));
    return redirect()->route('settings.app.index');
  }
}