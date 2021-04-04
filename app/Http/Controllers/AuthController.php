<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;

class AuthController extends Controller
{
  public function index() {
    return view('auth/login');
  }

  public function submitLogin(Request $request) {
    $validator = Validator::make($request->all(),
      [ 'email' => 'required|email', 'password' => 'required' ],
      [ 'email.required' => 'Email wajib diisi', 'email.email' => 'Email tidak valid', 'password.required' => 'Password wajib diisi', ]
    );
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    } else {
      if (Auth::attempt($request->only('email', 'password'))) {
        return redirect()->route('dashboard.index');
      } else {
        Session::flash('error', 'Maaf, email atau password anda salah!');
        return redirect()->route('auth.login');
      }
    }
  }
}