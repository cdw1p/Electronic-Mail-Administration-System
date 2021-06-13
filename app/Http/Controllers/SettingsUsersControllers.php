<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class SettingsUsersControllers extends Controller
{
  public function index(Request $request) {
    return view('settings/users_index', ['data' => User::all()]);
  }

  public function create(Request $request) {
    return view('settings/users_create');
  }

  public function edit(Request $request) {
    $findData = User::where('email', $request->email)->first();
    if ($findData) {
      return view('settings/users_edit', ['data' => $findData]);
    } else {
      return redirect()->route('settings.users.index');
    }
  }

  public function store(Request $request) {
    User::create($request->except(['_token']));
    if ($request->password) {
      User::where('email', $request->email)->update([ 'password' => Hash::make($request->password) ]);
    }
    return redirect()->route('settings.users.index');
  }

  public function update(Request $request) {
    User::where('email', $request->email)->update($request->except(['_token', 'password']));
    if ($request->password) {
      User::where('email', $request->email)->update([ 'password' => Hash::make($request->password) ]);
    }
    return redirect()->route('settings.users.index');
  }

  public function delete(Request $request) {
    User::where('email', $request->email)->delete();
    return redirect()->route('settings.users.index');
  }
}