<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendMail;
use App\Models\User;
use Validator;
use Hash;
use Session;

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
        $randomCode = Str::random(30);
        $createUser = User::create([ 'name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'role' => 'user', 'status' => '0', 'remember_token' => $randomCode ]);
        if ($createUser) {
          Mail::to($request->email)->send(new SendMail($request->name, $randomCode));
          Session::flash('success', 'Selamat, akun anda berhasil diregistrasi. Silahkan cek email anda untuk mengaktifkan akun!');
          return redirect()->route('auth.login');
        } else {
          Session::flash('error', 'Maaf, backend server bermasalah, silahkan hubungi administrator!');
          return redirect()->route('auth.login');
        }
      } else {
        Session::flash('error', 'Maaf, email sudah pernah digunakan!');
        return redirect()->route('auth.register');
      }
    }
  }

  public function verifyToken(Request $request) {
    $checkToken = User::where('status', '0')->where('remember_token', $request->id)->first();
    if ($checkToken) {
      User::where('remember_token', $request->id)->update([ 'status' => '1', 'remember_token' => 'null' ]);
      Session::flash('success', 'Selamat, akun anda berhasil diaktivasi!');
      return redirect()->route('auth.login');
    } else {
      Session::flash('error', 'Maaf, kode token anda telah kadaluarsa!');
      return redirect()->route('auth.login');
    }
  }
}