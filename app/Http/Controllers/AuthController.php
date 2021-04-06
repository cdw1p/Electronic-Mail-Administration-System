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

  public function register() {
    return view('auth/register');
  }

  public function submitRegister(Request $request) {
    $validator = Validator::make($request->all(),
      [ 'name' => 'required', 'email' => 'required|email', 'password' => 'required' ],
      [ 'name.required' => 'Nama wajib diisi', 'email.required' => 'Email wajib diisi', 'email.email' => 'Email tidak valid', 'password.required' => 'Password wajib diisi', ]
    );
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    } else {
      $findData = User::where('email', $request->email)->first();
      if (!$findData) {
        User::create([ 'name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'role' => 'user' ]);
        Session::flash('success', 'Selamat, akun anda berhasil diregistrasi!');
        return redirect()->route('auth.login');
      } else {
        Session::flash('error', 'Maaf, email sudah pernah digunakan!');
        return redirect()->route('auth.register');
      }
    }
  }
}