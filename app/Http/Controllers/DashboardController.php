<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Attendance;

class DashboardController extends Controller
{
  public function index() {
    if (Auth::user()->role === 'admin') {
      $query = [
        'total_vidcon' => Room::count(),
        'total_attendance' => Attendance::count(),
        'total_users' => User::count(),
      ];
    } else {
      $query = [
        'total_vidcon' => Invitation::join('rooms', 'invitations.room_id', '=', 'rooms.zoom_id')->where('invitations.participants', 'like', '%' . Auth::user()->email . '%')->count(),
        'total_attendance' => Attendance::where('email', Auth::user()->email)->count(),
        'total_users' => User::where('email', Auth::user()->email)->count(),
      ];
    }
    return view('dashboard/home', ['data' => $query]);
  }

  public function logout() {
    Auth::logout();
    return redirect()->route('auth.login');
  }
}
