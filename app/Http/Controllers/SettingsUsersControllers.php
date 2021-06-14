<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Session;

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
    $createUsers = User::create($request->except(['_token']));
    if ($request->password) {
      User::where('email', $request->email)->update([ 'password' => Hash::make($request->password) ]);
    }
    if ($createUsers) {
      Session::flash('success', 'Selamat, data pengguna berhasil disimpan kedalam database server!');
    } else {
      Session::flash('error', 'Maaf, data pengguna tidak dapat disimpan. Silahkan coba lagi!');
    }
    return redirect()->route('settings.users.index');
  }

  public function update(Request $request) {
    $updateUsers = User::where('email', $request->email)->update($request->except(['_token', 'password']));
    if ($request->password) {
      User::where('email', $request->email)->update([ 'password' => Hash::make($request->password) ]);
    }
    if ($updateUsers) {
      Session::flash('success', 'Selamat, data pengguna berhasil disimpan kedalam database server!');
    } else {
      Session::flash('error', 'Maaf, data pengguna tidak dapat disimpan. Silahkan coba lagi!');
    }
    return redirect()->route('settings.users.index');
  }

  public function delete(Request $request) {
    $deleteUsers = User::where('email', $request->email)->delete();
    if ($deleteUsers) {
      Session::flash('success', 'Selamat, data pengguna berhasil dihapus pada database server!');
    } else {
      Session::flash('error', 'Maaf, data pengguna tidak dapat dihapus. Silahkan coba lagi!');
    }
    return redirect()->route('settings.users.index');
  }
}