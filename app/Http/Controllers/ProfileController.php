<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class ProfileController extends Controller
{
  public function index(Request $request) {
    $findData = User::where('email', Auth::user()->email)->first();
    if ($findData) {
      return view('dashboard/profile', ['data' => $findData]);
    } else {
      return redirect()->route('profile.index');
    }
  }

  public function update(Request $request) {
    User::where('email', Auth::user()->email)->update($request->except(['_token', 'password']));
    if ($request->password) {
      User::where('email', Auth::user()->email)->update([ 'password' => Hash::make($request->password) ]);
    }
    return redirect()->route('profile.index');
  }
}