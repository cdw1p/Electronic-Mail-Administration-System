<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class Role
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  ...$role
   */
  public function handle($request, Closure $next, ... $role)
  {
    if (in_array('guest', $role)) {
      if (Auth::check()) {
        return redirect()->route('dashboard.index');
      }
      return $next($request);
    }

    if (!Auth::check()) {
      return redirect()->route('auth.login');
    } else {
      if (Auth::user()->status == '0') {
        Auth::logout();
        Session::flash('error', 'Maaf, akun anda belom diaktifkan. Silahkan cek email untuk mengaktifkan akun!');
        return redirect()->route('auth.login');
      }
    }

    // if (Auth::user()->role == 1) {
    //   return redirect()->route('superadmin');
    // }

    return $next($request);
  }
}