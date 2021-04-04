<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    }

    // if (Auth::user()->role == 1) {
    //   return redirect()->route('superadmin');
    // }

    return $next($request);
  }
}