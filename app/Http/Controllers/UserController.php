<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
  public function index() {
    return view('pages.user.user-data', [ 'user' => User::class ]);
  }

  public function logout() {
    Auth::logout();
    return redirect()->route('auth.login');
  }
}